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
    </div>
</section>
