<?php
session_start(); // Start the session

// Include database connection
include("db.php");

// Fetch all videos except the ones uploaded by the logged-in user
$username = $_SESSION['username']; // Get the logged-in user's username
$sql = "SELECT * FROM videos WHERE username != '$username'"; // Exclude user's own uploads
$result = $conn->query($sql);

// Initialize a variable to store the success message for the specific comment
$commentPostedId = null;

// Handle comment submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['comment'])) {
    $video_id = $_POST['video_id'];
    $video_title = $_POST['video_title'];
    $comment = mysqli_real_escape_string($conn, $_POST['comment']);
    $sql_insert_comment = "INSERT INTO video_comments (username, video_title, comment, video_id) VALUES ('$username', '$video_title', '$comment', '$video_id')";
   
    if ($conn->query($sql_insert_comment) === TRUE) {
        $commentPostedId = $video_id; // Store the video ID where the comment was posted
    } else {
        $commentPostedId = null; // If error, do nothing
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Videos</title>
    <style>
        body, html {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 20px;
        }

        .video-container {
            margin-bottom: 30px;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        video {
            max-width: 100%;
            border-radius: 8px;
        }

        .video-details {
            margin-top: 10px;
        }

        .video-title {
            font-size: 20px;
            font-weight: bold;
        }

        .video-time {
            font-size: 14px;
            color: gray;
        }

        .comment-box {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-top: 10px;
            font-size: 14px;
        }

        .submit-comment {
            padding: 10px;
            background-color: #ff6347;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .submit-comment:hover {
            background-color: #e5533c;
        }

        .comments {
            margin-top: 20px;
        }

        .comment {
            margin-bottom: 15px;
            padding: 10px;
            background-color: #f8f8f8;
            border-radius: 5px;
        }

        .comment-user {
            font-weight: bold;
        }

        .comment-time {
            font-size: 12px;
            color: gray;
        }

        .success-message {
            color: green;
            font-weight: bold;
            margin-top: 10px;
        }
    </style>
</head>
<body>
<p align="right">
    <a href="user_dashboard.php" class="logout-btn">Logout</a>
</p>

<style>
    .logout-btn {
        display: inline-block;
        padding: 10px 20px;
        background-color: #ff6347;
        color: white;
        font-weight: bold;
        text-decoration: none;
        border-radius: 5px;
        transition: background-color 0.3s, transform 0.3s;
    }

    .logout-btn:hover {
        background-color: #e5533c;
        transform: scale(1.1); /* Slightly enlarge the button on hover */
    }

    .logout-btn:focus {
        outline: none;
    }
</style>

<h1 align="center"> Videos</h1>

<?php
if ($result->num_rows > 0) {
    // Output each video
    while ($row = $result->fetch_assoc()) {
        $video_id = $row['video_id'];
        $video_title = $row['video_name'];
        $video_path = $row['video_path'];
        $upload_time = $row['upload_date'];

        echo "<div class='video-container'>";
        echo "<video controls><source src='$video_path' type='video/mp4'></video>";
        echo "<div class='video-details'>";
        echo "<p class='video-title'>$video_title</p>";
        echo "<p class='video-time'>Uploaded on: $upload_time</p>";
        echo "</div>";

        // Show comments for this video
        $sql_comments = "SELECT * FROM video_comments WHERE video_id = '$video_id' ORDER BY comment_time DESC";
        $comment_result = $conn->query($sql_comments);
        
        echo "<div class='comments'>";
        while ($comment_row = $comment_result->fetch_assoc()) {
            $comment_user = $comment_row['username'];
            $comment_text = $comment_row['comment'];
            $comment_time = $comment_row['comment_time'];
            echo "<div class='comment'>";
            echo "<p class='comment-user'>$comment_user <span class='comment-time'>on $comment_time</span></p>";
            echo "<p>$comment_text</p>";
            echo "</div>";
        }
        echo "</div>";

        // Comment form
        echo "<form method='POST' action='view_video.php'>
                <input type='hidden' name='video_id' value='$video_id'>
                <input type='hidden' name='video_title' value='$video_title'>
                <textarea name='comment' class='comment-box' placeholder='Add your comment...' required></textarea><br>
                <br>
                <button type='submit' class='submit-comment'>Post Comment</button>
              </form>";

        // Show success message ONLY for the specific video where the comment was posted
        if ($commentPostedId == $video_id) {
            echo "<p class='success-message'>Comment posted successfully!</p>";
        }
        
        echo "</div>";
    }
} else {
    echo "<p>No videos available.</p>";
}
?>

</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
