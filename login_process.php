<?php
session_start(); // Start the session

include("db.php"); // Include the database connection

// Collect form data
$username = $_POST['username'];
$password = $_POST['password']; // Plain text password

// Query to check if the username exists
$sql = "SELECT * FROM users_logs WHERE username = '$username'";
$result = $conn->query($sql);

// Check if a user with the given username exists
if ($result->num_rows > 0) {
    // Fetch user data
    $row = $result->fetch_assoc();
    
    // Compare the entered password with the stored password (plain text)
    if ($password == $row['password']) {
        // Password is correct, create a session
        $_SESSION['username'] = $username;
        
        // Redirect to the dashboard or main page
        header("Location: user_dashboard.php");
        exit();
    } else {
        // Invalid password, show SweetAlert with error
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo "<script>
            window.onload = function() {
                Swal.fire({
                    title: 'Invalid Credentials',
                    text: 'Incorrect username or password!',
                    icon: 'error',
                    confirmButtonText: 'OK'
                }).then(() => {
                    window.location.href = 'user_login.php'; // Redirect back to login page
                });
            }
        </script>";
    }
} else {
    // Username does not exist, show SweetAlert with error
    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
    echo "<script>
        window.onload = function() {
            Swal.fire({
                title: 'Invalid Credentials',
                text: 'Incorrect username or password!',
                icon: 'error',
                confirmButtonText: 'OK'
            }).then(() => {
                window.location.href = 'user_login.php'; // Redirect back to login page
            });
        }
    </script>";
}

// Close the database connection
$conn->close();
?>
