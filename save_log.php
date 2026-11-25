<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['status' => 'error', 'message' => 'POST required']);
    exit;
}

$logFile = __DIR__ . '/logs.json';
$logs = file_exists($logFile)
    ? json_decode(file_get_contents($logFile), true)
    : ['myths' => [], 'feedback' => []];

if (!is_array($logs)) {
    $logs = ['myths' => [], 'feedback' => []];
}

$type = $_POST['log_type'] ?? '';
$timestamp = date('Y-m-d H:i:s');

if ($type === 'myth') {
    $logs['myths'][] = [
        'name' => trim($_POST['name'] ?? 'Anonymous'),
        'myth_title' => trim($_POST['myth_title'] ?? ''),
        'category' => trim($_POST['category'] ?? 'General'),
        'details' => trim($_POST['details'] ?? ''),
        'submitted_at' => $timestamp
    ];
} elseif ($type === 'feedback') {
    $logs['feedback'][] = [
        'name' => trim($_POST['name'] ?? 'Anonymous'),
        'email' => trim($_POST['email'] ?? ''),
        'topic' => trim($_POST['topic'] ?? 'General'),
        'message' => trim($_POST['message'] ?? ''),
        'submitted_at' => $timestamp
    ];
} else {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Invalid log_type']);
    exit;
}

file_put_contents($logFile, json_encode($logs, JSON_PRETTY_PRINT), LOCK_EX);
echo json_encode(['status' => 'ok']);