<section class="section">
    <div class="section-header">
        <h1>Instalasi</h1>
    </div>

    <div class="section-body">
        <b>Pengguna bisa menginstallnya menggunakan composer</b>
        <?php echo '<pre style="background-color: #2d2d2d; color: #f8f8f2; padding: 10px; border-radius: 5px; overflow: auto;">';
        echo '<code style="font-family: Consolas, \'Courier New\', monospace;">';
        echo 'composer create-project fadli-dev/treant nama_proyek_masingmasing v1.3';
        echo '</code>';
        echo '</pre>';
        ?>
    </div>
    Setup .env jangan lupa untuk copy file .env.example menjadi .env dan setup env nya sesuai kebutuhan masing masing ;
    <?php echo '<pre style="background-color: #2d2d2d; color: #f8f8f2; padding: 10px; border-radius: 5px; overflow: auto;">';
    echo '<code style="font-family: Consolas, \'Courier New\', monospace;">';
    echo htmlentities('.env');
    echo '<br>';
    echo '<br>';
    echo 'DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=yourdatabase
DB_USERNAME=yourusername
DB_PASSWORD=yourpassword';
    echo '</code>';
    echo '</pre>';
    ?>
    lalu anda sudah bisa memulai membuat project yang kamu inginkan
    <br><br>
    <h4>Struktur Folder</h4>
    <?php echo '<pre style="background-color: #2d2d2d; color: #f8f8f2; padding: 10px; border-radius: 5px; overflow: auto;">';
    echo '<code style="font-family: Consolas, \'Courier New\', monospace;">';
    echo 'YourProject';
    echo '<br>';
    echo '|___app';
    echo '<br>';
    echo '     |___Controller';
    echo '<br>';
    echo '     |___Model';
    echo '<br>';
    echo '     |___View';
    echo '<br>';
    echo '           |___errors <-- untuk menangani custom error';
    echo '<br>';
    echo '|___bin';
    echo '<br>';
    echo '     |___support';
    echo '<br>';
    echo '|___config';
    echo '<br>';
    echo '|___node_modules';
    echo '<br>';
    echo '|___public';
    echo '<br>';
    echo '|___routes';
    echo '<br>';
    echo '     |___route.php';
    echo '<br>';
    echo '     |___api.php';
    echo '<br>';
    echo '.env';
    echo '<br>';
    echo '.env.example';
    echo '<br>';
    echo '.htaccess';
    echo '<br>';
    echo '.gitignore';
    echo '<br>';
    echo 'autoload.php';
    echo '<br>';
    echo 'treant';
    echo '<br>';
    echo 'index.php';
    echo '<br>';
    echo '</code>';
    echo '</pre>';
    ?>
</section>
