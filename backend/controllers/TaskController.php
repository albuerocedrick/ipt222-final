<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../models/Tasks.php';

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

$db = (new Database())->connect();
$task = new Task($db);

$method = $_SERVER['REQUEST_METHOD'];
$uri = explode("/", parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH));
$action = end($uri);

$data = json_decode(file_get_contents("php://input"), true);

switch ($method) {
    case 'POST':
        if ($action == 'create-task-in-projects') {
            $result = $task->CreateTask(
                $data['project_id'],
                $data['title'],
                $data['description'],
                $data['start_date'],
                $data['due_date'],
                $data['is_individual'] ?? 0
            );
            http_response_code($result['success'] ? 200 : 400);
            echo json_encode($result);
            exit;
        } elseif ($action == 'submit-task') {
            require_once __DIR__ . '/../models/Tasks.php';
            $taskSubmission = new Task($db);
            $result = $taskSubmission->submitTask($_POST, $_FILES);
            http_response_code($result['success'] ? 200 : 400);
            echo json_encode($result);
            exit;
        }
        break;

    case 'GET':
        if ($action == 'fetchalltask') {
            $result = $task->FetchTasks($_GET['user_id']);
            http_response_code(200);
            echo json_encode($result);
            exit;
        } elseif ($action == 'fetchtaskbyprojid') {
            $result = $task->FetchTasksByProj($_GET['project_id']);
            http_response_code(200);
            echo json_encode($result);
            exit;
        } elseif ($action == 'fetch-user-tasks') {
            $result = $task->fetchUserTasks($_GET['user_id'], $_GET['status_filter'], $_GET['sort_order']);
            http_response_code(200);
            echo json_encode($result);
            exit;
        } elseif ($action == 'fetch-upcoming-tasks') {
            $result = $task->fetchUpcomingTasks($_GET['user_id'], $_GET['days_ahead'] ?? 7);
            http_response_code(200);
            echo json_encode($result);
            exit;
        } elseif ($action == 'fetch-completed-tasks') {
            $user_id = $_GET['user_id'] ?? null;
            if ($user_id) {
                $result = $task->fetchCompletedTasksCount($user_id);
                http_response_code(200);
                echo json_encode($result);
            } else {
                http_response_code(400);
                echo json_encode(['success' => false, 'message' => 'User ID is required']);
            }
            exit;
        } elseif ($action == 'fetch-pending-tasks') {
            $user_id = $_GET['user_id'] ?? null;
            if ($user_id) {
                $result = $task->fetchPendingTasksCount($user_id);
                http_response_code(200);
                echo json_encode($result);
            } else {
                http_response_code(400);
                echo json_encode(['success' => false, 'message' => 'User ID is required']);
            }
            exit;
        }
        break;

    case 'PUT':
        if ($action == 'update-task-in-projects') {
            $result = $task->UpdateTask(
                $data['task_id'],
                $data['title'],
                $data['description'],
                $data['start_date'],
                $data['due_date'],
                $data['status']
            );
            http_response_code($result['success'] ? 200 : 400);
            echo json_encode($result);
            exit;
        }
        break;

    case 'DELETE':
        if ($action == 'delete-task') {
            $result = $task->DeleteTask($data['task_id']);
            http_response_code($result['success'] ? 200 : 400);
            echo json_encode($result);
            exit;
        }
        break;
}
?>
