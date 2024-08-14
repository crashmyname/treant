<?php
namespace Model;

require_once __DIR__ . '/../config/config.php';
use Config\Database;
use PDO;

class UserModel
{
    private $conn;
    private $table_name = "users";

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->getConnection();
        if ($this->conn === null) {
            die('Koneksi database gagal.');
        }
    }

    public function user()
    {
        $query = "SELECT * FROM ". $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addUser($username,$uuid, $email, $password)
    {
        try{
            $this->conn->beginTransaction();
            $query = "INSERT INTO " . $this->table_name . " (username,uuid, email, password) VALUES (:username,:uuid, :email, :password)";
            $stmt = $this->conn->prepare($query);

            $hash = password_hash($password, PASSWORD_BCRYPT);
            $stmt->bindParam(":username", $username);
            $stmt->bindParam(":uuid", $uuid);
            $stmt->bindParam(":email", $email);
            $stmt->bindParam(":password", $hash);

            if ($stmt->execute()) {
                $this->conn->commit();
                return true;
            } else {
                $this->conn->rollback();
                return false;
            }
        } catch (\PDOException $e)
        {
            $this->conn->rollback();
            $e;
        }
    }

    public function onLogin($email, $password)
    {
        $query = "SELECT * FROM ".$this->table_name." WHERE email = :email";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":email", $email);
        
        if ($stmt->execute()) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            error_log("User fetched: " . print_r($user, true)); // Debugging
            
            if ($user && password_verify($password, $user['password'])) {
                return true;
            }
        }
        
        return false;
    }

    public function getUserById($id)
    {
        $query = "SELECT * FROM ".$this->table_name." WHERE user_id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function getUserIdByEmail($email)
    {
        $query = "SELECT user_id, username, email FROM " . $this->table_name . " WHERE email = :email";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":email", $email);
        
        if ($stmt->execute()) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            return $user;
        }
        
        return null;
    }

    public function updateUser($id, $username, $email, $password = null)
    {
        $query = "UPDATE " . $this->table_name . " SET username = :username, email = :email";
        if ($password !== null) {
            $query .= ", password = :password";
            $hash = password_hash($password, PASSWORD_BCRYPT);
        } else {
            $hash = null;
        }
        $query .= " WHERE user_id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":username", $username);
        $stmt->bindParam(":email", $email);
        if ($password !== null) {
            $stmt->bindParam(":password", $hash);
        }
        return $stmt->execute();
    }

    public function deleteUser($id)
    {
        $query = "DELETE FROM ". $this->table_name . " WHERE user_id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id',$id);
        return $stmt->execute();
    }
}
?>