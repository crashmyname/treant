<section class="section">
    <div class="section-header">
        <h1>Rate Limiter</h1>
    </div>

    <div class="section-body">
        <h4>Helper Rate Limiter</h4>
        <b>Helper Rate Limiter adalah function untuk mencegah request terus menerus dalam waktu singkat</b><br>
        Import Rate Limiter di route.php:
        <?php echo '<pre style="background-color: #2d2d2d; color: #f8f8f2; padding: 10px; border-radius: 5px; overflow: auto;">';
        echo '<code style="font-family: Consolas, \'Courier New\', monospace;">';
        echo htmlentities('use Support\RateLimiter;');
        echo '</code>';
        echo '</pre>';
        ?>
        Contoh Penggunaan RateLimiter:
        <?php echo '<pre style="background-color: #2d2d2d; color: #f8f8f2; padding: 10px; border-radius: 5px; overflow: auto;">';
        echo '<code style="font-family: Consolas, \'Courier New\', monospace;">';
        echo htmlentities('$rateLimiter = new RateLimiter();
if (!$rateLimiter->check($_SERVER["REMOTE_ADDR"])) {
    http_response_code(429);
    View::render("errors/429",[]);
    exit();
}');
        echo '</code>';
        echo '</pre>';
        ?>
    </div>
</section>
