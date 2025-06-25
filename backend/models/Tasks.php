<?php
require_once __DIR__ . '/Notifications.php';

class Task {
    private $conn;
    private $table = 'tasks';

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function FetchTasks($user_id) {
        $stmt = $this->conn->prepare("SELECT 
            t.task_id, 
            t.project_id, 
            t.title, 
            t.description, 
            t.status, 
            t.due_date, 
            t.start_date, 
            p.project_name 
        FROM tasks AS t
        LEFT JOIN projects AS p ON t.project_id = p.project_id
        LEFT JOIN collaborators AS c ON p.project_id = c.project_id
        WHERE 
            p.owner_id = ? OR c.user_id = ?
        ORDER BY t.due_date DESC
        ");
        $stmt->execute([$user_id]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return  [
            "data" => $result,
            "success" => true,
            "message" => 'Fetch Successful'
        ];

    }

    public function fetchCompletedTasksCount($user_id) {
        try {
            $query = "
                SELECT COUNT(uts.task_id) as completed_count
                FROM user_task_status uts
                JOIN tasks t ON uts.task_id = t.task_id
                JOIN collaborators c ON t.project_id = c.project_id
                WHERE uts.user_id = :user_id
                AND c.user_id = :user_id
                AND uts.status = 'Done'
            ";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->execute();
            
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $count = $result['completed_count'] ?? 0;
            
            return [
                'success' => true,
                'completed_tasks' => (int)$count
            ];
        } catch (PDOException $e) {
            return [
                'success' => false,
                'message' => 'Database error: ' . $e->getMessage()
            ];
        }
    }

    public function FetchTasksByProj($project_id) {
        try {
            $stmt = $this->conn->prepare("
                SELECT 
                    t.task_id, 
                    t.project_id, 
                    t.title, 
                    t.description, 
                    t.status, 
                    t.start_date, 
                    t.due_date, 
                    t.is_individual,
                    COUNT(ts.submission_id) AS submission_count
                FROM 
                    tasks AS t
                LEFT JOIN 
                    task_submissions AS ts ON t.task_id = ts.task_id
                WHERE 
                    t.project_id = ?
                GROUP BY 
                    t.task_id
                ORDER BY 
                    t.due_date ASC, t.start_date ASC
            ");
            
            $stmt->execute([$project_id]);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return [
                "data" => $result,
                "success" => true,
                "message" => 'Tasks fetched successfully'
            ];
        } catch (PDOException $e) {
            return [
                "data" => [],
                "success" => false,
                "message" => 'Failed to fetch tasks: ' . $e->getMessage()
            ];
        }
    }

    public function fetchPendingTasksCount($user_id) {
        try {
            $query = "
                SELECT COUNT(uts.task_id) as pending_count
                FROM user_task_status uts
                JOIN tasks t ON uts.task_id = t.task_id
                JOIN collaborators c ON t.project_id = c.project_id
                WHERE uts.user_id = :user_id
                AND c.user_id = :user_id
                AND uts.status IN ('Not Started', 'In Progress', 'Near Deadline')
            ";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->execute();
            
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $count = $result['pending_count'] ?? 0;
            
            return [
                'success' => true,
                'pending_tasks' => (int)$count
            ];
        } catch (PDOException $e) {
            return [
                'success' => false,
                'message' => 'Database error: ' . $e->getMessage()
            ];
        }
    }

    

    public function CreateTask($project_id, $title, $description, $start_date, $due_date, $is_individual = 0) {
        try {
            $stmt = $this->conn->prepare("
                INSERT INTO tasks (
                    project_id, title, description, start_date, due_date, is_individual
                ) VALUES (?, ?, ?, ?, ?, ?)
            ");
            $stmt->execute([
                $project_id,
                $title,
                $description,
                $start_date ?: null,
                $due_date ?: null,
                $is_individual ? 1 : 0
            ]);

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

    public function fetchUpcomingTasks($userId, $daysAhead = 7) {
        try {
            $currentDate = date('Y-m-d');
            $futureDate = date('Y-m-d', strtotime("+$daysAhead days"));
            
            $stmt = $this->conn->prepare("
                SELECT t.*, p.project_name, 
                    COALESCE(uts.status, t.status) as user_status
                FROM tasks t
                LEFT JOIN projects p ON t.project_id = p.project_id
                LEFT JOIN user_task_status uts ON t.task_id = uts.task_id AND uts.user_id = ?
                WHERE (t.due_date BETWEEN ? AND ?)
                AND (
                    t.task_id IN (
                        SELECT task_id FROM user_task_status WHERE user_id = ?
                    )
                    OR t.task_id IN (
                        SELECT t.task_id FROM tasks t
                        JOIN collaborators c ON t.project_id = c.project_id
                        WHERE c.user_id = ? AND t.is_individual = 0
                    )
                )
                ORDER BY t.due_date ASC
            ");
            
            $stmt->execute([$userId, $currentDate, $futureDate, $userId, $userId]);
            $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            return [
                "success" => true,
                "tasks" => $tasks,
                "message" => "Upcoming tasks fetched successfully"
            ];
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

    public function fetchUserTasks($user_id, $status_filter = null, $sort_order = 'asc') {
        try {
            // Base query to get all tasks assigned to user (either directly or via project)
            $query = "SELECT 
                        t.*, 
                        p.project_name,
                        uts.status as user_status,
                        p.owner_id
                    FROM tasks t
                    JOIN projects p ON t.project_id = p.project_id
                    LEFT JOIN user_task_status uts ON t.task_id = uts.task_id AND uts.user_id = ?
                    WHERE t.task_id IN (
                        SELECT task_id FROM tasks WHERE project_id IN (
                            SELECT project_id FROM collaborators WHERE user_id = ?
                        )
                    )";
            
            $params = [$user_id, $user_id];
            
            // Add status filter if provided
            if ($status_filter) {
                $query .= " AND (uts.status = ? OR (uts.status IS NULL AND t.status = ?))";
                array_push($params, $status_filter, $status_filter);
            }
            
            // Add sorting
            $query .= " ORDER BY t.due_date " . ($sort_order === 'desc' ? 'DESC' : 'ASC');
            
            $stmt = $this->conn->prepare($query);
            $stmt->execute($params);
            
            $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            return [
                "success" => true,
                "data" => $tasks,
                "message" => "Tasks fetched successfully"
            ];
        } catch (PDOException $e) {
            return [
                "success" => false,
                "message" => "Database error: " . $e->getMessage()
            ];
        }
    }

    public function submitTask($data, $files) {
        try {
            $task_id = $data['task_id'];
            $submitted_by = $data['submitted_by'];

            if (!$task_id || !$submitted_by || !isset($files['photos'])) {
                return ['success' => false, 'message' => 'Missing required data'];
            }

            // Upload photo(s)
            $photo_paths = [];
            foreach ($files['photos']['tmp_name'] as $index => $tmpName) {
                $fileName = uniqid() . '_' . basename($files['photos']['name'][$index]);
                $targetPath = '../uploads/' . $fileName;

                if (move_uploaded_file($tmpName, $targetPath)) {
                    $photo_paths[] = 'uploads/' . $fileName; // Save relative path
                } else {
                    return ['success' => false, 'message' => 'Failed to upload image(s)'];
                }
            }

            // Save to task_submissions table
            $stmt = $this->conn->prepare("
                INSERT INTO task_submissions (task_id, submitted_by, photo_url) 
                VALUES (:task_id, :submitted_by, :photo_url)
            ");
            foreach ($photo_paths as $path) {
                $stmt->execute([
                    ':task_id' => $task_id,
                    ':submitted_by' => $submitted_by,
                    ':photo_url' => $path
                ]);
            }

            // Find project owner
            $query = "
                SELECT p.owner_id 
                FROM tasks t
                JOIN projects p ON t.project_id = p.project_id
                WHERE t.task_id = :task_id
            ";
            $ownerStmt = $this->conn->prepare($query);
            $ownerStmt->bindParam(':task_id', $task_id, PDO::PARAM_INT);
            $ownerStmt->execute();
            $owner = $ownerStmt->fetch(PDO::FETCH_ASSOC);


            return ['success' => true, 'message' => 'Task submitted'];
        } catch (PDOException $e) {
            return ['success' => false, 'message' => 'DB Error: ' . $e->getMessage()];
        }
    }

    public function checkTaskCompletion($task_id) {
        $stmt = $this->conn->prepare("
            SELECT 
                p.owner_id,
                COUNT(DISTINCT c.user_id) as total_users,
                COUNT(DISTINCT uts.user_id) as completed_users
            FROM tasks t
            JOIN projects p ON t.project_id = p.project_id
            JOIN collaborators c ON p.project_id = c.project_id
            LEFT JOIN user_task_status uts ON t.task_id = uts.task_id 
                AND uts.user_id = c.user_id 
                AND uts.status = 'Done'
            WHERE t.task_id = ?
            GROUP BY t.task_id
        ");
        $stmt->execute([$task_id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return [
            'owner_id' => $result['owner_id'] ?? null,
            'is_complete' => ($result['total_users'] ?? 0) > 0 && 
                            ($result['completed_users'] ?? 0) >= ($result['total_users'] ?? 0)
        ];
    }

}
?>