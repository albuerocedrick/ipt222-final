<?php 

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../models/Users.php';

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: POST, GET, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: POST, GET, PUT, DELETE, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type");
    http_response_code(200);
    exit;
}

$db = (new Database())->connect();
$user = new User($db);

$method = $_SERVER['REQUEST_METHOD'];
$uri = explode("/", parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH));
$action = $uri[count($uri) - 1];

$data = json_decode(file_get_contents("php://input"), true);

switch($method) {
    case 'POST':
        if ($action == 'signup') {
            $result = $user->Signup($data);
            echo json_encode($result);
            http_response_code($result['success'] ? 200 : 400);
            exit;
        } elseif($action == 'verify-password'){
            $result = $user->verifyPassword($data);
            echo json_encode($result);
            http_response_code($result['success'] ? 200 : 400);
            exit;
        } elseif($action == 'update-password') {
            $result = $user->updatePassword($data);
            echo json_encode($result);
            http_response_code($result['success'] ? 200 : 400);
            exit;
        }
        elseif ($action == 'login') {
            $result = $user->Login($data['email'], $data['password']);
            echo json_encode($result);
            http_response_code($result['success'] ? 200 : 401);
            exit;
        }
    case 'GET':
        break;
    case 'PUT':
        if ($action == 'update-profile') {
            $result = $user->updateProfile($data);
            echo json_encode($result);
        }
        break;
    case 'DELETE':
        break;
}
?>