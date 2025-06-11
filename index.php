<?php
require_once 'includes/auth.php';
if (!is_logged_in()) header("Location: login.php");
?>
<!DOCTYPE html>
<html>
<head>
  <title>Time Tracker</title>
  <link rel="stylesheet" href="assets/styles.css">
</head>
<body>
  <div class="container">
    <h1>Time Tracker</h1>
    <a href="logout.php">Logout</a>
    
    <form id="task-form">
      <input type="text" id="task-name" placeholder="New task" required>
      <button type="submit">Add Task</button>
    </form>
    
    <div id="task-list"></div>
  </div>
  
  <script src="assets/app.js"></script>
</body>
</html>