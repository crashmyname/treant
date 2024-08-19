<section class="section">
    <div class="section-header">
        <h1>CSRF</h1>
    </div>

    <div class="section-body">
        <h4>Helper CSRF</h4>
        <b>Cross Site Request Forgery atau yang dikenal sebagai CSRF adalah helper untuk mengenerate token saat melakukan transaksi apapun</b><br>
        Untuk menggunakan CSRF user harus menambahkan input hidden yang berisikan token csrf contoh penggunaan:
        <?php echo '<pre style="background-color: #2d2d2d; color: #f8f8f2; padding: 10px; border-radius: 5px; overflow: auto;">';
        echo '<code style="font-family: Consolas, \'Courier New\', monospace;">';
        echo htmlentities('<input type="hidden" name="csrf_token" value="$token">');
        echo '</code>';
        echo '</pre>';
        ?>
        Contoh Penggunaan dari Controller:
        <?php echo '<pre style="background-color: #2d2d2d; color: #f8f8f2; padding: 10px; border-radius: 5px; overflow: auto;">';
        echo '<code style="font-family: Consolas, \'Courier New\', monospace;">';
        echo htmlentities('use Support\CSRFToken;
$token = CSRFToken::generateToken();
$csrftoken = "<input type="hidden" name="csrf_token" value="$token">"');
        echo '</code>';
        echo '</pre>';
        ?>
        Pemanggilan di view:
        <?php echo '<pre style="background-color: #2d2d2d; color: #f8f8f2; padding: 10px; border-radius: 5px; overflow: auto;">';
        echo '<code style="font-family: Consolas, \'Courier New\', monospace;">';
        echo htmlentities('<form action="<?= $_ENV["ROUTE_PREFIX"]?>/store" id="" method="POST">
    <div class="card container-fluid ms-auto">
        <?= $csrftoken ?>
        nama : <input type="text" class="form-control" name="username" id="username"><br>
        email : <input type="email" class="form-control" name="email" id="email"required><br>
        password : <input type="password" class="form-control" name="password" id="password"required><br>
        <button type="submit" name="add" class="btn btn-success" id="add">Submit</button>
    </div>
</form>');
        echo '</code>';
        echo '</pre>';
        ?>
    </div>
</section>
