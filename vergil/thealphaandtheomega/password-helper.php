<?php
class PasswordHelper {
    public static function hashPassword($password) {
        // Generate a secure hash
        $options = ['cost' => 12]; // Adjust the cost as needed
        return password_hash($password, PASSWORD_BCRYPT, $options);
    }

    public static function verifyPassword($password, $hash) {
        return password_verify($password, $hash);
    }
}
?>
