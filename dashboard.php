<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Dashboard - Time Tracker</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <h2>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
  <p><a href="logout.php">Logout</a></p>

  <!-- Future dashboard content -->
  <ul>
    <li><a href="index.html">Go to Task Tracker</a></li>
  </ul>
</body>
</html>
