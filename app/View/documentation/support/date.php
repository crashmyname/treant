<section class="section">
    <div class="section-header">
        <h1>Date</h1>
    </div>

    <div class="section-body">
        <h4>Helper Date</h4>
        <b>Helper Date ini adalah function untuk mempermudah mendapatkan tanggal yang sesuai format. </b><br>
        Import Date:
        <?php echo '<pre style="background-color: #2d2d2d; color: #f8f8f2; padding: 10px; border-radius: 5px; overflow: auto;">';
        echo '<code style="font-family: Consolas, \'Courier New\', monospace;">';
        echo htmlentities('use Support\Date;');
        echo '</code>';
        echo '</pre>';
        ?>
        Contoh Penggunaan Date Now:
        <?php echo '<pre style="background-color: #2d2d2d; color: #f8f8f2; padding: 10px; border-radius: 5px; overflow: auto;">';
        echo '<code style="font-family: Consolas, \'Courier New\', monospace;">';
        echo htmlentities('$date = Date::Now();');
        echo '<br>Code ini akan menghasilkan Tanggal sekarang, jam, menit serta detik';
        echo '</code>';
        echo '</pre>';
        ?>
        Contoh Penggunaan Date Day:
        <?php echo '<pre style="background-color: #2d2d2d; color: #f8f8f2; padding: 10px; border-radius: 5px; overflow: auto;">';
        echo '<code style="font-family: Consolas, \'Courier New\', monospace;">';
        echo htmlentities('$date = Date::Day();');
        echo '<br>Akan menghasilkan hari sekarang';
        echo '</code>';
        echo '</pre>';
        ?>
        Contoh Penggunaan Date Month:
        <?php echo '<pre style="background-color: #2d2d2d; color: #f8f8f2; padding: 10px; border-radius: 5px; overflow: auto;">';
        echo '<code style="font-family: Consolas, \'Courier New\', monospace;">';
        echo htmlentities('$date = Date::Month();');
        echo '<br>Akan menghasilkan bulan sekarang';
        echo '</code>';
        echo '</pre>';
        ?>
        Contoh Penggunaan Date Year:
        <?php echo '<pre style="background-color: #2d2d2d; color: #f8f8f2; padding: 10px; border-radius: 5px; overflow: auto;">';
        echo '<code style="font-family: Consolas, \'Courier New\', monospace;">';
        echo htmlentities('$date = Date::Year();');
        echo '<br>Akan menghasilkan tahun sekarang';
        echo '</code>';
        echo '</pre>';
        ?>
        Contoh Penggunaan Date Parse:
        <?php echo '<pre style="background-color: #2d2d2d; color: #f8f8f2; padding: 10px; border-radius: 5px; overflow: auto;">';
        echo '<code style="font-family: Consolas, \'Courier New\', monospace;">';
        echo htmlentities('$date = Date::parse(2024-10-10)->format("d-m-Y");');
        echo '<br>akan merubah format menjadi sesuai yang diinginkan';
        echo '</code>';
        echo '</pre>';
        ?>
        Contoh Penggunaan Date startOfDay:
        <?php echo '<pre style="background-color: #2d2d2d; color: #f8f8f2; padding: 10px; border-radius: 5px; overflow: auto;">';
        echo '<code style="font-family: Consolas, \'Courier New\', monospace;">';
        echo htmlentities('$date = Date::parse(2024-10-10)->startOfDay();');
        echo '<br>Akan menghasilkan tanggal serta jam menit detik di 00:00:00';
        echo '</code>';
        echo '</pre>';
        ?>
        Contoh Penggunaan Date endOfDay:
        <?php echo '<pre style="background-color: #2d2d2d; color: #f8f8f2; padding: 10px; border-radius: 5px; overflow: auto;">';
        echo '<code style="font-family: Consolas, \'Courier New\', monospace;">';
        echo htmlentities('$date = Date::parse(2024-10-10)->endOfDay();');
        echo '<br>Akan menghasilkan tanggal serta jam menit detik di 23:59:59';
        echo '</code>';
        echo '</pre>';
        ?>
    </div>
</section>
