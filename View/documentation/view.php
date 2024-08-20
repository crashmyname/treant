<section class="section">
    <div class="section-header">
        <h1>View</h1>
    </div>

    <div class="section-body">
        <h4>View adalah struktur folder halaman yang akan diakses</h4>
        <b>disini juga dijelaskan helper View</b><br>
        Import View:
        <?php echo '<pre style="background-color: #2d2d2d; color: #f8f8f2; padding: 10px; border-radius: 5px; overflow: auto;">';
        echo '<code style="font-family: Consolas, \'Courier New\', monospace;">';
        echo 'use Support\View;';
        echo '</code>';
        echo '</pre>';
        ?>
        Contoh Penggunaan View Render:
        <?php echo '<pre style="background-color: #2d2d2d; color: #f8f8f2; padding: 10px; border-radius: 5px; overflow: auto;">';
        echo '<code style="font-family: Consolas, \'Courier New\', monospace;">';
        echo 'View::render("user/user",[],"navbar/navbar") <-- jika tidak membawa parameter <br>';
        echo 'View::render("user/user",["user"=>$user],"navbar/navbar") <-- jika membawa parameter';
        echo '</code>';
        echo '</pre>';
        ?>
        Contoh Penggunaan View Redirect:
        <?php echo '<pre style="background-color: #2d2d2d; color: #f8f8f2; padding: 10px; border-radius: 5px; overflow: auto;">';
        echo '<code style="font-family: Consolas, \'Courier New\', monospace;">';
        echo 'View::redirectTo($_ENV["ROUTE_PREFIX"]."/user") <-- melakukan redirect ke url user';
        echo '</code>';
        echo '</pre>';
        ?>
    </div>
</section>
