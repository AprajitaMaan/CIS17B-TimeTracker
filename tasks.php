<?php
require_once '../includes/auth.php';
require_once '../includes/db.php';

if (!is_logged_in()) {
  http_response_code(401);
  die(json_encode(['error' => 'Not logged in']));
}

$username = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $data = json_decode(file_get_contents('php://input'), true);
  
  $tasks = get_user_tasks($username);
  
  switch ($data['action']) {
    case 'add':
      $tasks[] = ['name' => $data['name'], 'start' => null, 'totalSeconds' => 0];
      break;
      
    case 'start':
      $tasks[$data['index']]['start'] = time();
      break;
      
    case 'stop':
      $task = &$tasks[$data['index']];
      $task['totalSeconds'] += time() - $task['start'];
      $task['start'] = null;
      break;
  }
  
  save_user_tasks($username, $tasks);
  echo json_encode(['status' => 'success']);
} else {
  echo json_encode(get_user_tasks($username));
}
?>