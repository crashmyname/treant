<section class="section">
    <div class="section-header">
        <h1>UUID</h1>
    </div>

    <div class="section-body">
        <h4>Helper UUID</h4>
        <b>Helper UUID adalah function untuk mengenerate universal uniqid</b><br>
        Import UUID:
        <?php echo '<pre style="background-color: #2d2d2d; color: #f8f8f2; padding: 10px; border-radius: 5px; overflow: auto;">';
        echo '<code style="font-family: Consolas, \'Courier New\', monospace;">';
        echo htmlentities('use Support\UUID;');
        echo '</code>';
        echo '</pre>';
        ?>
        Contoh Penggunaan UUID:
        <?php echo '<pre style="background-color: #2d2d2d; color: #f8f8f2; padding: 10px; border-radius: 5px; overflow: auto;">';
        echo '<code style="font-family: Consolas, \'Courier New\', monospace;">';
        echo htmlentities('$uuid = UUID::generateUuid();');
        echo '<br>Akan menghasilkan UUID yang unique';
        echo '</code>';
        echo '</pre>';
        ?>
    </div>
</section>
