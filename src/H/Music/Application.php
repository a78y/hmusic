<?php

namespace H\Music;

use Silex;
use Silex\Provider\DoctrineServiceProvider;
use Silex\Provider\MonologServiceProvider;
use Silex\Provider\HttpCacheServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use DF\Silex\Provider\YamlConfigServiceProvider;
use H\Music\Provider\ControllerServiceProvider;

class Application extends Silex\Application
{
    public function __construct($workPath)
    {
        parent::__construct();

        $this['workPath'] = $workPath;

        $this->registerProviders();
        $this->registerMiddleware();
    }

    protected function registerProviders()
    {
        $this->register(new ServiceControllerServiceProvider());
        $this->register(new YamlConfigServiceProvider(sprintf('%s/resources/general.yaml', $this['workPath'])));
        $this->register(new HttpCacheServiceProvider(), array(
            'http_cache.cache_dir' => $this['workPath'] . '/resources/cache',
        ));
        $this->register(new MonologServiceProvider(), $this['config']['monolog'] + array(
            'monolog.logfile' => sprintf('%s/resources/cache/%s.log', $this['workPath'], date('Y-m-d', time())),
        ));
        $this->register(new DoctrineServiceProvider(), $this['config']['database']['default']);
        $this->register(new ControllerServiceProvider($this['config']['controllers']));
    }

    protected function registerMiddleware()
    {
        $app = $this;

        $app->before(function(Request $request)
        {
            if ($request->getMethod() === "OPTIONS")
            {
                $response = new Response();
                $response->headers->set('Access-Control-Allow-Origin', '*');
                $response->headers->set('Access-Control-Allow-Methods', 'GET,POST,PUT,DELETE,OPTIONS');
                $response->headers->set('Access-Control-Allow-Headers', 'Content-Type');
                $response->setStatusCode(200);
                return $response->send();
            }
        }, Application::EARLY_EVENT);

        $app->after(function (Request $request, Response $response)
        {
            $response->headers->set('Access-Control-Allow-Origin', '*');
            $response->headers->set('Access-Control-Allow-Methods', 'GET,POST,PUT,DELETE,OPTIONS');
        });

        $app->before(function (Request $request) {
            if (0 === strpos($request->headers->get('Content-Type'), 'application/json'))
            {
                $json = json_decode($request->getContent(), true);
                if (!is_array($json))
                {
                  $json = array();
                }

                $request->request->replace($json);
            }
        });

        $app->error(function(\Exception $e, Request $request, $code) use ($app)
        {
            $app['monolog']->addError($e->getMessage());
            $app['monolog']->addError($e->getTraceAsString());

            return $app->json(array(
                'message' => $e->getMessage(),
                'statusCode' => $code,
                'request' => $request,
                'stackTrace' => $e->getTraceAsString(),
            ), $code);
        });
    }

}
