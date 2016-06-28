<?php
session_start();

spl_autoload_register(function ($className) {
    $className = str_replace('\\', '/', $className);
    $fileName = 'classes/' . $className . '.php';
    if (file_exists($fileName)) {
        require($fileName);
    }
});

$app = new Application();
$app->run();