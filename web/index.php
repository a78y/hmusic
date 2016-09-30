<?php

require_once __DIR__ . '/../vendor/autoload.php';

$class = 'H\Music\Controller\BandController';
$instance = new $class();

$app = new H\Music\Application(dirname(__DIR__));
$app->run();
