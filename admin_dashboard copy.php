<?php
session_start();

// Check if the admin is logged in
if (!isset($_SESSION['admin_username'])) {
    header("Location: admin_login.php");
    exit();
}

include("db.php");

// Fetch all videos uploaded by users
$sql_videos = "SELECT * FROM videos WHERE username != 'admin'";
$videos_result = $conn->query($sql_videos);

$sentiment_results = [];

if (isset($_POST['analyze_comments'])) {
    $video_id = $_POST['video_id'];

    $sql_comments = "SELECT comment FROM video_comments WHERE video_id = '$video_id'";
    $comments_result = $conn->query($sql_comments);
    $comments = [];

    while ($comment = $comments_result->fetch_assoc()) {
        $comments[] = $comment['comment'];
    }

    $comments_json = json_encode($comments, JSON_UNESCAPED_UNICODE);
    $command = "python sentiment_analysis.py";
    $process = proc_open($command, [
        0 => ["pipe", "r"],
        1 => ["pipe", "w"],
        2 => ["pipe", "w"]
    ], $pipes);

    if (is_resource($process)) {
        fwrite($pipes[0], $comments_json);
        fclose($pipes[0]);

        $output = stream_get_contents($pipes[1]);
        fclose($pipes[1]);

        $error = stream_get_contents($pipes[2]);
        fclose($pipes[2]);

        proc_close($process);

        $sentiment_data = json_decode(trim($output), true);
        if ($sentiment_data) {
            $sentiment_results[$video_id] = $sentiment_data;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Video Analysis</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body { background-color: #f4f7fc; font-family: 'Arial', sans-serif; }
        .navbar { background-color: #343a40; padding: 15px; }
        .navbar-brand, .nav-link { color: #ffffff !important; }
        .dashboard-container { max-width: 900px; margin: auto; padding-top: 30px; }
        .video-card { background: #ffffff; padding: 20px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); }
        .btn-primary, .btn-info { width: 100%; }
        .modal-content { border-radius: 10px; }
        .sentiment-values { font-size: 18px; font-weight: bold; text-align: center; margin-top: 10px; }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Admin Dashboard</a>
            <a href="admin_logout.php" class="btn btn-danger">Logout</a>
        </div>
    </nav>

    <div class="container dashboard-container">
        <h2 class="text-center mb-4">Welcome, Admin</h2>
        <div class="row">
            <?php if ($videos_result->num_rows > 0) { while ($video = $videos_result->fetch_assoc()) { ?>
                <div class="col-md-6 mb-4">
                    <div class="video-card">
                        <h5><?php echo htmlspecialchars($video['video_name']); ?></h5>
                        <video width="100%" height="240" controls>
                            <source src="<?php echo htmlspecialchars($video['video_path']); ?>" type="video/mp4">
                        </video>
                        <form action="admin_dashboard.php" method="POST" class="mt-2">
                            <input type="hidden" name="video_id" value="<?php echo $video['video_id']; ?>">
                            <button type="submit" class="btn btn-primary" name="analyze_comments">Analyze</button>
                        </form>
                        <?php if (isset($sentiment_results[$video['video_id']])) { ?>
                            <button class="btn btn-info mt-2" onclick="showModal(<?php echo $video['video_id']; ?>, <?php echo $sentiment_results[$video['video_id']]['positive_count']; ?>, <?php echo $sentiment_results[$video['video_id']]['negative_count']; ?>)">View Analysis</button>
                        <?php } ?>
                    </div>
                </div>
            <?php } } else { ?>
                <p class='text-center text-muted'>No videos available.</p>
            <?php } ?>
        </div>
    </div>

    <!-- Modal for Sentiment Analysis -->
    <div class="modal fade" id="analysisModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Sentiment Analysis</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <canvas id="sentimentChart"></canvas>
                    <div id="sentimentValues" class="sentiment-values"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showModal(videoId, positive, negative) {
            var ctx = document.getElementById('sentimentChart').getContext('2d');

            // Ensure old chart is destroyed before creating a new one
            if (window.sentimentChart instanceof Chart) {
                window.sentimentChart.destroy();
            }

            // Create a new Chart instance
            window.sentimentChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Positive', 'Negative'],
                    datasets: [{
                        label: 'Sentiment Count',
                        data: [positive, negative],
                        backgroundColor: ['green', 'red']
                    }]
                },
                options: { responsive: true }
            });

            // Update sentiment text values
            document.getElementById('sentimentValues').innerHTML = `
                <p>Positive: <span style="color:green;">${positive}</span></p>
                <p>Negative: <span style="color:red;">${negative}</span></p>
            `;

            // Show Bootstrap modal
            new bootstrap.Modal(document.getElementById('analysisModal')).show();
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
