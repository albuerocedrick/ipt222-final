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
        $stmt = $this->conn->prepare("SELECT projects.project_id, owner_id, project_name, description 
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
}
?>