<?php

namespace H\Music;

use Silex;

class Application extends Silex\Application
{
    private $configuration;
    
    public function __construct(ApplicationConfigurationInterface $configuration)
    {
        parent::__construct();

        $this->configuration = $configuration->get();

        if (isset($this->configuration['debug'])) {
            $this->config['debug'] = (bool) $this->configuration['debug'];
        }
    }
}