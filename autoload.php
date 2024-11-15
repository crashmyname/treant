<?php
spl_autoload_register(function ($class) {
    $prefix = 'Config\\'; // Namespace prefix for Config classes
    $base_dir = __DIR__ . '/config/';

    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

    if (file_exists($file)) {
        require $file;
    }
});

spl_autoload_register(function ($class) {
    $prefix = 'App\\Models\\'; // Namespace prefix for Model classes
    $base_dir = __DIR__ . '/app/Models/';

    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

    if (file_exists($file)) {
        require $file;
    }
});

spl_autoload_register(function ($class) {
    $prefix = 'App\\Controllers\\'; // Namespace prefix for Controller classes
    $base_dir = __DIR__ . '/app/Controllers/';

    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

    if (file_exists($file)) {
        require $file;
    }
});

spl_autoload_register(function ($class) {
    $prefix = 'Support\\'; // Namespace prefix for Support classes
    $base_dir = __DIR__ . '/bin/support/';

    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

    if (file_exists($file)) {
        require $file;
    }
});
require_once __DIR__ . '/bin/support/helper.php';
require_once __DIR__ . '/bin/support/Prefix.php';
require_once __DIR__ . '/bin/support/Rc.php';
Use Support\Route;
Use Support\Api;
if (php_sapi_name() === 'cli') {
    // Script berjalan di CLI, handle CLI commands di sini
    echo "Starting cli......";
} else {
    // Script berjalan di server web, aman untuk menggunakan $_SERVER['REQUEST_URI']
    $uri = isset($_SERVER['REQUEST_URI']) ? trim($_SERVER['REQUEST_URI']) : '/';
    $apiPrefix = '/' . basename(__DIR__) . '/api';

    // Cek apakah URI mengarah ke API
    if (strpos($uri, $apiPrefix) === 0) {
        Api::init($prefix . '/api');
    } else {
        Route::init($prefix);
    }
}
?>