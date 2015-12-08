<?php
if (!defined('ENVIRONMENT')) {
    if (file_exists($envPath = __DIR__ . '/.environment')) {
        $env = strtolower(trim(file_get_contents($envPath)));
        define('ENVIRONMENT', $env);
    } else {
        define('ENVIRONMENT', 'production');
    }
}