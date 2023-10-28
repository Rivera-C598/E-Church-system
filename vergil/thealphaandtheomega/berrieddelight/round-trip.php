<?php
// Add new Admin reference processing script
include '../../../dbconfig.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Get Data
        $admin_id = $_POST['adminId'];
        $last_name = sanitizeInput($_POST['lastName']);
        $first_name = sanitizeInput($_POST['firstName']);
        $email = sanitizeInput($_POST['email']);
        $number = $_POST['number'];
        $verification_code = sanitizeInput($_POST['verificationCode']);

        // Validate the "number" field
        if (!is_numeric($number)) {
            echo 'error';
            exit; // Stop execution if the number is not numeric.
        }

        // Validate the email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo 'error';
            exit; // Stop execution if the email is not valid.
        }

        $sql = "INSERT into admin_reference_table(admin_id, first_name, last_name, email, phone_number, verification_code) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$admin_id, $first_name, $last_name, $email, $number, $verification_code]);

        if ($stmt->rowCount() > 0) {
            echo 'success';
        } else {
            echo 'error';
        }
    } catch (PDOException $e) {
        // Handle the SQL error
        echo 'SQL Error: ' . $e->getMessage();
    }
}

function sanitizeInput($input)
{
    // You can add additional sanitization here if needed.
    return htmlspecialchars(strip_tags($input), ENT_QUOTES, 'UTF-8');
}
