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
        $stmt = $this->conn->prepare("SELECT projects.project_id, owner_id, project_name, description, created_at 
                                        FROM projects LEFT JOIN collaborators
                                        ON projects.project_id = collaborators.project_id
                                        WHERE collaborators.user_id = ? OR projects.owner_id = ? ");
        $stmt->execute([$user_id, $user_id]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return [
            "data" => $result,
            "success" => true,
            "message" => 'Fetch Successful'
        ];
    }

    public function CreateProject($owner_id, $project_name, $description) {
        try {
            $stmt = $this->conn->prepare("INSERT INTO $this->table (owner_id, project_name, description) VALUES (:owner_id, :project_name, :description)");
            $stmt->bindParam(":owner_id", $owner_id);
            $stmt->bindParam(":project_name", $project_name);
            $stmt->bindParam(":description", $description);
            $stmt->execute();

            return [
                "success" => true,
                "message" => "Project created successfully.",
                "project_id" => $this->conn->lastInsertId()
            ];
        } catch (PDOException $e) {
            return [
                "success" => false,
                "message" => "Project creation failed: " . $e->getMessage()
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
                    c.permission_level,
                    c.added_by,
                    c.added_at
                FROM collaborators c
                JOIN users u ON c.user_id = u.user_id
                WHERE c.project_id = ?
            ";

            $stmt = $this->conn->prepare($query);
            $stmt->execute([$project_id]);
            $members = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return [
                "success" => true,
                "data" => $members
            ];
        } catch (PDOException $e) {
            return [
                "success" => false,
                "message" => "Error fetching members: " . $e->getMessage()
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
            // First, delete related data (optional but recommended if you don't use ON DELETE CASCADE)
            $this->conn->prepare("DELETE FROM collaborators WHERE project_id = ?")->execute([$project_id]);
            $this->conn->prepare("DELETE FROM task_submissions WHERE task_id IN (SELECT task_id FROM tasks WHERE project_id = ?)")->execute([$project_id]);
            $this->conn->prepare("DELETE FROM tasks WHERE project_id = ?")->execute([$project_id]);
            $this->conn->prepare("DELETE FROM access_requests WHERE project_id = ?")->execute([$project_id]);
            $this->conn->prepare("DELETE FROM projects WHERE project_id = ?")->execute([$project_id]);

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


}
?>