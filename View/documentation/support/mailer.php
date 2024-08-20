<section class="section">
    <div class="section-header">
        <h1>Mailer</h1>
    </div>

    <div class="section-body">
        <h4>Helper Mailer</h4>
        <b>Helper Mailer adalah function untuk mengirimkam email</b><br>
        Import Mailer:
        <?php echo '<pre style="background-color: #2d2d2d; color: #f8f8f2; padding: 10px; border-radius: 5px; overflow: auto;">';
        echo '<code style="font-family: Consolas, \'Courier New\', monospace;">';
        echo htmlentities('use Support\Mailer;');
        echo '</code>';
        echo '</pre>';
        ?>
        Contoh Penggunaan Mailer di controller:
        <?php echo '<pre style="background-color: #2d2d2d; color: #f8f8f2; padding: 10px; border-radius: 5px; overflow: auto;">';
        echo '<code style="font-family: Consolas, \'Courier New\', monospace;">';
        echo htmlentities('$email = Mailer::send($tujuan,$subject,$message,$headers)');
        echo '</code>';
        echo '</pre>';
        ?>
    </div>
</section>
