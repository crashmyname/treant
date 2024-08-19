<section class="section">
    <div class="section-header">
        <h1>Old Model</h1>
    </div>

    <div class="section-body">
        <h4>Didalam MVC ini memiliki 2 model Old Model dan <a href="<?= $_ENV['ROUTE_PREFIX']?>/dokumentasi/nmodel">New Model</a></h4>
        <b>Model Lama masih membuat query untuk menjalankan model tertentu dan New Model memiliki BaseModel jadi pengguna tidak perlu membuat query di model</b><br>
        Contoh :
        <?php echo '<pre style="background-color: #2d2d2d; color: #f8f8f2; padding: 10px; border-radius: 5px; overflow: auto;">';
        echo '<code style="font-family: Consolas, \'Courier New\', monospace;">';
        echo htmlentities('<?php');
        echo '<br>';
        echo 'namespace Model;

use Config\Database; <-- jangan lupa include databasenya
use PDO; <-- dan panggil fungsi PDO

class UserModel
{
    private $conn;
    private $table_name = "Your table";

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->getConnection();
        if ($this->conn === null) {
            die("Koneksi database gagal.");
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
}';
        echo '</code>';
        echo '</pre>';
        ?>
    </div>
</section>
