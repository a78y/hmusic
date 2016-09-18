<?php

namespace H\Music;

use H\Music\ControllerProvider;
use H\Music\Controller;

use Silex;

class Application extends Silex\Application
{

    public function __construct($debug = true)
    {
        parent::__construct();

        $this->setDebug($debug);
        $this->registerProviders();
        $this->mountControllers();
    }

    protected function setDebug($state = false)
    {
        $this['debug'] = $state;
    }

    protected function registerProviders()
    {
        $this->register(new Silex\Provider\ServiceControllerServiceProvider());
    }

    protected function mountControllers()
    {
        $this->mount('/bands', new Controller\BandControllerProvider());
    }

}