<?php
$usersFile = 'users.json';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    $users = file_exists($usersFile) ? json_decode(file_get_contents($usersFile), true) : [];

    if (isset($users[$user])) {
        echo "<p style='color:red;'>User already exists.</p>";
    } else {
        $users[$user] = password_hash($pass, PASSWORD_DEFAULT);
        file_put_contents($usersFile, json_encode($users));
        header("Location: login.html");
        exit;
    }
}
?>
