<?php
require_once 'includes/auth.php';
if (!is_logged_in()) header("Location: login.php");
?>
<!DOCTYPE html>
<html>
<head>
  <title>Dashboard</title>
  <link rel="stylesheet" href="assets/styles.css">
</head>
<body>
  <div class="container">
    <h1>Welcome, <?= htmlspecialchars($_SESSION['user_id']) ?>!</h1>
    <a href="index.php">Go to Tasks</a> | 
    <a href="logout.php">Logout</a>
  </div>
</body>
</html>