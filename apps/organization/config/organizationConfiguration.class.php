<?php

class organizationConfiguration extends sfApplicationConfiguration
{
	protected $serviceRouting = null;

	public function generateServiceUrl($name, $parameters = array())
	{		
		$request = sfContext::getInstance()->getRequest();		
		$retval = $request->isSecure()?'https://':'http://';
		$retval .= $request->getHost().$request->getRelativeUrlRoot().'/service.php'.$this->getServiceRouting()->generate($name, $parameters);
		return $retval;
		
	}

	public function getServiceRouting()
	{
		if (!$this->serviceRouting)
		{
			$this->serviceRouting = new sfPatternRouting(new sfEventDispatcher());

			$config = new sfRoutingConfigHandler();
			$routes = $config->evaluate(array(sfConfig::get('sf_apps_dir').'/service/config/routing.yml'));

			$this->serviceRouting->setRoutes($routes);
		}

		return $this->serviceRouting;
	}
	public function configure()
	{
	}
}
