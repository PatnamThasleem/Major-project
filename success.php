<?php
// success.php
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Created Successfully</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

    <script>
        Swal.fire({
            title: 'Success!',
            text: 'Your account has been created successfully.',
            icon: 'success',
            confirmButtonText: 'OK'
        }).then(() => {
            // After the success message, redirect to the login page
            window.location.href = 'user_login.php';
        });
    </script>

</body>
</html>
