<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../models/Projects.php';

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
        if($action == 'add') {
            $result = $project->AddProject($data['id'], $data['name'], $data['description']);
            echo json_encode($result);
        } else if($action == 'create-project') {
            echo json_encode($project->CreateProject($data['owner_id'], $data['project_name'], $data['description']));
        }
        break;
    case 'GET':
        if($action == 'fetch-user-projects') {
            echo json_encode($project->FetchProject($_GET['user_id']));
        } elseif ($action == 'fetch-project-members') {
            echo json_encode($project->FetchProjectMembers($_GET['project_id']));
        }
        break;
    case 'PUT':
        if($action == 'update-project'){
            echo json_encode($project->UpdateProject($data['project_id'], $data['project_name'], $data['description']));
        }
        break;
    case 'DELETE':
        if($action == 'remove-member'){
            echo json_encode($project->RemoveMember($data['project_id'], $data['user_id']));
        } elseif($action == 'delete-project') {
            echo json_encode($project->DeleteProject($data['project_id']));
        }
        break;
}
?>