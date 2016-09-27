<?php

namespace H\Music\Provider;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use H\Music\Controller;

class BandServiceProvider implements ServiceProviderInterface
{

    public function register(Container $app)
    {
        $app['band.controller'] = function() use ($app) {
            return new Controller\BandController();
        };
    }
}