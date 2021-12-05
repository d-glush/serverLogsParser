<?php

require_once 'ConfigService/ConfigService.php';

spl_autoload_register(function ($class_name) {
    $classPath = '/' . str_replace('\\', '/', $class_name) . '.php';

    $configService = new ConfigService(__DIR__ . '/config.php');
    $priorities = $configService->getAutoloaderPriorities();

    foreach ($priorities as $folder) {
        if (is_readable($folder . $classPath)) {
            include $folder . $classPath;
            break;
        }
    }
});
