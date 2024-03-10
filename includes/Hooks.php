<?php

namespace Cbx\Careertoolkit;

use Cbx\Careertoolkit\Factories\Resume\DummyResumeGenerate;
use Cbx\Careertoolkit\Factories\Job\DummyJobGenerate;

class Hooks
{

	public function __construct()
	{
		$this->init_commands();
	}

	public function init_commands()
	{
		if (class_exists("WP_CLI")) {
			$resume = new DummyResumeGenerate();
			$jobs = new DummyJobGenerate();
		}
	}//end method init_commands
}//end class Hooks