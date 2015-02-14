<?php

namespace Bazo\Commands;


/**
 * @author Martin Bažík <martin@bazo.sk>
 */
interface Handler
{
	public function handle(Command $command);
}
