<?php
// Include your database configuration file
include 'dbconfig.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the verification code from the POST data
    $verification_code = $_POST['verification_code'];

    // Perform the verification against your database
    $sql = "SELECT * FROM verification_codes WHERE secret = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$verification_code]);

    if ($stmt->rowCount() > 0) {
        // Verification code is correct
        echo 'valid';
    } else {
        // Verification code is incorrect
        echo 'Invalid verification code';
    }
} else {
    echo 'Invalid request method';
}
