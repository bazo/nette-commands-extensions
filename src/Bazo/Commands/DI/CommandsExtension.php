<?php

namespace Bazo\Commands\DI;


use Nette;

/**
 * @author Martin Bažík <martin@bazik.sk>
 */
class CommandsExtension extends Nette\DI\CompilerExtension
{

	const TAG_HANDLER = 'handler';

	public function loadConfiguration()
	{
		$builder = $this->getContainerBuilder();

		$builder->addDefinition($this->prefix('bus'))
				->setClass(\Bazo\Commands\CommandBus::class)
				->setInject(FALSE);
	}


	public function beforeCompile()
	{
		$builder	 = $this->getContainerBuilder();
		$map		 = $this->createHandlersMap($builder);
		$dispatcher	 = $builder->getDefinition($this->prefix('bus'));
		$dispatcher->setArguments([$map]);
	}


	private function createHandlersMap(\Nette\DI\ContainerBuilder $builder)
	{
		$map = [];
		foreach ($builder->findByTag(self::TAG_HANDLER) as $serviceName => $tagProperties) {
			$def = $builder->getDefinition($serviceName);

			$class	 = $def->getClass();
			dump($class);exit;
		}

		return $map;
	}


}
