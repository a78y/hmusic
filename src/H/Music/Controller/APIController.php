<?php

namespace H\Music\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

/**
 * API controller class.
 *
 * @author Yudin Alexey <alexeyvet@gmail.com>
 */
class APIController
{
    public function login(Request $request, Application $app)
    {
        return 'LOGIN';
    }

    public function logout(Request $request, Application $app)
    {
        return 'LOGOUT';
    }

    public function version(Request $request, Application $app)
    {
        return 'VERSION';
    }

    public function name(Request $request, Application $app)
    {
        return 'NAME';
    }
}
