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
		$this->container	 = $container;
	}


	public function handle(Command $command)
	{
		$class		 = get_class($command);
		$baseName	 = Helpers::extractBaseNameFromCommandClass($class);
		if (isset($this->handlersMap[$baseName])) {
			$handler = $this->handlersMap[$baseName];
			$handler->handle($command);
		} else {
			throw new HandlerNotFoundException(sprintf('Handler for command "%s" not found', $class));
		}
	}


}
