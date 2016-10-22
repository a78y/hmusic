<?php

namespace H\Music\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

/**
 * Accounts controller class.
 *
 * @author Yudin Alexey <alexeyvet@gmail.com>
 */
class AccountController
{
    public function create(Request $request, Application $app)
    {
        return 'CREATE';
    }

    public function update(Request $request, Application $app)
    {
        return 'UPDATE';
    }

    public function delete(Request $request, Application $app)
    {
        return 'DELETE';
    }

    public function load(Request $request, Application $app)
    {
        $repository = $app['orm.em']->getRepository('Model:Account');

        return 'LOAD';
    }

    public function find(Request $request, Application $app)
    {
        return 'Find';
    }
}
