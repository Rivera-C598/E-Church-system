<?php
include '../database/dbconfig.php';
include 'thealphaandtheomega/password-helper.php'; // Include your database configuration

try {
    // Fetch plain-text passwords from your users table
    $sql = "SELECT id, password FROM admins"; // Replace with your table and column names
    $stmt = $pdo->query($sql);

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // Hash the password using password_hash

        $hashedPassword = PasswordHelper::hashPassword($row['password']);

        if ($hashedPassword === false) {
            // Handle the case where password_hash fails
            die("Error: Password hashing failed.");
        }

        // Update the user's password in the database
        $updateSql = "UPDATE admins SET password = :hashedPassword WHERE id = :id"; // Replace with your table and column names
        $updateStmt = $pdo->prepare($updateSql);
        $updateStmt->execute([':hashedPassword' => $hashedPassword, ':id' => $row['id']]);

        if ($updateStmt->rowCount() === 0) {
            // Handle the case where the update didn't affect any rows
            die("Error: Password update failed for user ID " . $row['id']);
        }
    }

    echo "Passwords have been hashed and updated successfully.";
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
