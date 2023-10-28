<?php


include 'dbconfig.php';
include 'password-helper.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get data
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $number = $_POST['number'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $verification_code = $_POST['verification_code'];

    // Define a regular expression for the phone number
    $numberPattern = '/^09\d{9}$/';

    // Check if the number is valid
    if (preg_match($numberPattern, $number)) {
        // Phone number is valid

        // Check if the password meets the minimum requirements
        if (preg_match('/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@#$%^&!])[A-Za-z\d@#$%^&!]{8,}$/', $password)) {
            // Password is strong

            // Check if the password and confirm password match
            if ($password === $confirm_password) {

                // Proceed to verification of the verification code
                $sql = "SELECT * FROM verification_codes WHERE secret = ?";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$verification_code]);

                if ($stmt->rowCount() > 0) {
                    // Verification code is correct

                    // Proceed with registration
                    $hashed_password = PasswordHelper::hashPassword($password);

                    // Insert the user data into the database
                    $sql = "INSERT INTO administrators (first_name, last_name, number, email, password, verification_code) VALUES (?, ?, ?, ?, ?, ?)";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute([$first_name, $last_name, $number, $email, $hashed_password, $verification_code]);

                    if ($stmt->rowCount() > 0) {
                        echo 'oki na';
                        // Registration was successful
                        session_start();
                        $_SESSION['admin-registered'] = true;

                        header('Location: admin-reg-success.php');
                    } else {
                        // Registration failed
                        echo 'Error registering the admin. Please try again or contact the administrator.';
                        header('Location: index.html');
                    }
                } else {
                    // Verification code is incorrect

                    header("Location: admin-verification-code-error.php");
                }
            } else {

                // Passwords do not match
                echo '<script>window.alert("Password dont match")</script>';
            }
        } else {
            // Password is not strong enough
            echo 'Password requirements: Minimum 8 characters, at least one uppercase letter, one lowercase letter, one digit, and one special character (@, #, $, %, ^, &, !).';
        }
    } else {
        // Invalid phone number format
        echo 'Invalid phone number format. It should be an 11-digit number starting with 09.';
    }
}
