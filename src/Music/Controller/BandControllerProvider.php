<?php

namespace H\Music\Controller;

use Silex\Application;
use Silex\Api\ControllerProviderInterface;

class BandControllerProvider implements ControllerProviderInterface
{
    public function connect(Application $app)
    {
        $controllers = $app['controllers_factory'];

        $controllers->get('/band', 'H\\Music\\Controller\\BandController::get');
        $controllers->post('/band', 'H\\Music\\Controller\\BandController::post');
        $controllers->put('/band', 'H\\Music\\Controller\\BandController::put');
        $controllers->delete('/band', 'H\\Music\\Controller\\BandController::delete');
        $controllers->get('/find', 'H\\Music\\Controller\\BandController::find');

        return $controllers;
    }
}
