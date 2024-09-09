<?php
require_once __DIR__ . '/autoload.php';
require_once __DIR__ . '/routes/route.php';
use Support\CORSMiddleware;

CORSMiddleware::handle();
?>