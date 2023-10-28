<?php
include '../../database/dbconfig.php';
include 'password-helper.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get Data
    $admin_id = $_POST['admin-id'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM admins WHERE admin_id = :admin_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':admin_id', $admin_id);
    $stmt->execute();

    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($admin) {
        // User found
        $hashedPassword = $admin['password'];

        //admin secret code: @CnFdnt4L

        if (PasswordHelper::verifyPassword($password, $hashedPassword)) {
            // Passwords match; user is authenticated
            // Proceed with login

            session_start();
            $_SESSION['admin-authorized'] = true;

            header('Location: berrieddelight/mirage-edge.php');
            echo 'good';
        } else {
            header('Location: ../../fail/invalid-credentials.php');
        }
    } else {
        //No user
        header('Location: ../../fail/invalid-credentials.php');
    }
}
