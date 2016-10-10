<?php

namespace H\Music;

use Silex;
use Silex\Provider\MonologServiceProvider;
use Silex\Provider\HttpCacheServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\DoctrineServiceProvider;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use DF\Silex\Provider\YamlConfigServiceProvider;
use Dflydev\Provider\DoctrineOrm\DoctrineOrmServiceProvider;

use H\Music\Provider\ControllerServiceProvider;

class Application extends Silex\Application
{
    public function __construct($workPath = NULL)
    {
        parent::__construct();

        $this->registerConfiguration($workPath);
        $this->registerProviders();
        $this->registerMiddleware();
        
        if ($this['config']['env'] == 'dev') 
        {
            $app['debug'] = TRUE;
        }
    }

    protected function registerConfiguration($workPath) 
    {
        $this['workPath'] = $workPath ? $workPath : __DIR__ . '/../../..';
        $this['applicationPath'] = $this['workPath'] . '/web';
        $this['sourcesPath'] = $this['workPath'] . '/src';
        $this['resourcesPath'] = $this['workPath'] . '/resources';
        $this['doctrinePath'] = $this['workPath'] . '/doctrine';
        $this['cachePath'] = $this['workPath'] . '/cache';
        $this['configFile'] = $this['workPath'] . '/resources/general.yaml';
        $this['logFile'] = sprintf('%s/resources/logs/%s.log', $this['workPath'], date('Y-m-d', time()));
    }
    
    protected function registerProviders()
    {
        $this->register(new YamlConfigServiceProvider($this['configFile']));
        $this->register(new HttpCacheServiceProvider(), array(
            'http_cache.cache_dir' => $this['cachePath'],
        ));
        $this->register(new MonologServiceProvider(), $this['config']['monolog'] + array(
            'monolog.logfile' => $this['logFile'],
        ));
        
        $this->register(new ServiceControllerServiceProvider());
        $this->register(new ControllerServiceProvider($this['config']['controllers']));

        $this->register(new DoctrineServiceProvider, $this['config']['database']['default']);
        $this->register(new DoctrineOrmServiceProvider, array(
            'orm.proxies_dir' => $this['doctrinePath'] . '/proxies',
            'orm.em.options' => array(
                'mappings' => array(
                    array(
                        'type' => 'annotation',
                        'alias' => 'Model',
                        'namespace' => 'H\Music\Model\Entity',
                        'path' => __DIR__ . '/Model/Entity',
                    ),
                ),
            ),
        ));
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
            $app['monolog']->error($e->getMessage());

            return $app->json(array(
                'message' => $e->getMessage(),
                'statusCode' => $code,
                'request' => $request,
                'stackTrace' => $e->getTraceAsString(),
            ), $code);
        });
    }

}
