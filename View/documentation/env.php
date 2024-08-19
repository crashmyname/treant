<section class="section">
    <div class="section-header">
        <h1>ENV</h1>
    </div>

    <div class="section-body">
        <b>Untuk mengatur database pengguna bisa melakukan setup pada file .env</b>
    </div>
    Contoh :
    <?php echo '<pre style="background-color: #2d2d2d; color: #f8f8f2; padding: 10px; border-radius: 5px; overflow: auto;">';
    echo '<code style="font-family: Consolas, \'Courier New\', monospace;">';
    echo 'DB_CONNECTION=mysql <-- koneksi database, jika anda menggunakan selain mysql tinggal rubah disini
DB_HOST=127.0.0.1 <-- host default
DB_PORT=3306 <-- database port nya
DB_DATABASE=yourdatabase <-- masukkan database kamu
DB_USERNAME=yourusername <-- masukkan usernamenya
DB_PASSWORD=yourpassword <-- masukkan passwordnya
ROUTE_PREFIX=/mvc <-- route_prefix ini digunakan untuk melakukan akses ke route jika di view tidak ditambahkan pasti error';
    echo '</code>';
    echo '</pre>';
    ?>
    <br><br>
</section>
