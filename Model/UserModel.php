<?php
require_once __DIR__ . '/../config/database.php';

class UserModel
{
    private $conn;
    private $table_name = "users";

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function addUser($username, $email, $password)
    {
        $query = "INSERT INTO " . $this->table_name . " (username, email, password) VALUES (:username, :email, :password)";
        $stmt = $this->conn->prepare($query);

        $hash = password_hash($password, PASSWORD_BCRYPT);
        $stmt->bindParam(":username", $username);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":password", $hash);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function updateUser($id, $username, $email)
    {
        $query = "UPDATE " . $this->table_name . " SET username = :username, email = :email WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":username", $username);
        $stmt->bindParam(":email", $email);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
?>