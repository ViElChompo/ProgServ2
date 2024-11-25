<?php

session_start();

require_once __DIR__ . '/libs/helpers.php';
require_once  __DIR__ . '/libs/sanitization.php';
require_once  __DIR__ . '/libs/validation.php';
require_once  __DIR__ . '/libs/filter.php';
require_once  __DIR__ . '/libs/flash.php';
require_once __DIR__ . '/auth.php';

spl_autoload_register(function ($class) {
    $file = __DIR__ . '/' . str_replace('\\', '/', $class) . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
});