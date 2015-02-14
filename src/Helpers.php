<?php

namespace Bazo\Commands;


/**
 * @author Martin Bažík <martin@bazo.sk>
 */
abstract class Helpers
{

	public static function extractBaseNameFromHandlerClass($class)
	{
		return self::extractBaseName($class, 'Handler');
	}


	public static function extractBaseNameFromCommandClass($class)
	{
		return self::extractBaseName($class, 'Command');
	}


	private static function extractBaseName($class, $suffix)
	{
		$parts = explode('\\', $class);
		return str_replace($suffix, '', array_pop($parts));
	}


}
