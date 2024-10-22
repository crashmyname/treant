<section class="section">
    <div class="section-header">
        <h1>Auth</h1>
    </div>

    <div class="section-body">
        <h4>Helper Authmiddleware</h4>
        <b>Helper Authmiddleware ini adalah function untuk melakukan session seperti login</b><br>
        Import AuthMiddleware di file route.php:
        <?php echo '<pre style="background-color: #2d2d2d; color: #f8f8f2; padding: 10px; border-radius: 5px; overflow: auto;">';
        echo '<code style="font-family: Consolas, \'Courier New\', monospace;">';
        echo htmlentities('use Support\AuthMiddleware;');
        echo '</code>';
        echo '</pre>';
        ?>
        <b>Pemanggilaan helper auth ini berada pada file route.php dan jangan lupa untuk menjalankan session diatas route</b><br>
        didalam Authmiddleware memiliki dua metode yaitu checkLogin dan checkToken:
        <?php echo '<pre style="background-color: #2d2d2d; color: #f8f8f2; padding: 10px; border-radius: 5px; overflow: auto;">';
        echo '<code style="font-family: Consolas, \'Courier New\', monospace;">';
        echo htmlentities('session_start();
use Support\AuthMiddleware;
AuthMiddleware::checkLogin(); <-- untuk session login
AuthMiddleware::checkToken(); <-- untuk cek token jika ada penggunaan api');
        echo '</code>';
        echo '</pre>';
        ?>
        Contoh Penggunaan Authmiddleware Check Login:
        <?php echo '<pre style="background-color: #2d2d2d; color: #f8f8f2; padding: 10px; border-radius: 5px; overflow: auto;">';
        echo '<code style="font-family: Consolas, \'Courier New\', monospace;">';
        echo htmlentities('use Support\AuthMiddleware;

Route::group([AuthMiddleware::class], function(){
    Route::get("/dokumentasi/omodel", function(){
        $title = "Old Model";
        View::render("documentation/old-model",["title"=>$title],"documentation/doc");
    });
});');
        echo '</code>';
        echo '</pre>';
        ?>
        Contoh Penggunaan Authmiddleware Check Token:
        <?php echo '<pre style="background-color: #2d2d2d; color: #f8f8f2; padding: 10px; border-radius: 5px; overflow: auto;">';
        echo '<code style="font-family: Consolas, \'Courier New\', monospace;">';
        echo htmlentities('use Support\AuthMiddleware;

Api::group([AuthMiddleware::class], function(){
    Api::get("/dokumentasi/omodel", function(){
        $title = "Old Model";
        View::render("documentation/old-model",["title"=>$title],"documentation/doc");
    });
});');
        echo '</code>';
        echo '</pre>';
        ?>
    </div>
</section>
