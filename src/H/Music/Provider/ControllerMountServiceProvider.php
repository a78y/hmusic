<?php

namespace H\Music\Provider;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Silex\Application;
use Silex\ControllerCollection;

/**
 * Controllers service provider.
 *
 * @author Yudin Alexey <alexeyvet@gmail.com>
 */
class ControllerMountServiceProvider implements ServiceProviderInterface
{
    protected $controllers;

    /**
     * Class constructor.
     *
     * @param array  $controllers  Array of controllers data
     */
    public function __construct(array $controllers)
    {
        $this->controllers = $controllers;
    }

    /**
     * Provider register.
     *
     * @param \Pimple\Container  $app  Application container
     */
    public function register(Container $app)
    {
        if ($app instanceof Application) {
            foreach ($this->controllers as $name => $controller) {
                // create controller service
                $this->mountController($app, $name, $controller);
            }
        }
    }

    /**
     * Mount controller and routes.
     *
     * @param \Silex\Application  $app         Application object
     * @param string              $name        Controller name
     * @param array               $controller  Controller data
     */
    protected function mountController(Application $app, $name, array $controller)
    {
        // create controller service
        $app[$name] = function() use ($controller) {
            return new $controller['class']();
        };

        // create controllers factory
        $factory = $app['controllers_factory'];

        foreach ($controller['routes'] as $route_name => $route) {
            // create controller routes
            $this->mountControllerRoute($factory, $name, $route_name, $route);
        }

        // mount controller routes
        $app->mount($controller['prefix'], $factory);
    }

    /**
     * Mount controller route.
     *
     * @param \Silex\ControllerCollection  $factory          Controller factory
     * @param string                       $controller_name  Controller name
     * @param string                       $route_name       Route name
     * @param array                        $route            Route data
     */
    protected function mountControllerRoute(ControllerCollection $factory, $controller_name, $route_name, $route)
    {
        // extend route settings
        $route += array(
            'method' => 'GET',
            'assert' => array(),
        );

        $class_name = sprintf('%s:%s', $controller_name, $route_name);
        if (!empty($route['class'])) {
            $class_name = $route['class'];
        }

        $route_name = sprintf('%s.%s', $controller_name, $route_name);
        if (!empty($route['name'])) {
            $route_name = empty($route['name']);
        }

        // create controller route
        $controller = $factory->match($route['pattern'], $class_name);
        $controller->method($route['method']);
        $controller->bind($route_name);

        foreach ($route['assert'] as $arg => $pattern) {
            // add assert rule
            $controller->assert($arg, $pattern);
        }
    }
}
