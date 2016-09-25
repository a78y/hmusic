<?php

namespace H\Music\Controller;

use Silex\Api\ControllerProviderInterface;

use H\Music\Application;
use H\Music\Controller;

class BandControllerProvider implements ControllerProviderInterface
{
    function register(Application $app)
    {
        $app['band.controller'] = $app->share(function() use ($app) {
            return new Controller\BandController();
        });
    }

    public function connect(Application $application)
    {
        $controllers = $application['controllers_factory'];

        $controllers->get('/{id}', 'band.controller:get');
        $controllers->post('/{id}', 'band.controller:post');
        $controllers->put('/{id}', 'band.controller:put');
        $controllers->delete('/{id}', 'band.controller:delete');
        $controllers->get('/find', 'band.controller:find');

        return $controllers;
    }
}