<?php
session_start();

function is_logged_in() {
    return isset($_SESSION['user_id']);
}

function is_admin() {
  return isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === true;
}

function get_all_users() {
    $users_file = __DIR__ . '/../users.json';
    return file_exists($users_file) ? json_decode(file_get_contents($users_file), true) : [];
}

function register($username, $password, $is_admin = false) {
    $users = get_all_users();
    
    if (isset($users[$username])) {
        return false;
    }
    
    $users[$username] = [
        'password' => password_hash($password, PASSWORD_DEFAULT),
        'is_admin' => $is_admin,
        'created_at' => date('c')
    ];
    
    file_put_contents(__DIR__ . '/../users.json', json_encode($users, JSON_PRETTY_PRINT));
    return true;
}

function login($username, $password) {
    $users = get_all_users();
    
    if (isset($users[$username]) && password_verify($password, $users[$username]['password'])) {
        $_SESSION['user_id'] = $username;
        $_SESSION['is_admin'] = $users[$username]['is_admin'];
        return true;
    }
    return false;
}
?>