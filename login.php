<?php
session_start();

// Hardcoded demo admin account
$adminUser = 'admin';
$adminPass = 'admin123';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    if ($user === $adminUser && $pass === $adminPass) {
        $_SESSION['username'] = $user;
        header("Location: dashboard.php");
        exit;
    } else {
        echo "<p style='color:red;'>Invalid login.</p>";
    }
}
?>
