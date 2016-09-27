<?php

namespace H\Music;

use Silex;
use DF;
use H\Music\Provider;

class Application extends Silex\Application
{
    public function __construct($workPath)
    {
        parent::__construct();

        $this['workPath'] = $workPath;

        $this->registerProviders();
        $this->mountControllers();
        $this->applySettings();
    }

    protected function registerProviders() 
    {
        $this->register(new DF\Silex\Provider\YamlConfigServiceProvider($this['workPath'] . '/resources/config/general.yaml'));
        $this->register(new Silex\Provider\ServiceControllerServiceProvider());
        $this->register(new Silex\Provider\DoctrineServiceProvider(), $this['config']['database']['default']);    	

        $this->register(new Provider\BandServiceProvider());    	
    }

    protected function mountControllers() 
    {
        $this->mount('/band', new Provider\BandControllerProvider());
    }

    protected function applySettings() 
    {
        $this['debug'] = $this['config']['debug'] ? $this['config']['debug'] : false;
    }
}
