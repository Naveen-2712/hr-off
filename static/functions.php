<?php
// Define encryption constants (use secure, randomly generated strings in production)
define('ENCRYPTION_KEY', 'b5b8e3b7f8e6c59d2164d5a2f1e7b8a7'); // 32-char key for AES-256
define('ENCRYPTION_IV', '16CharFixedIvStr'); // 16-char IV for AES-256-CBC

/**
 * Encrypts a given password using AES-256-CBC encryption.
 *
 * @param string $password The password to encrypt.
 * @return string The encrypted password, base64 encoded.
 */
function encryptPassword($password) {
    $key = hash('sha256', ENCRYPTION_KEY); // Hash the key to ensure it's 256 bits
    $iv = substr(ENCRYPTION_IV, 0, 16);    // Use the defined IV
    return base64_encode(openssl_encrypt($password, 'AES-256-CBC', $key, 0, $iv));
}

/**
 * Decrypts an encrypted password using AES-256-CBC encryption.
 *
 * @param string $encryptedPassword The encrypted password (base64 encoded).
 * @return string The decrypted password.
 */
function decryptPassword($encryptedPassword) {
    $key = hash('sha256', ENCRYPTION_KEY); // Hash the key to ensure it's 256 bits
    $iv = substr(ENCRYPTION_IV, 0, 16);    // Use the defined IV
    return openssl_decrypt(base64_decode($encryptedPassword), 'AES-256-CBC', $key, 0, $iv);
}

/**
 * Generates a secure random password.
 *
 * @param int $length Length of the password to generate.
 * @return string A random password.
 */
function generateRandomPassword($length = 12) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*()';
    $password = '';
    for ($i = 0; $i < $length; $i++) {
        $password .= $characters[random_int(0, strlen($characters) - 1)];
    }
    return $password;
}
?>
