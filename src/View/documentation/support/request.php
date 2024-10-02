<section class="section">
    <div class="section-header">
        <h1>Request</h1>
    </div>

    <div class="section-body">
        <h4>Helper Request</h4>
        <b>Helper Request adalah function untuk menggantikan $_GET/$_POST untuk lebih mudah dibaca</b><br>
        Import Request:
        <?php echo '<pre style="background-color: #2d2d2d; color: #f8f8f2; padding: 10px; border-radius: 5px; overflow: auto;">';
        echo '<code style="font-family: Consolas, \'Courier New\', monospace;">';
        echo htmlentities('use Support\Request;');
        echo '</code>';
        echo '</pre>';
        ?>
        Contoh Penggunaan Request:
        <?php echo '<pre style="background-color: #2d2d2d; color: #f8f8f2; padding: 10px; border-radius: 5px; overflow: auto;">';
        echo '<code style="font-family: Consolas, \'Courier New\', monospace;">';
        echo htmlentities('$request->email | $request->nama <-- jadi mudah dibaca bukan?');
        echo '</code>';
        echo '</pre>';
        ?>
    </div>
</section>
