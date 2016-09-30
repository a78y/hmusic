<?php

namespace H\Music\Provider;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Silex\Application;
use Silex\ControllerCollection;

class ControllerProvider implements ServiceProviderInterface
{
    protected $controllers;

    public function __construct($controllers)
    {
        $this->controllers = $controllers;
    }

    public function register(Container $app)
    {
        if ($app instanceof Application)
        {
            foreach ($this->controllers as $name => $controller)
            {
                $this->mountController($app, $name, $controller);
            }
        }
    }

    protected function mountController(Application $app, $name, $controller)
    {
        $app[$name] = function() use ($controller)
        {
            return new $controller['class']();
        };

        $factory = $app['controllers_factory'];
        foreach ($controller['routes'] as $name => $route)
        {
            $this->mountControllerRoute($factory, $name, $route);
        }

        $app->mount($controller['prefix'], $factory);
    }

    protected function mountControllerRoute(ControllerCollection $factory, $name, $route)
    {
        $route += array(
            'method' => 'GET',
            'assert' => array(),
        );

        $controller = $factory->match($route['pattern'], $route['class']);
        $controller->method($route['method']);
        $controller->bind($name);

        foreach ($route['assert'] as $arg => $pattern)
        {
            $controller->assert($arg, $pattern);
        }
    }
}
