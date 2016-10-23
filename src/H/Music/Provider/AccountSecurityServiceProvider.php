<?php

namespace H\Music\Provider;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Silex\Application;

use H\Music\Security\AccountProvider;

/**
 * Accounts service provider.
 *
 * @author Yudin Alexey <alexeyvet@gmail.com>
 */
class AccountSecurityServiceProvider implements ServiceProviderInterface
{
    /**
     * Provider register.
     *
     * @param \Pimple\Container  $app  Application container
     */
    public function register(Container $app)
    {
        $app['users'] = function () use ($app) {
            return new AccountProvider($app['orm.em']->getRepository('Model:Account'), 'getByName');
        };

        // set up user provider
        $security = $app['config']['security'];
        $security['firewalls']['secured']['users'] = $app['users'];

        $app['security.jwt'] = $security['jwt'];
        $app['security.firewalls'] = $security['firewalls'];
    }
}
