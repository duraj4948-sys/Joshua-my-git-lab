<?php
// --- Generate Password ---
// This function creates a random password based on user-selected criteria.
function generate_password($length = 12, $use_letters = true, $use_numbers = true, $use_symbols = true) {
    $chars = '';

    // Combine characters depending on user choices
    if ($use_letters) $chars .= 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    if ($use_numbers) $chars .= '0123456789';
    if ($use_symbols) $chars .= '!@#$%^&*()-_=+[]{}|;:,.<>?/`~';

    // Return empty if no character type is selected
    if (empty($chars)) return '';

    $password = '';

    // Loop to randomly select characters from the allowed set
    for ($i = 0; $i < $length; $i++) {
        $password .= $chars[random_int(0, strlen($chars) - 1)];
    }

    return $password;
}

// --- Password Strength ---
// This function checks the strength of the generated password.
function password_strength($password) {
    $score = 0;
    $length = strlen($password);

    // Add points based on password length
    if ($length >= 8) $score++;
    if ($length >= 12) $score++;
    if ($length >= 16) $score++;

    // Add points based on character variety
    if (preg_match('/[a-z]/', $password)) $score++;
    if (preg_match('/[A-Z]/', $password)) $score++;
    if (preg_match('/[0-9]/', $password)) $score++;
    if (preg_match('/[^a-zA-Z0-9]/', $password)) $score++;

    // Convert score to percentage for visual strength indicator
    $percentage = min(100, ($score / 7) * 100);

    // Return strength category, color, and score percentage
    if ($score <= 2) return ['WEAK', '#e74c3c', $percentage];
    elseif ($score <= 4) return ['MEDIUM', '#f1c40f', $percentage];
    else return ['STRONG', '#2ecc71', $percentage];
}

// --- Handle Form ---
// This section handles POST data and generates the password when the form is submitted.
$password = '';
$strength = ['', '', 0];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form inputs (or defaults)
    $length = intval($_POST['length'] ?? 12);
    $use_letters = isset($_POST['letters']);
    $use_numbers = isset($_POST['numbers']);
    $use_symbols = isset($_POST['symbols']);

    // Generate new password
    $password = generate_password($length, $use_letters, $use_numbers, $use_symbols);

    // Evaluate its strength
    $strength = password_strength($password);
}
?>
