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