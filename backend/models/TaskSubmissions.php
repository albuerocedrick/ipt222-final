<?php
class TaskSubmission {
    private $conn;
    private $table = 'task_submissions';

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function submitTask($task_id, $user_id, $photos) {
        try {
            $this->conn->beginTransaction();
            
            // First update the user's task status
            $db = (New Database())->connect();
            $userTaskStatus = new UserTaskStatus($db);
            $userTaskStatus->updateTaskStatus($task_id, $user_id, 'Done');
            
            // Save each photo to task submissions
            $photoUrls = [];
            foreach ($photos as $photo) {
                $photoName = uniqid() . '_' . $photo['name'];
                $photoPath = 'uploads/task_submissions/' . $photoName;
                
                if (move_uploaded_file($photo['tmp_name'], $photoPath)) {
                    $stmt = $this->conn->prepare("
                        INSERT INTO task_submissions 
                        (task_id, submitted_by, photo_url) 
                        VALUES (?, ?, ?)
                    ");
                    $stmt->execute([$task_id, $user_id, $photoPath]);
                    $photoUrls[] = $photoPath;
                }
            }
            
            $this->conn->commit();
            
            return [
                "success" => true,
                "message" => "Task submitted successfully with " . count($photoUrls) . " photos",
                "photo_urls" => $photoUrls
            ];
        } catch (PDOException $e) {
            $this->conn->rollBack();
            return [
                "success" => false,
                "message" => "Database error: " . $e->getMessage()
            ];
        }
    }
}
?>