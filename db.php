<?php
function get_user_tasks($username) {
  $tasks = json_decode(file_get_contents('../tasks.json'), true) ?? [];
  return $tasks[$username] ?? [];
}

function save_user_tasks($username, $tasks) {
  $all_tasks = json_decode(file_get_contents('../tasks.json'), true) ?? [];
  $all_tasks[$username] = $tasks;
  file_put_contents('../tasks.json', json_encode($all_tasks));
}
?>