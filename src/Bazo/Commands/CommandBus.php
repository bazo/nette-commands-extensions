<?php

namespace Bazo\Commands;


use Nette;

/**
 * @author Martin Bažík <martin@bazik.sk>
 */
class CommandBus
{

	/** @var array */
	private $handlersMap = [];

	/** @var \Nette\DI\Container */
	private $container;

	/**
	 * @param array $handlersMap
	 * @param Nette\DI\Container $container
	 */
	public function __construct(array $handlersMap, Nette\DI\Container $container)
	{
		$this->handlersMap	 = $handlersMap;
		$this->container		 = $container;
	}


	public function handle($eventName, $eventArgs = [])
	{
		if (isset($this->handlersMap[$eventName])) {
			$handlers = $this->handlersMap[$eventName];
			foreach ($handlers as list($serviceName, $function)) {
				$service = $this->container->getService($serviceName);
				call_user_func_array([$service, $function], $eventArgs);
			}
		}
	}


}
