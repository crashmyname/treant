<section class="section">
    <div class="section-header">
        <h1>Asset</h1>
    </div>

    <div class="section-body">
        <h4>Helper Asset</h4>
        <b>Helper Asset ini adalah function untuk memudahkan user mengakses folder public</b><br>
        Import Asset id route.php:
        <?php echo '<pre style="background-color: #2d2d2d; color: #f8f8f2; padding: 10px; border-radius: 5px; overflow: auto;">';
        echo '<code style="font-family: Consolas, \'Courier New\', monospace;">';
        echo htmlentities('require_once __DIR__ . "/bin/support/Asset.php";');
        echo '</code>';
        echo '</pre>';
        ?>
        Contoh Penggunaan Asset:
        <?php echo '<pre style="background-color: #2d2d2d; color: #f8f8f2; padding: 10px; border-radius: 5px; overflow: auto;">';
        echo '<code style="font-family: Consolas, \'Courier New\', monospace;">';
        echo htmlentities('untuk mengakses image
<img src="<?= asset("yourasset.jpg") ?>" alt="">');
        echo '</code>';
        echo '</pre>';
        ?>
        Contoh Penggunaan Asset untuk menagkses css atau template:
        <?php echo '<pre style="background-color: #2d2d2d; color: #f8f8f2; padding: 10px; border-radius: 5px; overflow: auto;">';
        echo '<code style="font-family: Consolas, \'Courier New\', monospace;">';
        echo htmlentities('untuk menagkses template
<link rel="stylesheet" href="<?= asset("adminlte/bootstrap.min.css") ?>">
<script src="<?= asset("adminlte/js/bootstrap.min.js") ?>"></script>');
        echo '</code>';
        echo '</pre>';
        ?>
    </div>
</section>
