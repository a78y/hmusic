<?php

require_once __DIR__ . '/../vendor/autoload.php';

use H\Music;

$configuration = new Music\ApplicationConfiguration();
$configuration->load(dirname(__DIR__) . '/resources/config/global.yaml');

$app = new Music\Application($configuration);
$app->run();