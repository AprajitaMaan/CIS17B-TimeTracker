<?php
require_once 'includes/auth.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $is_admin = isset($_POST['is_admin']);
    $errors = [];

    if (empty($username) || !preg_match('/^[a-zA-Z0-9_]{3,20}$/', $username)) {
        $errors[] = "Username must be 3-20 characters (letters, numbers, _)";
    }

    if (empty($password) || !preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/', $password)) {
        $errors[] = "Password must contain: 8+ chars, 1 uppercase, 1 lowercase, 1 number";
    }

    if (empty($errors)) {
        if (register($username, $password, $is_admin)) {
            $_SESSION['user_id'] = $username;
            $_SESSION['is_admin'] = $is_admin;
            header("Location: index.php");
            exit;
        } else {
            $errors[] = "Username already exists";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" href="assets/styles.css">
</head>
<body>
    <div class="container">
        <h1>Register</h1>
        <?php if (!empty($errors)): ?>
            <div class="alert">
                <?php foreach ($errors as $error): ?>
                    <p><?= htmlspecialchars($error) ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        
        <form method="POST">
            <div class="form-group">
                <label>Username:</label>
                <input type="text" name="username" required>
            </div>
            <div class="form-group">
                <label>Password:</label>
                <input type="password" name="password" required>
            </div>
            <div class="form-group">
                <label>
                    <input type="checkbox" name="is_admin">
                    Register as administrator
                </label>
            </div>
            <button type="submit">Register</button>
        </form>
        <p>Already have an account? <a href="login.php">Login</a></p>
    </div>
</body>
</html>