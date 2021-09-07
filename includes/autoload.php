<?php
spl_autoload_register(function($class_name) {
    $parts = explode('\\', $class_name);
    if ($parts[0] === 'App') {
    $parts[0] = __DIR__ . '/../src';
    $path = implode('/', $parts);
    require_once($path . '.php');
}
});
?>
