<?php
require_once __DIR__ . '/../config/db.php';

class UserTaskStatus {
    private $conn;
    private $table = 'user_task_status';
    

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function updateTaskStatus($task_id, $user_id, $new_status) {
        try {
            // Check if status record already exists
            $checkStmt = $this->conn->prepare("
                SELECT 1 FROM user_task_status 
                WHERE task_id = ? AND user_id = ?
            ");
            $checkStmt->execute([$task_id, $user_id]);
            
            if ($checkStmt->rowCount() > 0) {
                // Update existing record
                $stmt = $this->conn->prepare("
                    UPDATE user_task_status 
                    SET status = ?, updated_at = NOW() 
                    WHERE task_id = ? AND user_id = ?
                ");
                $stmt->execute([$new_status, $task_id, $user_id]);
            } else {
                // Insert new record
                $stmt = $this->conn->prepare("
                    INSERT INTO user_task_status 
                    (task_id, user_id, status) 
                    VALUES (?, ?, ?)
                ");
                $stmt->execute([$task_id, $user_id, $new_status]);
            }
            
            // Also update the main task status if the user is the owner
            $ownerStmt = $this->conn->prepare("
                SELECT owner_id FROM projects 
                WHERE project_id = (SELECT project_id FROM tasks WHERE task_id = ?)
            ");
            $ownerStmt->execute([$task_id]);
            $owner = $ownerStmt->fetch(PDO::FETCH_ASSOC);
            
            if ($owner && $owner['owner_id'] == $user_id) {
                $updateTaskStmt = $this->conn->prepare("
                    UPDATE tasks SET status = ? 
                    WHERE task_id = ?
                ");
                $updateTaskStmt->execute([$new_status, $task_id]);
            }
            
            return [
                "success" => true,
                "message" => "Task status updated successfully"
            ];
        } catch (PDOException $e) {
            return [
                "success" => false,
                "message" => "Database error: " . $e->getMessage()
            ];
        }
    }
}
?>