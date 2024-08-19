<section class="section">
    <div class="section-header">
        <h1>Http</h1>
    </div>

    <div class="section-body">
        <h4>Helper Http</h4>
        <b>Helper Http adalah function untuk menggantikan CURL atau file get content untuk mendapatkan API</b><br>
        Import Http:
        <?php echo '<pre style="background-color: #2d2d2d; color: #f8f8f2; padding: 10px; border-radius: 5px; overflow: auto;">';
        echo '<code style="font-family: Consolas, \'Courier New\', monospace;">';
        echo htmlentities('use Support\Http;');
        echo '</code>';
        echo '</pre>';
        ?>
        Contoh Penggunaan Http GET:
        <?php echo '<pre style="background-color: #2d2d2d; color: #f8f8f2; padding: 10px; border-radius: 5px; overflow: auto;">';
        echo '<code style="font-family: Consolas, \'Courier New\', monospace;">';
        echo htmlentities('$http = Http::get("https://yourapi.com");');
        echo '<br>Untuk mendapatkan response api get';
        echo '</code>';
        echo '</pre>';
        ?>
        Contoh Penggunaan Http POST/PUT/DELETE:
        <?php echo '<pre style="background-color: #2d2d2d; color: #f8f8f2; padding: 10px; border-radius: 5px; overflow: auto;">';
        echo '<code style="font-family: Consolas, \'Courier New\', monospace;">';
        echo htmlentities('$data = [
            "name" => "John Doe",
            "email" => "john@example.com",
            "password" => "securepassword",
        ];
$http = Http::post("https://yourapi.com",$data);');
        echo '<br>Untuk mendapatkan response api get';
        echo '</code>';
        echo '</pre>';
        ?>
    </div>
</section>
