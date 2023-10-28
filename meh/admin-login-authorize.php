<?php
include 'dbconfig.php';
include 'password-helper.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get Data
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validate email and password
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Handle invalid email format
        echo 'Invalid email format.';
    } else {
        // Check if the user exists in the database
        $sql = "SELECT * FROM administrators WHERE email = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$email]);
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($admin) {
            // User with provided email exists
            if (PasswordHelper::verifyPassword($password, $admin['password'])) {
                // Password is correct, create a session for the admin
                session_start();
                $_SESSION['admin_id'] = $admin['id'];
                
                // Redirect the admin to the admin dashboard or another secure page
                header('Location: admin-control-panel.php');
                exit();
            } else {
                // Password is incorrect
                echo 'Invalid password.';
            }
        } else {
            // User does not exist
            echo 'User with this email does not exist.';
        }
    }
}
