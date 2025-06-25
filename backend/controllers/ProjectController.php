<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../models/Projects.php';

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
$project = new Project($db);

$method = $_SERVER['REQUEST_METHOD'];
$uri = explode("/", parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH));
$action = $uri[count($uri) - 1];

$data = json_decode(file_get_contents("php://input"), true);

switch($method) {
    case 'POST':
        if ($action == 'add') {
            $result = $project->AddProject($data['id'], $data['name'], $data['description']);
            http_response_code($result['success'] ? 200 : 400);
            echo json_encode($result);
            exit;
        } else if ($action == 'create-project') {
            $result = $project->CreateProject($data['owner_id'], $data['project_name'], $data['description']);
            http_response_code($result['success'] ? 200 : 400);
            echo json_encode($result);
            exit;
        } elseif ($action == 'add-member') {
            $result = $project->AddMember($data['project_id'], $data['email']);
            http_response_code($result['success'] ? 200 : 400);
            echo json_encode($result);
            exit;
        }
        break;

    case 'GET':
        if ($action == 'fetch-user-projects') {
            $result = $project->fetchUserProjects($_GET['user_id']);
            echo json_encode($result);
            http_response_code(200);
            exit;
        } elseif ($action == 'fetch-project-members') {
            $result = $project->fetchProjectMembers($_GET['project_id']);
            echo json_encode($result);
            http_response_code(200);
            exit;
        } elseif ($action == 'fetch-tasks-for-projects') {
            $result = $project->fetchTasksForProjects($_GET['project_ids']);
            echo json_encode($result);
            http_response_code(200);
            exit;
        }
        break;

    case 'PUT':
        if ($action == 'update-project') {
            $result = $project->UpdateProject($data['project_id'], $data['project_name'], $data['description']);
            http_response_code($result['success'] ? 200 : 400);
            echo json_encode($result);
            exit;
        }
        break;

    case 'DELETE':
        if ($action == 'remove-member') {
            $result = $project->RemoveMember($data['project_id'], $data['user_id']);
            http_response_code($result['success'] ? 200 : 400);
            echo json_encode($result);
            exit;
        } elseif ($action == 'delete-project') {
            $result = $project->DeleteProject($data['project_id']);
            http_response_code($result['success'] ? 200 : 400);
            echo json_encode($result);
            exit;
        }
        break;
}

?>