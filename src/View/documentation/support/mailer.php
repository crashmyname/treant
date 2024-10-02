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
        echo htmlentities('$mailer = new Mailer("penerima@example.com", "Subjek Email", "Isi pesan email.");');
        echo '</code>';
        echo '</pre>';
        ?>
        Menambahkan Header Custom:
        <?php echo '<pre style="background-color: #2d2d2d; color: #f8f8f2; padding: 10px; border-radius: 5px; overflow: auto;">';
        echo '<code style="font-family: Consolas, \'Courier New\', monospace;">';
        echo htmlentities('$mailer->addHeader("Cc: cc@example.com");
$mailer->addHeader("Bcc: bcc@example.com");
');
        echo '</code>';
        echo '</pre>';
        ?>
        Mengatur Pengirim (From Address)
        Jika Anda ingin mengatur alamat email pengirim yang berbeda dari default (no-reply@example.com), Anda bisa menggunakan metode setFrom():
        <?php echo '<pre style="background-color: #2d2d2d; color: #f8f8f2; padding: 10px; border-radius: 5px; overflow: auto;">';
        echo '<code style="font-family: Consolas, \'Courier New\', monospace;">';
        echo htmlentities('$mailer->setFrom("pengirim@example.com");');
        echo '</code>';
        echo '</pre>';
        ?>
        Menambahkan Lampiran (Opsional)
        Jika Anda perlu melampirkan file ke email, Anda bisa menggunakan metode addAttachment():
        <?php echo '<pre style="background-color: #2d2d2d; color: #f8f8f2; padding: 10px; border-radius: 5px; overflow: auto;">';
        echo '<code style="font-family: Consolas, \'Courier New\', monospace;">';
        echo htmlentities('$mailer->addAttachment("/path/to/file.txt"); // Menggunakan nama file asli
$mailer->addAttachment("/path/to/anotherfile.pdf", "document.pdf"); // Menggunakan nama file yang berbeda
');
        echo '</code>';
        echo '</pre>';
        ?>
        Menggunakan SMTP untuk Mengirim Email
        Jika Anda ingin mengirim email melalui SMTP (misalnya, menggunakan layanan email pihak ketiga seperti Gmail, SendGrid, dll.), Anda harus mengonfigurasi SMTP dengan menggunakan metode useSMTP():
        <?php echo '<pre style="background-color: #2d2d2d; color: #f8f8f2; padding: 10px; border-radius: 5px; overflow: auto;">';
        echo '<code style="font-family: Consolas, \'Courier New\', monospace;">';
        echo htmlentities('$mailer->useSMTP("smtp.example.com", "username", "password", 587, "tls");');
        echo '</code>';
        echo '</pre>';
        ?>
        Mengirim Email
        Setelah Anda selesai mengatur semua parameter yang diperlukan, Anda bisa mengirim email dengan memanggil metode send():
        <?php echo '<pre style="background-color: #2d2d2d; color: #f8f8f2; padding: 10px; border-radius: 5px; overflow: auto;">';
        echo '<code style="font-family: Consolas, \'Courier New\', monospace;">';
        echo htmlentities('if ($mailer->send()) {
    echo "Email berhasil dikirim!";
} else {
    echo "Email gagal dikirim.";
}
');
        echo '</code>';
        echo '</pre>';
        ?>
        Contoh Penggunaan Lengkap:
        <?php echo '<pre style="background-color: #2d2d2d; color: #f8f8f2; padding: 10px; border-radius: 5px; overflow: auto;">';
        echo '<code style="font-family: Consolas, \'Courier New\', monospace;">';
        echo htmlentities('use Support\Mailer;

$mailer = new Mailer("penerima@example.com", "Subjek Email", "<h1>Halo</h1><p>Ini adalah pesan email HTML.</p>");

// Menambahkan header
$mailer->addHeader("Cc: cc@example.com");
$mailer->addHeader("Bcc: bcc@example.com");

// Mengatur pengirim
$mailer->setFrom("pengirim@example.com");

// Menambahkan lampiran
$mailer->addAttachment("/path/to/file.txt");
$mailer->addAttachment("/path/to/anotherfile.pdf", "document.pdf");

// Menggunakan SMTP untuk mengirim email
$mailer->useSMTP("smtp.example.com", "username", "password", 587, "tls");

// Mengirim email
if ($mailer->send()) {
    echo "Email berhasil dikirim!";
} else {
    echo "Email gagal dikirim.";
}
');
        echo '</code>';
        echo '</pre>';
        ?>
    </div>
</section>
