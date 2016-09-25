<?php

namespace H\Music;

use Silex\Provider\ServiceControllerServiceProvider;
use DF\Silex\Provider\YamlConfigServiceProvider;
use H\Music\Provider;


class Application extends Silex\Application
{
    public function __construct($workPath)
    {
        parent::__construct();

        $this->register(new ServiceControllerServiceProvider());
		$this->register(new YamlConfigServiceProvider($workPath . '/resources/config/application.yaml'));

        $this->mount('/band', new Provider\BandControllerProvider());
    }
}