<?php
class Task {
    private $conn;
    private $table = 'tasks';

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function FetchTasks($user_id) {
        $stmt = $this->conn->prepare("SELECT task_id, t.project_id, title, t.description, status, due_date, start_date, project_name FROM $this->table AS t
                                    LEFT JOIN projects AS p ON t.project_id = p.project_id
                                    WHERE p.owner_id = ? ORDER BY due_date DESC");
        $stmt->execute([$user_id]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return  [
            "data" => $result,
            "success" => true,
            "message" => 'Fetch Successful'
        ];

    }

    public function FetchTasksByProj($project_id) {
        $stmt = $this->conn->prepare("SELECT task_id, t.project_id, title, t.description, status, due_date, start_date FROM $this->table AS t
                                    LEFT JOIN projects AS p ON t.project_id = p.project_id
                                    WHERE p.project_id = ?");
        $stmt->execute([$project_id]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return  [
            "data" => $result,
            "success" => true,
            "message" => 'Fetch Successful'
        ];

    }

    public function CreateTask($project_id, $title, $description, $start_date, $due_date) {
        try {
            $stmt = $this->conn->prepare("INSERT INTO tasks (project_id, title, description, start_date, due_date) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$project_id, $title, $description, $start_date, $due_date]);

            return [
                "success" => true,
                "message" => "Task created successfully!"
            ];
        } catch (PDOException $e) {
            return [
                "success" => false,
                "message" => "Database error: " . $e->getMessage()
            ];
        }
    }

    public function UpdateTask($task_id, $title, $description, $start_date, $due_date, $status) {
        try {
            $stmt = $this->conn->prepare("
                UPDATE tasks 
                SET title = ?, description = ?, start_date = ?, due_date = ?, status = ? 
                WHERE task_id = ?
            ");
            $stmt->execute([$title, $description, $start_date, $due_date, $status, $task_id]);

            if ($stmt->rowCount() > 0) {
                return [
                    "success" => true,
                    "message" => "Task updated successfully!"
                ];
            } else {
                return [
                    "success" => false,
                    "message" => "No changes made or task not found."
                ];
            }
        } catch (PDOException $e) {
            return [
                "success" => false,
                "message" => "Database error: " . $e->getMessage()
            ];
        }
    }

    public function DeleteTask($task_id) {
        try {
            $stmt = $this->conn->prepare("DELETE FROM tasks WHERE task_id = ?");
            $stmt->execute([$task_id]);

            if ($stmt->rowCount() > 0) {
                return [
                    "success" => true,
                    "message" => "Task deleted successfully!"
                ];
            } else {
                return [
                    "success" => false,
                    "message" => "Task not found or already deleted."
                ];
            }
        } catch (PDOException $e) {
            return [
                "success" => false,
                "message" => "Database error: " . $e->getMessage()
            ];
        }
    }


}
?>