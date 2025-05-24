<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome Page</title>
    <style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body,
    html {
        height: 100%;
        font-family: Arial, sans-serif;
    }

    .hero {
        background-image: url('https://via.placeholder.com/1920x1080');
        /* Replace with your image URL */
        background-size: cover;
        background-position: center;
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        text-align: center;
        color:white;
        font-size: 2rem;
        text-shadow: 2px 2px 10px rgba(0, 0, 0, 0.7);
    }

    .hero h1 {
        font-size: 3rem;
        margin-bottom: 20px;
    }

    .hero p {
        font-size: 1.25rem;
        margin-bottom: 30px;
    }

    .hero button {
        padding: 10px 20px;
        font-size: 1rem;
        border: none;
        background-color:rgb(255, 99, 71);
        color: white;
        cursor: pointer;
        border-radius: 5px;
        transition: background-color 0.3s;
    }

    .hero button:hover {
        background-color: #e5533c;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .hero h1 {
            font-size: 2.5rem;
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
            font-size: 2rem;
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

<body >
    <div class="hero">
    <div>
    <h1 style="color:green">Welcome to Sentiment Analysis!</h1>
    <p style="color:green">Unlock the power of AI to analyze emotions, opinions, and feedback from sources like social media and reviews.</p>
    <p style="color:green">Gain valuable insights into public sentiment and customer feedback in just a few clicks!</p>
    <button onclick="window.location.href='login.php';">Get Started</button>
</div>


    </div>

</body>

</html>