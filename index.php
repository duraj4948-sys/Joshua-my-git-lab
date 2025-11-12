echo "<?php 
function generate_password(\$length = 12, \$use_letters = true, \$use_numbers = true, \$use_symbols = true) {
    \$chars = '';
    if (\$use_letters) \$chars .= 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    if (\$use_numbers) \$chars .= '0123456789';
    if (\$use_symbols) \$chars .= '!@#$%^&*()-_=+[]{}|;:,.<>?/`~';
    if (empty(\$chars)) return '';
    \$password = '';
    for (\$i = 0; \$i < \$length; \$i++) {
        \$password .= \$chars[random_int(0, strlen(\$chars) - 1)];
    }
    return \$password;
}

function password_strength(\$password) {
    \$score = 0;
    \$length = strlen(\$password);
    if (\$length >= 8) \$score++;
    if (\$length >= 12) \$score++;
    if (\$length >= 16) \$score++;
    if (preg_match('/[a-z]/', \$password)) \$score++;
    if (preg_match('/[A-Z]/', \$password)) \$score++;
    if (preg_match('/[0-9]/', \$password)) \$score++;
    if (preg_match('/[^a-zA-Z0-9]/', \$password)) \$score++;
    \$percentage = min(100, (\$score / 7) * 100);
    if (\$score <= 2) return ['WEAK', '#e74c3c', \$percentage];
    elseif (\$score <= 4) return ['MEDIUM', '#f1c40f', \$percentage];
    else return ['STRONG', '#2ecc71', \$percentage];
}

\$password = '';
\$strength = ['', '', 0];

if (\$_SERVER['REQUEST_METHOD'] === 'POST') {
    \$length = intval(\$_POST['length'] ?? 12);
    \$use_letters = isset(\$_POST['letters']);
    \$use_numbers = isset(\$_POST['numbers']);
    \$use_symbols = isset(\$_POST['symbols']);
    \$password = generate_password(\$length, \$use_letters, \$use_numbers, \$use_symbols);
    \$strength = password_strength(\$password);
}
?>" > index.php
