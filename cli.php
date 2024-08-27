<?php
require_once __DIR__ . '/bin/support/CLI.php';
use Support\CLI;

// Inisialisasi CLI
$cli = new CLI();
$cli->run($argv);

?>