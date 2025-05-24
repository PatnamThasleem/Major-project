<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Sentiment Analysis</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body, html {
            height: 100%;
            font-family: Arial, sans-serif;
        }

        .hero {
            background-image: url('https://via.placeholder.com/1920x1080'); /* Replace with your image URL */
            background-size: cover;
            background-position: center;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            color: white;
            font-size: 2rem;
            text-shadow: 2px 2px 10px rgba(0, 0, 0, 0.7);
        }

        .hero div {
            max-width: 500px;
            background-color: rgba(0, 0, 0, 0.5);
            padding: 30px;
            border-radius: 10px;
        }

        .hero h1 {
            font-size: 2.5rem;
            margin-bottom: 20px;
        }

        .hero p {
            font-size: 1.2rem;
            margin-bottom: 30px;
        }

        .hero button {
            padding: 10px 20px;
            font-size: 1rem;
            border: none;
            background-color: #ff6347;
            color: white;
            cursor: pointer;
            border-radius: 5px;
            margin: 10px;
            transition: background-color 0.3s;
        }

        .hero button:hover {
            background-color: #e5533c;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .hero h1 {
                font-size: 2rem;
            }

            .hero p {
                font-size: 1rem;
            }

            .hero button {
                font-size: 0.9rem;
            }
        }

        @media (max-width: 480px) {
            .hero h1 {
                font-size: 1.8rem;
            }

            .hero p {
                font-size: 0.9rem;
            }

            .hero button {
                font-size: 0.8rem;
            }
        }
    </style>
</head>
<body>

    <div class="hero">
        <div>
            <h1>Welcome to Sentiment Analysis!</h1>
            <p>Unlock the power of AI to analyze emotions, opinions, and feedback from sources like social media and reviews.</p>
            <p>Gain valuable insights into public sentiment and customer feedback in just a few clicks!</p>
            <button onclick="window.location.href='user_login.php';">User Login</button>
            <button onclick="window.location.href='admin_login.php';">Admin Login</button>
        </div>
    </div>

</body>
</html>
