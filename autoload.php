<?php

spl_autoload_register(function (string $classFullName) {
    $filePath = str_replace('Geovendas\\StoreX', 'app', $classFullName);
    $filePath = str_replace('\\', DIRECTORY_SEPARATOR, $filePath);
    $filePath .= '.php';
    if (file_exists($filePath)) {
        require_once $filePath;
    }
});