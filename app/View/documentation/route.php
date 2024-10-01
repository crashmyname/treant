<section class="section">
    <div class="section-header">
        <h1>Route</h1>
    </div>

    <div class="section-body">
        <h4>Route disini berfungsi untuk mengarahkan url anda</h4>
        <b>Route digunakan supaya dari sisi client tidak mengetahui nama file nya dan letaknya dimana</b><br>
        Contoh :
        <?php echo '<pre style="background-color: #2d2d2d; color: #f8f8f2; padding: 10px; border-radius: 5px; overflow: auto;">';
        echo '<code style="font-family: Consolas, \'Courier New\', monospace;">';
        echo htmlentities('<?php');
        echo '<br>';
        echo '
session_start();
require_once __DIR__ . "/bin/support/Asset.php";
require_once __DIR__ . "/bin/support/Prefix.php";
require_once __DIR__ . "/bin/support/Rc.php";
use Support\Request;
use Support\Route;
use Support\View;
use Support\CORSMiddleware;
use Support\AuthMiddleware; //<-- Penambahan Middleware atau session login
use Support\RateLimiter;
use Controller\YourController;
use Model\YourModel;

$request = new Request();
$route = new Route($prefix);
$urController = new YourController();

handleMiddleware();

$route->get("/", function(){
    View::render("wellcome/berhasil");
});
?>';
        echo '</code>';
        echo '</pre>';
        ?>
        <b>Contoh Pemanggilan Route GET</b>
        <?php echo '<pre style="background-color: #2d2d2d; color: #f8f8f2; padding: 10px; border-radius: 5px; overflow: auto;">';
        echo '<code style="font-family: Consolas, \'Courier New\', monospace;">';
        echo '$route->get("/user", function() use ($userController) {
    AuthMiddleware::checkLogin(); //<-- Cara pemanggilannya
    $userController->index();
});';
echo '<br><br>';
echo '$route->get("/", function(){
    View::render("wellcome/berhasil");
});';
        echo '</code>';
        echo '</pre>';
        ?>
        <b>Contoh Pemanggilan Route POST</b>
        <?php echo '<pre style="background-color: #2d2d2d; color: #f8f8f2; padding: 10px; border-radius: 5px; overflow: auto;">';
        echo '<code style="font-family: Consolas, \'Courier New\', monospace;">';
        echo '$route->post("/login", function() use ($userController) {
    $request = new Request();
    $userController->login($request);
});';
        echo '</code>';
        echo '</pre>';
        ?>
    </div>
</section>
