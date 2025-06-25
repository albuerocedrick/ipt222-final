<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../models/Notifications.php';

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
$notification = new Notification($db);

$method = $_SERVER['REQUEST_METHOD'];
$uri = explode("/", parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH));
$action = end($uri);

$data = json_decode(file_get_contents("php://input"), true);

switch($method) {
    case 'POST':
        if ($action == 'send-notification') {
            $related_id = $data['related_id'] ?? null;
            $result = $notification->addNotification(
                $data['user_id'],
                $data['type'],
                $data['message'],
                $related_id
            );
            http_response_code($result['success'] ? 200 : 400);
            echo json_encode($result);
            exit;
        } else {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Missing required fields']);
            exit;
        }

    case 'GET':
        if ($action === 'fetch-notifications') {
            $user_id = $_GET['user_id'] ?? null;
            if ($user_id) {
                $result = $notification->fetchNotifications($user_id);
                http_response_code(200);
                echo json_encode($result);
                exit;
            } else {
                http_response_code(400);
                echo json_encode(['success' => false, 'message' => 'User ID is required']);
                exit;
            }
        }
        break;

    case 'PUT':
        if ($action === 'mark-notification-read') {
            $notification_id = $data['notification_id'] ?? null;
            $user_id = $data['user_id'] ?? null;
            if ($notification_id && $user_id) {
                $result = $notification->markNotificationAsRead($user_id, $notification_id);
                http_response_code($result['success'] ? 200 : 400);
                echo json_encode($result);
                exit;
            } else {
                http_response_code(400);
                echo json_encode(['success' => false, 'message' => 'Notification ID and User ID are required']);
                exit;
            }
        } elseif ($action === 'mark-all-notifications-read') {
            $user_id = $data['user_id'] ?? null;
            if ($user_id) {
                $result = $notification->markAllNotificationsAsRead($user_id);
                http_response_code($result['success'] ? 200 : 400);
                echo json_encode($result);
                exit;
            } else {
                http_response_code(400);
                echo json_encode(['success' => false, 'message' => 'User ID is required']);
                exit;
            }
        }
        break;

    default:
        http_response_code(405); // Method Not Allowed
        echo json_encode(['success' => false, 'message' => 'Invalid request method']);
        exit;
}
?>
