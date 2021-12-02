<?php

spl_autoload_register(function ($class_name) {
    $parts = explode('\\', $class_name);
    if ($parts[0] === 'App') {
        $parts[0] = __DIR__ . '/../src';
        $path = implode('/', $parts);
        if (!file_exists($path . '.php')) {
            die('file not found');
        }
        require_once($path . '.php');
    }
});
