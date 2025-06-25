<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../models/TaskSubmissions.php';
require_once __DIR__ . '/../models/Tasks.php';
require_once __DIR__ . '/../models/UserTaskStatus.php';

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: POST, GET, PUT, DELETE, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type");
    http_response_code(200);
    exit;
}


header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: POST, GET, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type");

// Handle preflight request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

$db = (new Database())->connect();
$taskSubmission = new TaskSubmission($db);

$method = $_SERVER['REQUEST_METHOD'];
$uri = explode("/", parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH));
$action = $uri[count($uri) - 1];

// Create uploads directory if it doesn't exist
$uploadDir = __DIR__ . '/../uploads/task_submissions/';
if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

$data = json_decode(file_get_contents("php://input"), true);

switch($method) {
    case 'POST':
        if ($action == 'submit-task') {
            try {
                // Check if files were uploaded
                if (empty($_FILES['photos'])) {
                    http_response_code(400);
                    echo json_encode([
                        "success" => false,
                        "message" => "No files were uploaded"
                    ]);
                    exit();
                }

                // Process uploaded files
                $photos = [];
                foreach ($_FILES['photos']['tmp_name'] as $index => $tmpName) {
                    if ($_FILES['photos']['error'][$index] !== UPLOAD_ERR_OK) {
                        continue; // Skip files with upload errors
                    }

                    $photos[] = [
                        'name' => $_FILES['photos']['name'][$index],
                        'tmp_name' => $tmpName,
                        'type' => $_FILES['photos']['type'][$index],
                        'size' => $_FILES['photos']['size'][$index]
                    ];
                }

                // Get task_id and user_id from form data
                $task_id = $_POST['task_id'] ?? null;
                $user_id = $_POST['user_id'] ?? null;

                if (!$task_id || !$user_id) {
                    http_response_code(400);
                    echo json_encode([
                        "success" => false,
                        "message" => "Task ID and User ID are required"
                    ]);
                    exit();
                }

                // Validate file types and sizes
                $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
                $maxSize = 10 * 1024 * 1024; // 10MB

                foreach ($photos as $photo) {
                    if (!in_array($photo['type'], $allowedTypes)) {
                        http_response_code(400);
                        echo json_encode([
                            "success" => false,
                            "message" => "Invalid file type: " . $photo['name']
                        ]);
                        exit();
                    }

                    if ($photo['size'] > $maxSize) {
                        http_response_code(400);
                        echo json_encode([
                            "success" => false,
                            "message" => "File too large: " . $photo['name']
                        ]);
                        exit();
                    }
                }

                // Submit the task
                $result = $taskSubmission->submitTask($task_id, $user_id, $photos);
                $task = new Task($db);
                // Check if the task is now complete (all assigned users have submitted)
                $taskStatus = $task->checkTaskCompletion($task_id);
                if ($taskStatus['is_complete']) {
                    // Update main task status if all users have completed
                    $userstatus = new UserTaskStatus($db);
                    $userstatus->updateTaskStatus($task_id, $taskStatus['owner_id'], 'Done');
                }

                http_response_code(200);
                echo json_encode($result);
            } catch (Exception $e) {
                http_response_code(500);
                echo json_encode([
                    "success" => false,
                    "message" => "Server error: " . $e->getMessage()
                ]);
            }
        }
        break;
    case 'GET':
        break;
    case 'PUT':
        break;
    case 'DELETE':
        break;
}
?>