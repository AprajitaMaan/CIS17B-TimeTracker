<?php
session_start();
$taskFile = 'tasks.json';

if (!isset($_SESSION['username'])) {
    http_response_code(403);
    echo json_encode(["error" => "Not logged in"]);
    exit;
}

$tasks = file_exists($taskFile) ? json_decode(file_get_contents($taskFile), true) : [];
$user = $_SESSION['username'];
if (!isset($tasks[$user])) $tasks[$user] = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'add') {
        $name = $_POST['name'];
        $tasks[$user][] = ["name" => $name, "start" => null, "totalSeconds" => 0];
    } elseif ($action === 'start') {
        $index = (int) $_POST['index'];
        $tasks[$user][$index]['start'] = time();
    } elseif ($action === 'stop') {
        $index = (int) $_POST['index'];
        $start = $tasks[$user][$index]['start'];
        if ($start) {
            $tasks[$user][$index]['totalSeconds'] += time() - $start;
            $tasks[$user][$index]['start'] = null;
        }
    }

    file_put_contents($taskFile, json_encode($tasks));
    echo json_encode(["status" => "ok"]);
} elseif ($_GET['action'] === 'list') {
    echo json_encode($tasks[$user]);
}
?>
