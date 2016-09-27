<?php

namespace H\Music\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class BandController
{
    public function get(Request $request, Application $app)
    {
        return 'GET';
    }

    public function post(Request $request, Application $app)
    {
        return 'POST';
    }

    public function put(Request $request, Application $app)
    {
        return 'PUT';
    }

    public function delete(Request $request, Application $app)
    {
        return 'DELETE';
    }

    public function browse(Request $request, Application $app)
    {
        return 'List';
    }

    public function find(Request $request, Application $app)
    {
        return 'Find';
    }
}
