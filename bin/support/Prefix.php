<?php
$envFile = __DIR__ . '/../../.env';
$env = parse_ini_file($envFile);

foreach ($env as $key => $value) {
    $_ENV[$key] = $value;
}

$prefix = $_ENV['ROUTE_PREFIX'] != null ? $_ENV['ROUTE_PREFIX'] : throw new Exception('Variabel lingkungan ROUTE_PREFIX tidak ditemukan atau kosong.');
return $prefix;
?>