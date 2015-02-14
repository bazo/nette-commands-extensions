<?php

namespace Bazo\Commands\DI;


use Nette\DI\CompilerExtension;
use Nette\DI\ContainerBuilder;
use Bazo\Commands\CommandBus;
use Bazo\Commands\Handler;
use Bazo\Commands\HandlerDoesNotImplementInterfaceException;
use Bazo\Commands\Helpers;
use Bazo\Commands\MultipleHandlersFoundException;

/**
 * @author Martin Bažík <martin@bazik.sk>
 */
class CommandsExtension extends CompilerExtension
{

	const TAG_HANDLER = 'handler';

	public function loadConfiguration()
	{
		$builder = $this->getContainerBuilder();

		$builder->addDefinition($this->prefix('bus'))
				->setClass(CommandBus::class)
				->setInject(FALSE);
	}


	public function beforeCompile()
	{
		$builder	 = $this->getContainerBuilder();
		$map		 = $this->createHandlersMap($builder);
		$dispatcher	 = $builder->getDefinition($this->prefix('bus'));
		$dispatcher->setArguments([$map]);
	}


	private function createHandlersMap(ContainerBuilder $builder)
	{
		$map = [];
		foreach ($builder->findByTag(self::TAG_HANDLER) as $serviceName => $tagProperties) {
			$def = $builder->getDefinition($serviceName);

			$class = $def->getClass();

			$implements = class_implements($class);
			if (!isset($implements[Handler::class])) {
				throw new HandlerDoesNotImplementInterfaceException(sprintf('Handler "%s" does not implement interface "%s"', $class, Handler::class));
			}

			$baseName = Helpers::extractBaseNameFromHandlerClass($class);

			if (isset($map[$baseName])) {
				throw new MultipleHandlersFoundException(sprintf('Multiple handlers found for "%s"', $baseName));
			}

			$map[$baseName] = $serviceName;
		}

		return $map;
	}


}
