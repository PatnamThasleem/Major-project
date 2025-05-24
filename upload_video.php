<?php
session_start(); // Start the session

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: user_login.php"); // Redirect to login if not logged in
    exit();
}

// Include database connection
include("db.php");

$message = "";  // Variable to store success or error message

// Handle video upload
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['video'])) {
    // Path where the video will be stored
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["video"]["name"]);
    
    // Check if the file is a video (basic check for demonstration)
    $videoFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $allowed_types = array("mp4", "avi", "mov", "mkv", "flv");
    
    if (in_array($videoFileType, $allowed_types)) {
        // Try to move the uploaded file
        if (move_uploaded_file($_FILES["video"]["tmp_name"], $target_file)) {
            // Video uploaded successfully, now store its details in the database
            $username = $_SESSION['username'];
            $video_name = basename($_FILES["video"]["name"]);
            $video_path = $target_file;

            // Prepare SQL query to insert video details into the database
            $sql = "INSERT INTO videos (username, video_name, video_path) VALUES ('$username', '$video_name', '$video_path')";

            if ($conn->query($sql) === TRUE) {
                // Success: Display success message
                $message = "<p style='color: green; font-weight: bold;'>Video uploaded and details stored successfully!</p>";
            } else {
                // Error inserting details into the database
                $message = "<p style='color: red; font-weight: bold;'>Error: Could not store video details.</p>";
            }
        } else {
            // Error uploading the file
            $message = "<p style='color: red; font-weight: bold;'>Sorry, there was an error uploading your video.</p>";
        }
    } else {
        // Invalid file type
        $message = "<p style='color: red; font-weight: bold;'>Only video files are allowed.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Video - Sentiment Analysis</title>
    <style>
        body, html {
            font-family: Arial, sans-serif;
            height: 100%;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #f4f4f9;
        }

        .upload-container {
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
        }

        h2 {
            margin-bottom: 20px;
            font-size: 24px;
            color: #333;
        }

        input[type="file"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            width: 100%;
            padding: 12px;
            border: none;
            background-color: #ff6347;
            color: white;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #e5533c;
        }

        /* Style for message below the button */
        .message {
            margin-top: 15px;
            font-size: 14px;
            text-align: center;
        }
    </style>
</head>
<body>

    <div class="upload-container">
        <h2>Upload Video</h2>
        <form action="upload_video.php" method="POST" enctype="multipart/form-data">
            <input type="file" name="video" required>
            <button type="submit">Upload</button>
        </form>

        <!-- Display the message below the button -->
        <div class="message">
            <?php echo $message; ?>
        </div>

        <a href="user_dashboard.php">back</a>
    </div>

</body>
</html>
