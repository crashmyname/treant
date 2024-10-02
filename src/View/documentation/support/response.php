<section class="section">
    <div class="section-header">
        <h1>Response</h1>
    </div>

    <div class="section-body">
        <h4>Helper Response</h4>
        <b>Helper Response adalah function untuk membuat hasil return nya menjadi json</b><br>
        Import Response:
        <?php echo '<pre style="background-color: #2d2d2d; color: #f8f8f2; padding: 10px; border-radius: 5px; overflow: auto;">';
        echo '<code style="font-family: Consolas, \'Courier New\', monospace;">';
        echo htmlentities('use Support\Response;');
        echo '</code>';
        echo '</pre>';
        ?>
        Contoh Penggunaan Response:
        <?php echo '<pre style="background-color: #2d2d2d; color: #f8f8f2; padding: 10px; border-radius: 5px; overflow: auto;">';
        echo '<code style="font-family: Consolas, \'Courier New\', monospace;">';
        echo htmlentities('$json = Response::json($data);');
        echo '<br>Untuk mengirimkan response json';
        echo '</code>';
        echo '</pre>';
        ?>
        Contoh Penggunaan Response Success:
        <?php echo '<pre style="background-color: #2d2d2d; color: #f8f8f2; padding: 10px; border-radius: 5px; overflow: auto;">';
        echo '<code style="font-family: Consolas, \'Courier New\', monospace;">';
        echo htmlentities('$json = Response::success("message success",200);');
        echo '<br>Untuk mengirimkan response json';
        echo '</code>';
        echo '</pre>';
        ?>
        Contoh Penggunaan Response error:
        <?php echo '<pre style="background-color: #2d2d2d; color: #f8f8f2; padding: 10px; border-radius: 5px; overflow: auto;">';
        echo '<code style="font-family: Consolas, \'Courier New\', monospace;">';
        echo htmlentities('$json = Response::error("message error",401);');
        echo '<br>Untuk mengirimkan response json';
        echo '</code>';
        echo '</pre>';
        ?>
    </div>
</section>
