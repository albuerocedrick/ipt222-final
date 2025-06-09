<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../models/Tasks.php';

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: POST, GET, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type");

$db = (new Database())->connect();
$task = new Task($db);

$method = $_SERVER['REQUEST_METHOD'];
$uri = explode("/", parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH));
$action = $uri[count($uri) - 1];

$data = json_decode(file_get_contents("php://input"), true);

switch($method) {
    case 'POST':
        break;
    case 'GET':
        if($action == 'fetchalltask') {
            echo json_encode($task->FetchTasks($_GET['user_id']));
        } else if($action == 'fetchtaskbyprojid') {
            echo json_encode($task->FetchTasksByProj($_GET['project_id']));
        }
        break;
    case 'PUT':
        break;
    case 'DELETE':
        break;
}
?>