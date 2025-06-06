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
                                    WHERE p.owner_id = ?");
        $stmt->execute([$user_id]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return  [
            "data" => $result,
            "success" => true,
            "message" => 'Fetch Successful'
        ];

    }
}
?>