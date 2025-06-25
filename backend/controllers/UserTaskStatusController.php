<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../models/UserTaskStatus.php';

// Set headers first
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: POST, GET, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type");

// Handle OPTIONS request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

$db = (new Database())->connect();
$userTaskStatus = new UserTaskStatus($db);

$method = $_SERVER['REQUEST_METHOD'];
$uri = explode("/", parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH));
$action = end($uri);

// Get and validate JSON input
$json = file_get_contents("php://input");
$data = json_decode($json, true);

if ($json === false || json_last_error() !== JSON_ERROR_NONE) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid JSON data']);
    exit;
}

// Define allowed status values
$allowedStatuses = ['Not Started', 'In Progress', 'Near Deadline', 'Done', 'Submitted Late', 'Missed'];

switch ($method) {
    case 'POST':
        if ($action == 'update-task-status') {
// Enhanced validation with detailed error messages
        $errors = [];
        
        // Check required fields
        if (!isset($data['task_id'])) $errors[] = 'task_id is required';
        if (!isset($data['user_id'])) $errors[] = 'user_id is required';
        if (!isset($data['status'])) $errors[] = 'status is required';

            // Validate required fields
            if (!isset($data['task_id'], $data['user_id'], $data['status'])) {
                http_response_code(400);
                echo json_encode(['success' => false, 'message' => 'Missing required fields']);
                exit;
            }

            // Validate data types and values
            if (!is_numeric($data['task_id']) || !is_numeric($data['user_id'])) {
                http_response_code(400);
                echo json_encode(['success' => false, 'message' => 'Invalid ID format']);
                exit;
            }

            if (!in_array($data['status'], $allowedStatuses)) {
                http_response_code(400);
                echo json_encode(['success' => false, 'message' => 'Invalid status value']);
                exit;
            }

            
            $result = $userTaskStatus->updateTaskStatus(
                (int)$data['task_id'],
                (int)$data['user_id'],
                $data['status'],
            );

            http_response_code($result['success'] ? 200 : 400);
            echo json_encode($result);
            exit;
        }
        break;

    default:
        http_response_code(405); // Method Not Allowed
        echo json_encode(['success' => false, 'message' => 'Method not allowed']);
        exit;
}