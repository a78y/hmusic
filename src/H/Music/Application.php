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

use H\Music\Provider\ControllerMountServiceProvider;

/**
 * Application class.
 *
 * @author Yudin Alexey <alexeyvet@gmail.com>
 */
class Application extends Silex\Application
{
    /**
     * Class constructor.
     *
     * @param string  $workPath  Application work path
     */
    public function __construct($workPath)
    {
        parent::__construct();

        // register configuration variables
        $this->registerConfiguration($workPath);
        // register service providers
        $this->registerProviders();
        // define middleware
        $this->registerMiddleware();

        // settings for development environment
        if ($this['config']['env'] == 'dev')
        {
            $app['debug'] = TRUE;
        }
    }

    /**
     * Initialize configuration for application.
     *
     * @param string  $workPath  Application work path
     */
    protected function registerConfiguration($workPath)
    {
        // initialize environment paths
        $this['workPath'] = $workPath;
        $this['applicationPath'] = $this['workPath'] . '/web';
        $this['sourcesPath'] = $this['workPath'] . '/src';
        $this['resourcesPath'] = $this['workPath'] . '/resources';
        $this['doctrinePath'] = $this['resourcesPath'] . '/doctrine';
        $this['cachePath'] = $this['resourcesPath'] . '/cache';

        // make configuration file name
        $this['configFile'] = $this['resourcesPath'] . '/general.yaml';

        // make log file name
        $this['logFile'] = sprintf('%s/logs/%s.log', $this['resourcesPath'], date('Y-m-d', time()));
    }

    /**
     * Register service providers.
     */
    protected function registerProviders()
    {
        // register configuration provider
        $this->register(new YamlConfigServiceProvider($this['configFile']));
        // register cache provider
        $this->register(new HttpCacheServiceProvider(), array(
            'http_cache.cache_dir' => $this['cachePath'],
        ));
        // register logger provider
        $this->register(new MonologServiceProvider(), $this['config']['monolog'] + array(
            'monolog.logfile' => $this['logFile'],
        ));

        // register controller provider
        $this->register(new ServiceControllerServiceProvider());
        // register controller mounter provider
        $this->register(new ControllerMountServiceProvider($this['config']['controllers']));

        // register doctrine providers
        $this->register(new DoctrineServiceProvider, $this['config']['doctrine']['default']);
        $this->register(new DoctrineOrmServiceProvider, array(
            'orm.proxies_dir' => $this['doctrinePath'] . '/proxies',
            'orm.em.options' => array(
                'mappings' => array(
                    array(
                        'type' => 'annotation',
                        'alias' => $this['config']['doctrine']['alias'],
                        'namespace' => $this['config']['doctrine']['namespace'],
                        'path' => __DIR__ . '/Model/Entity',
                    ),
                ),
            ),
        ));
    }

    /**
     * Register middleware.
     */
    protected function registerMiddleware()
    {
        $app = $this;

        // allow cross-origin HTTP requests
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

        // allow cross-origin HTTP requests
        $app->after(function (Request $request, Response $response)
        {
            $response->headers->set('Access-Control-Allow-Origin', '*');
            $response->headers->set('Access-Control-Allow-Methods', 'GET,POST,PUT,DELETE,OPTIONS');
        });

        // prepare JSON requests
        $app->before(function (Request $request) {
            // check request content type
            if (0 === strpos($request->headers->get('Content-Type'), 'application/json'))
            {
                // decode request
                $json = json_decode($request->getContent(), true);
                // replace original request
                $request->request->replace(!is_array($json) ? $json : array());
            }
        });

        // exceptions handler
        $app->error(function(\Exception $e, Request $request, $code) use ($app)
        {
            // set exception message to log
            $app['monolog']->error($e->getMessage());

            // make response with exception information
            return $app->json(array(
                'message' => $e->getMessage(),
                'statusCode' => $code,
                'request' => $request,
                'stackTrace' => $e->getTraceAsString(),
            ), $code);
        });
    }

}
