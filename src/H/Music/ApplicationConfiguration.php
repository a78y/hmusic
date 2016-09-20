<?php

namespace H\Music;

use Symfony\Component\Yaml\Yaml;

class ApplicationConfiguration implements ApplicationConfigurationInterface
{
	private $parser;
	private $configuration;

	// class constructor
    public function __construct()
    {
		$this->parser = new Yaml();
		$this->configuration = array();
    }

	// load configuration
    public function load($fileName) 
    {
    	// check exists configuration file
		if (file_exists($fileName)) 
		{
			// load configuration file
			if ($configuration = $this->parser->parse($fileName)) 
			{
				$this->configuration = array_merge_recursive($this->configuration, $configuration);

				// load extended configurations
				if (!empty($configuration['extends'])) 
				{
					// set string to array
					if (!is_array($configuration['extends'])) 
					{
						$configuration['extends'] = array($configuration['extends']);
					}

					foreach ($configuration['extends'] as $extendFileName)
					{
						$this->load(sprintf('%s/%s', dirname($fileName), $extendFileName));
					}
				}
			}
		}
		else {
 			throw new \RuntimeException(sprintf("Configuration file \"%s\" is not found.", $fileName));
		}

		return $this;
    }

    public function get() 
    {
    	return $this->configuration;
    }
}