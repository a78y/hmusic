<?php

namespace H\Music\Provider;

use Silex;
use Silex\Api\ControllerProviderInterface;
use H\Music\Controller;

class BandControllerProvider implements ControllerProviderInterface
{
    public function connect(Silex\Application $application)
    {
        $controllers = $application['controllers_factory'];

        $controllers
            ->get('/{id}', 'band.controller:get')
            ->assert('id', '\d+')
            ->bind('band.controller.get');
        $controllers
            ->post('/{id}', 'band.controller:post')
            ->assert('id', '\d+')
            ->bind('band.controller.post');
        $controllers
            ->put('/{id}', 'band.controller:put')
            ->assert('id', '\d+')
            ->bind('band.controller.put');
        $controllers
            ->delete('/{id}', 'band.controller:delete')
            ->assert('id', '\d+')
            ->bind('band.controller.delete');
        $controllers
            ->get('/list', 'band.controller:browse')
            ->bind('band.controller.list');
        $controllers
            ->post('/find', 'band.controller:find')
            ->bind('band.controller.find');

        return $controllers;
    }
}