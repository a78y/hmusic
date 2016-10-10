<?php

require_once __DIR__ . '/../vendor/autoload.php';

$app = new H\Music\Application(dirname(__DIR__));
$app->run();
