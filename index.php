<?php
require_once __DIR__ . '/autoload.php';
require_once __DIR__ . '/route.php';
use Support\CORSMiddleware;

CORSMiddleware::handle();
?>