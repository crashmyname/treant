<section class="section">
    <div class="section-header">
        <h1>New Model</h1>
    </div>

    <div class="section-body">
        <h4>Didalam MVC ini memiliki 2 model <a href="<?= base_url()?>/dokumentasi/omodel">Old Model</a> dan New Model</h4>
        <b>Model baru sudah menggunakan BaseModel jadi pengguna tidak perlu melakukan query, dan mudah dalam pemanggilan di controller</b><br>
        Contoh :
        <?php echo '<pre style="background-color: #2d2d2d; color: #f8f8f2; padding: 10px; border-radius: 5px; overflow: auto;">';
        echo '<code style="font-family: Consolas, \'Courier New\', monospace;">';
        echo htmlentities('<?php');
        echo '<br>';
        echo '
namespace Model; <-- panggil namespace model nya
use Support\BaseModel; <-- panggil basemodelnya dan extend basemodel dengan model kamu

class User extends BaseModel
{
    protected $table = "your table"; <-- masukkan table kamu
    protected $primaryKey = "id table"; <-- dan masukkan id nya
}
?>';
        echo '</code>';
        echo '</pre>';
        ?>
        <hr>
        <h4>Dinamis Model </h4>
        <b>Model dinamis jika kalian ingin membuat table yang dinamis seperti transaksi_2024, transaksi_2026 dan seterusnya</b><br>
        Contoh karena ada 2 cara yang bisa digunakan:
        <?php echo '<pre style="background-color: #2d2d2d; color: #f8f8f2; padding: 10px; border-radius: 5px; overflow: auto;">';
        echo '<code style="font-family: Consolas, \'Courier New\', monospace;">';
        echo htmlentities('<?php');
        echo '<br>';
        echo '<b style="color:skyblue">STEP 1 Langsung lewat controller panggil function setTable</b>';
        echo '<br>';
        echo 'public function index()
    {
        try{
            $year = "_2024";
            $data = User::setTable($year);
            $user = $data::all();
        } catch (Exception $e){
            throw new Exception("Error:".$e->getMessage());
        }
        View::render("test", ["user" => $user]);
    }
?>';
echo '<br><br><hr>';
echo '<b style="color:skyblue">STEP 2 set didalam modelnya</b>';
echo '<br>';
echo 'class User extends BaseModel
{
    // Model logic here
    protected $table = "users";
    protected $primaryKey = "user_id";
    
    public static function table($parameter)
    {
        $instance = new static();
        $modifiedTableName = $instance->table . $parameter;
        self::setCustomTable($modifiedTableName);
        return $instance;
    }
    public function getAllUsers()
    {
        return $this->all();  // Mengambil semua data dari tabel yang sudah diset
        }
}';
echo '<br>';
echo '<b style="color:skyblue">pemanggilan di controllernya</b> <br>';
echo 'public function index()
    {
        try{
            $year = "_2024";
            $data = User::table($year);
            $user = $data::all();
        } catch (Exception $e){
            throw new Exception("Error:".$e->getMessage());
        }
        View::render("test", ["user" => $user]);
    }';
        echo '</code>';
        echo '</pre>';
        ?>
    </div>
</section>
