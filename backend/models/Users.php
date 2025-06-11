<?php 

class User {
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function Exists($email) {
        $query = "SELECT COUNT(*) as count FROM users WHERE email = :email";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":email", $email);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['count'] > 0;
    }


    public function Signup($data) {
        if($this->Exists($data['email'])) {
            return ["success" => false, 
                    "message" => "Email already exists"];
        }

        $query = "INSERT INTO users (f_name, l_name, email, password) VALUES ( ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        $stmt->execute([$data['fname'], $data['lname'], $data['email'], $data['password']]);

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