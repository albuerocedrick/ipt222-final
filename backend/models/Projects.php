<?php
class Project {
    private $conn;
    private $table = 'projects';

    public function __construct($db)
    {
       $this->conn =  $db;
    }

    public function AddProject($owner_id, $project_name, $description) {
        $stmt = $this->conn->prepare("INSERT INTO $this->table SET owner_id=:owner_id, project_name=:project_name, description=:description");
        $stmt->bindParam(":owner_id",  $owner_id);
        $stmt->bindParam(":project_name", $project_name);
        $stmt->bindParam(":description", $description);
        $stmt->execute();

        return [
            "success" => true,
            "message" => 'Folder Created Successfully'
        ];
    }

    public function FetchProject($user_id) {
        $stmt = $this->conn->prepare("SELECT DISTINCT projects.project_id, owner_id, project_name, description, created_at
                                        FROM projects
                                        LEFT JOIN collaborators ON projects.project_id = collaborators.project_id
                                        WHERE collaborators.user_id = ? OR projects.owner_id = ?");
        $stmt->execute([$user_id, $user_id]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return [
            "data" => $result,
            "success" => true,
            "message" => 'Fetch Successful'
        ];
    }

    public function CreateProject($owner_id, $project_name, $description = null) {
        try {
            // Start transaction
            $this->conn->beginTransaction();
            
            // 1. Create the project
            $query = "INSERT INTO projects (owner_id, project_name, description) VALUES (?, ?, ?)";
            $stmt = $this->conn->prepare($query);
            $stmt->execute([$owner_id, $project_name, $description]);
            $project_id = $this->conn->lastInsertId();
            
            // 2. Add owner as collaborator
            $query = "INSERT INTO collaborators (project_id, user_id, is_owner) VALUES (?, ?, 1)";
            $stmt = $this->conn->prepare($query);
            $stmt->execute([$project_id, $owner_id]);
            
            // Commit transaction
            $this->conn->commit();
            
            return [
                "success" => true,
                "status" => 201,
                "project_id" => $project_id,
                "message" => "Project created successfully"
            ];
        } catch (PDOException $e) {
            $this->conn->rollBack();
            return [
                "success" => false,
                "status" => 500,
                "message" => "Error creating project",
                "error" => $e->getMessage()
            ];
        }
    }

    public function FetchProjectMembers($project_id) {
        try {
            $query = "
                SELECT 
                    u.user_id,
                    u.f_name,
                    u.l_name,
                    u.email,
                    u.profile_pic,
                    u.is_admin,
                    c.is_owner,
                    c.added_at,
                    (
                        SELECT COUNT(*) 
                        FROM user_task_status uts
                        JOIN tasks t ON uts.task_id = t.task_id
                        WHERE uts.user_id = u.user_id 
                        AND t.project_id = ?
                        AND uts.status = 'Done'
                    ) as completed_tasks,
                    (
                        SELECT COUNT(*) 
                        FROM user_task_status uts
                        JOIN tasks t ON uts.task_id = t.task_id
                        WHERE uts.user_id = u.user_id 
                        AND t.project_id = ?
                    ) as total_tasks
                FROM 
                    collaborators c
                JOIN 
                    users u ON c.user_id = u.user_id
                WHERE 
                    c.project_id = ?
                ORDER BY
                    c.is_owner DESC,
                    u.f_name ASC
            ";

            $stmt = $this->conn->prepare($query);
            $stmt->execute([$project_id, $project_id, $project_id]);
            $members = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return [
                "success" => true,
                "status" => 200,
                "data" => $members
            ];
        } catch (PDOException $e) {
            return [
                "success" => false,
                "status" => 500,
                "message" => "Error fetching project members",
                "error" => $e->getMessage()
            ];
        }
    }
    
    public function RemoveMember($project_id, $user_id) {
        try {
            $stmt = $this->conn->prepare("DELETE FROM collaborators WHERE project_id = ? AND user_id = ?");
            $stmt->execute([$project_id, $user_id]);

            if ($stmt->rowCount() > 0) {
                return [
                    "success" => true,
                    "message" => "Member removed successfully!"
                ];
            } else {
                return [
                    "success" => false,
                    "message" => "Member not found or already removed."
                ];
            }
        } catch (PDOException $e) {
            return [
                "success" => false,
                "message" => "Database error: " . $e->getMessage()
            ];
        }
    }

    public function UpdateProject($project_id, $project_name, $description) {
        try {
            $stmt = $this->conn->prepare("UPDATE projects SET project_name = ?, description = ? WHERE project_id = ?");
            $stmt->execute([$project_name, $description, $project_id]);

            if ($stmt->rowCount() > 0) {
                return [
                    "success" => true,
                    "message" => "Project updated successfully!"
                ];
            } else {
                return [
                    "success" => false,
                    "message" => "No changes made or project not found."
                ];
            }
        } catch (PDOException $e) {
            return [
                "success" => false,
                "message" => "Database error: " . $e->getMessage()
            ];
        }
    }

    public function DeleteProject($project_id) {
        try {
            // Delete from user_task_status
            $this->conn->prepare("
                DELETE FROM user_task_status 
                WHERE task_id IN (SELECT task_id FROM tasks WHERE project_id = ?)
            ")->execute([$project_id]);

            // Delete from task_submissions
            $this->conn->prepare("
                DELETE FROM task_submissions 
                WHERE task_id IN (SELECT task_id FROM tasks WHERE project_id = ?)
            ")->execute([$project_id]);

            // Delete tasks
            $this->conn->prepare("
                DELETE FROM tasks 
                WHERE project_id = ?
            ")->execute([$project_id]);

            // Delete collaborators
            $this->conn->prepare("
                DELETE FROM collaborators 
                WHERE project_id = ?
            ")->execute([$project_id]);

            // Delete notifications related to this project (optional)
            $this->conn->prepare("
                DELETE FROM notifications 
                WHERE related_id = ? AND type = 'project_added_as_collaborator'
            ")->execute([$project_id]);

            // Delete project
            $this->conn->prepare("
                DELETE FROM projects 
                WHERE project_id = ?
            ")->execute([$project_id]);

            return [
                "success" => true,
                "message" => "Project deleted successfully!"
            ];
        } catch (PDOException $e) {
            return [
                "success" => false,
                "message" => "Failed to delete project: " . $e->getMessage()
            ];
        }
    }



    public function AddMember($project_id, $email) {
        try {
            // 1. Check if the user exists
            $userStmt = $this->conn->prepare("SELECT user_id FROM users WHERE email = ?");
            $userStmt->execute([$email]);
            $user = $userStmt->fetch(PDO::FETCH_ASSOC);

            if (!$user) {
                return [
                    "success" => false,
                    "status" => 404,
                    "message" => "User with this email does not exist."
                ];
            }

            $user_id = $user['user_id'];

            // 2. Check if the user is already a collaborator
            $checkStmt = $this->conn->prepare("SELECT 1 FROM collaborators WHERE project_id = ? AND user_id = ?");
            $checkStmt->execute([$project_id, $user_id]);

            if ($checkStmt->fetch()) {
                return [
                    "success" => false,
                    "status" => 409,
                    "message" => "User is already a member of this project."
                ];
            }

            // 3. Insert into collaborators table (only fields that exist in your schema)
            $insertStmt = $this->conn->prepare("
                INSERT INTO collaborators (project_id, user_id, is_owner, added_at) 
                VALUES (?, ?, 0, NOW())
            ");
            
            $success = $insertStmt->execute([$project_id, $user_id]);

            if ($success) {
                return [
                    "success" => true,
                    "status" => 201,
                    "message" => "Member added successfully!",
                    "data" => [
                        "user_id" => $user_id,
                        "project_id" => $project_id
                    ]
                ];
            } else {
                throw new Exception("Failed to insert into database");
            }

        } catch (PDOException $e) {
            return [
                "success" => false,
                "status" => 500,
                "message" => "Database error",
                "error" => $e->getMessage()
            ];
        }
    }

    public function fetchUserProjects($userId) {
        try {
            $stmt = $this->conn->prepare("
                SELECT 
                    p.project_id,
                    p.project_name,
                    p.description,
                    p.created_at,
                    p.owner_id,
                    COUNT(t.task_id) as task_count,
                    CASE 
                        WHEN COUNT(t.task_id) = 0 THEN 'Planning'
                        WHEN COUNT(t.task_id) = SUM(CASE WHEN t.status = 'Done' THEN 1 ELSE 0 END) THEN 'Completed'
                        WHEN COUNT(t.task_id) > 0 THEN 'Active'
                        ELSE 'Planning'
                    END as status
                FROM projects p
                LEFT JOIN tasks t ON p.project_id = t.project_id
                WHERE p.project_id IN (
                    SELECT project_id FROM collaborators WHERE user_id = ?
                )
                GROUP BY p.project_id
                ORDER BY p.created_at DESC
            ");
            $stmt->execute([$userId]);
            $projects = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return [
                "success" => true,
                "data" => $projects,
                "message" => "User projects fetched successfully"
            ];
        } catch (PDOException $e) {
            return [
                "success" => false,
                "message" => "Database error: " . $e->getMessage()
            ];
        }
    }

    public function fetchTasksForProjects($projectIds) {
        try {
            // Convert comma-separated string to array
            $projectIdsArray = explode(',', $projectIds);
            
            // Create placeholders for prepared statement
            $placeholders = implode(',', array_fill(0, count($projectIdsArray), '?'));
            
            $stmt = $this->conn->prepare("
                SELECT 
                    t.task_id,
                    t.project_id,
                    t.title,
                    t.description,
                    t.status,
                    t.start_date,
                    t.due_date,
                    uts.status as user_status,
                    uts.user_id
                FROM tasks t
                LEFT JOIN user_task_status uts ON t.task_id = uts.task_id
                WHERE t.project_id IN ($placeholders)
            ");
            $stmt->execute($projectIdsArray);
            $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return [
                "success" => true,
                "tasks" => $tasks,
                "message" => "Project tasks fetched successfully"
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