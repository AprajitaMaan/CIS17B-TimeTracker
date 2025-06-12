<?php
require_once '../includes/auth.php';

if (!is_admin()) {
    http_response_code(403);
    die(json_encode(['error' => 'Admin access required']));
}

header('Content-Type: application/json');

try {
    $action = $_REQUEST['action'] ?? '';
    
    switch ($action) {
        case 'get_all_users':
            $users = json_decode(file_get_contents('../users.json'), true) ?: [];
            echo json_encode($users);
            break;
            
        case 'delete_user':
            $username = $_POST['username'] ?? '';
            $users = json_decode(file_get_contents('../users.json'), true) ?: [];
            
            if (!isset($users[$username])) {
                throw new Exception('User not found');
            }
            if ($username === $_SESSION['user_id']) {
                throw new Exception('Cannot delete yourself');
            }
            
            unset($users[$username]);
            file_put_contents('../users.json', json_encode($users, JSON_PRETTY_PRINT));
            echo json_encode(['status' => 'success']);
            break;
            
        default:
            throw new Exception('Invalid action');
    }
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(['error' => $e->getMessage()]);
}
?>