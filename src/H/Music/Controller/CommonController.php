<?php

namespace H\Music\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Common controller class.
 *
 * @author Yudin Alexey <alexeyvet@gmail.com>
 */
class CommonController
{
    public function login(Request $request, Application $app)
    {
        $args = $request->request->all();

        // validate request arguments
        if (empty($args['name']) || empty($args['password'])) {
            throw new \RuntimeException('Account name or password not found.');
        }

        // load user account
        $user = $app['users']->loadUserByUsername($args['name']);

        // validate account password
        if (!$app['security.encoder.digest']->isPasswordValid($user->getPassword(), $args['password'], '')) {
            throw new \RuntimeException(sprintf('Account "%s" not found.', $args['name']));
        }
        else {
            $response = array(
                'token' => $app['security.jwt.encoder']->encode(array(
                    'name' => $args['name'],
                )),
            );
        }

        return $response;
    }

    public function logout(Request $request, Application $app)
    {
        return 'LOGOUT';
    }

    public function info(Request $request, Application $app)
    {
        return array(
            'name' => $app['config']['name'],
            'version' => $app['config']['version'],
        );
    }
}
