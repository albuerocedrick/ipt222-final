<?php
class Notification {
    private $conn;
    private $table = 'notifications';
    
    public function __construct($db) {
        $this->conn = $db;
    }

    public function addNotification($user_id, $type, $message, $related_id = null) {
        try {
            $query = "
                INSERT INTO {$this->table} 
                (user_id, type, message, related_id) 
                VALUES (:user_id, :type, :message, :related_id)
            ";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->bindParam(':type', $type, PDO::PARAM_STR);
            $stmt->bindParam(':message', $message, PDO::PARAM_STR);
            
            if ($related_id) {
                $stmt->bindParam(':related_id', $related_id, PDO::PARAM_INT);
            } else {
                $stmt->bindValue(':related_id', null, PDO::PARAM_NULL);
            }
            
            $stmt->execute();
            
            return [
                'success' => true,
                'notification_id' => $this->conn->lastInsertId(),
                'message' => 'Notification added successfully'
            ];
            
        } catch (PDOException $e) {
            return [
                'success' => false,
                'message' => 'Failed to add notification: ' . $e->getMessage(),
                'error_details' => $e->getTraceAsString()
            ];
        }
    }

    public function fetchNotifications($user_id) {
        try {
            $query = "
                SELECT 
                    n.notification_id,
                    n.type,
                    n.message,
                    n.is_read,
                    n.related_id,
                    n.created_at
                FROM notifications n
                WHERE n.user_id = :user_id
                ORDER BY n.created_at DESC
                LIMIT 50
            ";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->execute();

            return [
                'success' => true,
                'notifications' => $stmt->fetchAll(PDO::FETCH_ASSOC)
            ];
        } catch (PDOException $e) {
            return [
                'success' => false,
                'message' => 'Database error: ' . $e->getMessage(),
                'error_details' => $e->getTraceAsString()
            ];
        }
    }

    public function markNotificationAsRead($user_id, $notification_id) {
        try {
            // Verify notification belongs to user
            $checkStmt = $this->conn->prepare(
                "SELECT 1 FROM notifications 
                 WHERE notification_id = :notification_id AND user_id = :user_id"
            );
            $checkStmt->execute([
                ':notification_id' => $notification_id,
                ':user_id' => $user_id
            ]);
            
            if (!$checkStmt->fetch()) {
                return [
                    'success' => false,
                    'message' => 'Notification not found or access denied'
                ];
            }

            // Mark as read
            $updateStmt = $this->conn->prepare(
                "UPDATE notifications SET is_read = 1 
                 WHERE notification_id = :notification_id"
            );
            $updateStmt->execute([':notification_id' => $notification_id]);

            return [
                'success' => true,
                'message' => 'Notification marked as read'
            ];
        } catch (PDOException $e) {
            return [
                'success' => false,
                'message' => 'Database error: ' . $e->getMessage()
            ];
        }
    }

    public function markAllNotificationsAsRead($user_id) {
        try {
            $stmt = $this->conn->prepare(
                "UPDATE notifications SET is_read = 1 
                 WHERE user_id = :user_id AND is_read = 0"
            );
            $stmt->execute([':user_id' => $user_id]);

            return [
                'success' => true,
                'message' => 'All notifications marked as read'
            ];
        } catch (PDOException $e) {
            return [
                'success' => false,
                'message' => 'Database error: ' . $e->getMessage()
            ];
        }
    }
}
?>