<?php
include("db.php");

// Collect form data
$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];

// Insert query
$sql = "INSERT INTO users_logs (username, email, password) VALUES ('$username', '$email', '$password')";

// Execute the query
if ($conn->query($sql) === TRUE) {
    // Redirect to a success page
    header("Location: success.php");
    exit();
} else {
    // Redirect to an error page
    header("Location: error.php");
    exit();
}

// Close the database connection
$conn->close();
?>
