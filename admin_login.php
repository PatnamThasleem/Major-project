<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Sentiment Analysis</title>
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

        .login-container {
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

        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
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

        .error-message {
            color: red;
            font-size: 14px;
            margin-top: 10px;
        }
    </style>
</head>
<body>

    <div class="login-container">
        <h2>Admin Login</h2>
        <form action="admin_login.php" method="POST">
            <input type="text" name="admin_username" placeholder="Admin Username" required>
            <input type="password" name="admin_password" placeholder="Admin Password" required>
            <button type="submit">Login</button>
        </form>
        <div class="error-message">
            <?php
            session_start();

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // Get the form inputs
                $username = $_POST['admin_username'];
                $password = $_POST['admin_password'];

                // Check if the credentials are correct
                if ($username === 'admin' && $password === 'admin') {
                    // Start session and redirect to admin panel
                    $_SESSION['admin_username'] = $username;
                    header("Location: admin_dashboard.php"); // Redirect to admin panel
                    exit();
                } else {
                    // Show error message if credentials are incorrect
                    echo "Incorrect username or password.";
                }
            }
            ?>
        </div>
    </div>

</body>
</html>
