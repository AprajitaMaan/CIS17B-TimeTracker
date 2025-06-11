<?php
session_start();

function is_logged_in() {
  return isset($_SESSION['user_id']);
}

function login($username, $password) {
  $users = json_decode(file_get_contents('../users.json'), true) ?? [];
  return isset($users[$username]) && password_verify($password, $users[$username]);
}

function register($username, $password) {
  $users = json_decode(file_get_contents('../users.json'), true) ?? [];
  
  if (isset($users[$username])) return false;
  
  $users[$username] = password_hash($password, PASSWORD_DEFAULT);
  file_put_contents('../users.json', json_encode($users));
  return true;
}
?>