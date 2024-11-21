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
use Support\Route;
use Support\View;
use Support\AuthMiddleware; //<-- Penambahan Middleware atau session login
use App\Controllers\YourController;
handleMiddleware(); //<-- jika diperlukan rate limiter

Route::get("/",function(){
    View::render("welcome/welcome");
})->name("home");
Route::get("/yourpath",[YourController::class,"index"]);
Route::get("/yourpath",[YourController::class,"index"])->name("index"); //<-- Bisa juga memberikan penamaan route seperti ini';
        echo '</code>';
        echo '</pre>';
        ?>
        <b>Contoh Pemanggilan Route GET</b>
        <?php echo '<pre style="background-color: #2d2d2d; color: #f8f8f2; padding: 10px; border-radius: 5px; overflow: auto;">';
        echo '<code style="font-family: Consolas, \'Courier New\', monospace;">';
        echo 'Route::get("/yourpath",[YourController::class,"index"],[AuthMiddleware::class]); //<-- Cara pemanggilan middlewarenya';
echo '<br><br>';
echo 'Route::get("/",function(){
    View::render("welcome/welcome");
})->name("home");';
        echo '</code>';
        echo '</pre>';
        ?>
        <b>Contoh Pemanggilan Route POST</b>
        <?php echo '<pre style="background-color: #2d2d2d; color: #f8f8f2; padding: 10px; border-radius: 5px; overflow: auto;">';
        echo '<code style="font-family: Consolas, \'Courier New\', monospace;">';
        echo 'Route::post("/yourpath",[YourController::class,"index"],[AuthMiddleware::class]);';
        echo '</code>';
        echo '</pre>';
        ?>
        <b>Contoh Pemanggilan Route PUT</b>
        <?php echo '<pre style="background-color: #2d2d2d; color: #f8f8f2; padding: 10px; border-radius: 5px; overflow: auto;">';
        echo '<code style="font-family: Consolas, \'Courier New\', monospace;">';
        echo 'Route::put("/yourpath/{id}",[YourController::class,"store"],[AuthMiddleware::class]);
&lt;form action="/resource/update/{id}" method="POST"&gt;
    &lt;?= method("PUT");?&gt;
    &lt;?= csrf();?&gt;
    &lt;input type="submit" value="Update"&gt;
&lt;/form&gt;

';
        echo '</code>';
        echo '</pre>';
        ?>
        <b>Contoh Pemanggilan Route DELETE</b>
        <?php echo '<pre style="background-color: #2d2d2d; color: #f8f8f2; padding: 10px; border-radius: 5px; overflow: auto;">';
        echo '<code style="font-family: Consolas, \'Courier New\', monospace;">';
        echo 'Route::delete("/yourpath/{id}",[YourController::class,"destroy"],[AuthMiddleware::class]);
&lt;form action="/resource/delete/{id}" method="POST"&gt;
    &lt;?= method("DELETE");?&gt;
    &lt;?= csrf();?&gt;
    &lt;input type="submit" value="Delete"&gt;
&lt;/form&gt;
';
        echo '</code>';
        echo '</pre>';
        ?>
        <b>Contoh Pemanggilan Route dengan NAME</b>
        <?php echo '<pre style="background-color: #2d2d2d; color: #f8f8f2; padding: 10px; border-radius: 5px; overflow: auto;">';
        echo '<code style="font-family: Consolas, \'Courier New\', monospace;">';
        echo 'Route::get("/dokumentasi", function(){
    $title = "Get Started";
    View::render("documentation/install",["title"=>$title],"documentation/doc");
})->name("instalasi");
&lt;a href="&lt;?= route("instalasi")?&gt"&gt Install &lt;/a&gt
';
        echo '</code>';
        echo '</pre>';
        ?>
        <b>Contoh Penggunaan Group Middleware</b>
        <?php echo '<pre style="background-color: #2d2d2d; color: #f8f8f2; padding: 10px; border-radius: 5px; overflow: auto;">';
        echo '<code style="font-family: Consolas, \'Courier New\', monospace;">';
        echo 'Route::group([AuthMiddleware::class], function(){
        // Place Your route here....
});';
        echo '</code>';
        echo '</pre>';
        ?>
    </div>
</section>
