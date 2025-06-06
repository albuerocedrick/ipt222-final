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
}
?>