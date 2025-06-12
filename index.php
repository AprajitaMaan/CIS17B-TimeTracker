<?php
require_once 'includes/auth.php';

if (!is_logged_in()) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Time Tracker</title>
    <link rel="stylesheet" href="assets/styles.css">
</head>
<body>
    <div class="container">
        <h1>Time Tracker <?= is_admin() ? '<span class="admin-badge">ADMIN</span>' : '' ?></h1>
        
        <div class="user-info">
            Logged in as: <?= htmlspecialchars($_SESSION['user_id']) ?>
            | <a href="logout.php">Logout</a>
        </div>
        
        <?php if (is_admin()): ?>
    <div class="admin-panel">
        <h2>User Management</h2>
        <button id="refresh-btn" class="btn">Refresh List</button>
        <div id="users-container" data-current-user="<?= htmlspecialchars($_SESSION['user_id']) ?>">
            Loading user data...
        </div>
    </div>
    <script src="assets/admin.js"></script>
<?php endif; ?>
        
        <div class="user-panel">
            <h2>My Tasks</h2>
            <form id="task-form">
                <input type="text" id="task-name" placeholder="New task" required>
                <button type="submit" class="btn">Add Task</button>
            </form>
            <div id="task-list"></div>
        </div>
    </div>
    
    <script src="assets/app.js"></script>
    <?php if (is_admin()): ?>
        <script src="assets/admin.js"></script>
    <?php endif; ?>
</body>
</html>