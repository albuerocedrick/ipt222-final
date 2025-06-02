<?php 

class User {
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function Exists($email, $username) {
        $query = "SELECT COUNT(*) as count FROM users WHERE email = :email OR username = :username";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":username", $username);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['count'] > 0;
    }


    public function Signup($data) {
        if($this->Exists($data['email'],$data['username'])) {
            return ["success" => false, 
                    "message" => "Email or username already exists"];
        }

        $query = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        $stmt->execute([$data['username'], $data['email'], $data['password']]);

        return ["success" => true, 
                "message" => "Successful Signup"];
    }

    public function Login($email, $password) {
        $query = "SELECT * FROM users WHERE email = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if($user && password_verify($password, $user['password'])) {
            unset($user['password']);
            return ["user" => $user, 
                    "success" => true, 
                    "message" => "Log In Successful!"];
        }

        return ["success" => false, 
                "message" => "User doesn't exist"];
    }
}

?>