<?php 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

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

    public function verifyPassword($data) {
        $userId = $data['user_id'] ?? null;
        $currentPassword = $data['current_password'] ?? '';

        if (!$userId) {
            return ["success" => false, "message" => "User ID not provided"];
        }

        // Get user's current password hash
        $query = "SELECT password FROM users WHERE user_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$userId]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            return ["success" => false, "message" => "User not found"];
        }

        if (password_verify($currentPassword, $user['password'])) {
            return ["success" => true, "message" => "Password verified"];
        } else {
            return ["success" => false, "message" => "Current password is incorrect"];
        }
    }

    public function updatePassword($data) {
        $userId = $data['user_id'] ?? null;
        $currentPassword = $data['current_password'] ?? '';
        $newPassword = $data['new_password'] ?? '';
        $confirmPassword = $data['confirm_password'] ?? '';

        if (!$userId) {
            return ["success" => false, "message" => "User ID not provided", "requires_reauthentication" => true];
        }

        // Validate passwords match
        if ($newPassword !== $confirmPassword) {
            return ["success" => false, "message" => "Passwords do not match"];
        }

        // Validate password strength
        if (strlen($newPassword) < 8) {
            return ["success" => false, "message" => "Password must be at least 8 characters long"];
        }

        // Verify current password again
        $verifyResult = $this->verifyPassword(['user_id' => $userId, 'current_password' => $currentPassword]);
        if (!$verifyResult['success']) {
            return $verifyResult;
        }

        // Hash new password
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        // Update password in database
        $query = "UPDATE users SET password = ? WHERE user_id = ?";
        $stmt = $this->conn->prepare($query);
        $success = $stmt->execute([$hashedPassword, $userId]);

        if ($success) {
            return ["success" => true, "message" => "Password updated successfully"];
        } else {
            return ["success" => false, "message" => "Failed to update password"];
        }
    }

    // for updating user profile
    public function updateProfile($data) {
        // Validate required fields
        if (empty($data['user_id'])) {
            return ["success" => false, "message" => "User ID is required"];
        }

        // Check if email is being updated and if it already exists
        if (isset($data['email'])) {
            $query = "SELECT user_id FROM users WHERE email = :email AND user_id != :userId";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":email", $data['email']);
            $stmt->bindParam(":userId", $data['user_id']);
            $stmt->execute();
            
            if ($stmt->rowCount() > 0) {
                return ["success" => false, "message" => "Email already in use by another account"];
            }
        }

        // Build the update query dynamically based on provided data
        $updates = [];
        $params = [":userId" => $data['user_id']];
        
        if (isset($data['f_name'])) {
            $updates[] = "f_name = :f_name";
            $params[":f_name"] = $data['f_name'];
        }
        
        if (isset($data['l_name'])) {
            $updates[] = "l_name = :l_name";
            $params[":l_name"] = $data['l_name'];
        }
        
        if (isset($data['email'])) {
            $updates[] = "email = :email";
            $params[":email"] = $data['email'];
        }
        
        if (isset($data['profile_pic'])) {
            $updates[] = "profile_pic = :profile_pic";
            $params[":profile_pic"] = $data['profile_pic'];
        }
        
        if (isset($data['is_admin'])) {
            $updates[] = "is_admin = :is_admin";
            $params[":is_admin"] = $data['is_admin'];
        }

        // If no fields to update
        if (empty($updates)) {
            return ["success" => false, "message" => "No data provided for update"];
        }

        // Prepare and execute the update query
        try {
            $query = "UPDATE users SET " . implode(", ", $updates) . " WHERE user_id = :userId";
            $stmt = $this->conn->prepare($query);
            $stmt->execute($params);
            
            return ["success" => true, "message" => "Profile updated successfully"];
        } catch (PDOException $e) {
            return ["success" => false, "message" => "Database error: " . $e->getMessage()];
        }
    }

    
}

?>