<?php
define("ROOT_DIR", __DIR__ . '/..');

define("DB_HOST", "localhost");
define("DB_NAME", "mvc");
define("DB_USER", "root");
define("DB_PASSWORD", "root");

function d(...$arr) {
    echo '<pre>';
    var_dump($arr);
    echo '</pre>';
}