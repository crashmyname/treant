<section class="section">
    <div class="section-header">
        <h1>CORS</h1>
    </div>

    <div class="section-body">
        <h4>Helper CORS</h4>
        <b>Helper CORS ini adalah function memungkinkan peramban klien untuk meminta konfirmasi kepada server pihak ketiga apakah permintaan tersebut sah sebelum melakukan transfer data apa pun. </b><br>
        Contoh Penggunaan CORS:
        <?php echo '<pre style="background-color: #2d2d2d; color: #f8f8f2; padding: 10px; border-radius: 5px; overflow: auto;">';
        echo '<code style="font-family: Consolas, \'Courier New\', monospace;">';
        echo htmlentities('<?php
use Support\CORSMiddleware;

CORSMiddleware::handle();
?>');
        echo '</code>';
        echo '</pre>';
        ?>
        Pemakaian Code ini pada file index.php dan route.php
    </div>
</section>
