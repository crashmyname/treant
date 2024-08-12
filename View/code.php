<?php
echo '<pre style="background-color: #2d2d2d; color: #f8f8f2; padding: 10px; border-radius: 5px; overflow: auto;">';
echo '<code style="font-family: Consolas, \'Courier New\', monospace;">';
echo htmlentities('<?php')."<br>";
echo 'require_once __DIR__ . \'/bin/support/Request.php\';<br>';
echo 'require_once __DIR__ . \'/bin/support/View.php\';<br>';
echo 'require_once __DIR__ . \'/bin/support/Asset.php\';<br>';
echo '$envFile = __DIR__ . \'/env\';<br>';
echo '// Tambahkan Controller dan Model dibawah untuk code diatas jangan diubah<br>';
echo '// atau di oprek karena helpers untuk menjalankan suatu function<br>';
echo 'require_once __DIR__ . \'/Controller/UserController.php\';<br>';
echo 'require_once __DIR__ . \'/Model/UserModel.php\';<br>';
echo '<br>';
echo '$env = parse_ini_file($envFile);<br>';
echo '<br>';
echo 'foreach ($env as $key => $value) {<br>';
echo '    $_ENV[$key] = $value;<br>';
echo '}<br>';
echo '</code>';
echo '</pre>';
?>
