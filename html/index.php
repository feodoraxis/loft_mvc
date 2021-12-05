<?php
use Base\Application;

require_once __DIR__ . '/../src/config.php';
require_once ROOT_DIR . '/vendor/autoload.php';

$application = new Application();
$application->run();