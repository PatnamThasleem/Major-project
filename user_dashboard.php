<?php
session_start(); // Start the session

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: user_login.php"); // Redirect to login if not logged in
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard - Sentiment Analysis</title>
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

        .dashboard-container {
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

        .logout {
            margin-top: 20px;
        }
    </style>
</head>
<body>

    <div class="dashboard-container">
        <h2>Welcome, <?php echo $_SESSION['username']; ?>!</h2>
        <p>Choose an option to proceed:</p>
        <form action="upload_video.php" method="GET">
            <button type="submit">Upload Video</button>
        </form>
        <br>
        <form action="view_video.php" method="GET">
            <button type="submit">View Videos</button>
        </form>
<br>
        <div >
        <p align="right">
  <a href="logout.php" style="text-decoration: none; font-size: 16px; color: #FF6347; font-weight: bold; transition: color 0.3s ease;">
    Logout
  </a>
</p>

<style>
  a:hover {
    color: #FF4500;
    text-decoration: underline;
  }
</style>

           
        </div>
    </div>

</body>
</html>
