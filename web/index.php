<?php

require_once __DIR__ . '/../vendor/autoload.php';

use H\Music\Application;

$app = new Application();
$app->register(new Silex\Provider\ServiceControllerServiceProvider());
$app->register(new DF\Silex\Provider\YamlConfigServiceProvider(dirname(__DIR__) . '/resources/config/application.yaml'));
$app->run();