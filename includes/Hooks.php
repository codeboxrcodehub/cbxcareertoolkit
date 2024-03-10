<?php

namespace Cbx\Careertoolkit;

use Cbx\Careertoolkit\Factories\Resume\DummyResumeGenerate;
use Cbx\Careertoolkit\Factories\Job\DummyJobGenerate;

use Cbx\Careertoolkit\PDUpdater;

class Hooks
{

	public function __construct()
	{
		$this->init_commands();
		$this->update_checker();
	}

	public function init_commands()
	{
		if (class_exists("WP_CLI")) {
			$resume = new DummyResumeGenerate();
			$jobs = new DummyJobGenerate();
		}
	}//end method init_commands

	public function update_checker()
	{
		$updater = new PDUpdater(__FILE__);
		$updater->set_username('codeboxrcodehub');
		$updater->set_repository('cbxphpspreadsheet');
		$updater->authorize('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');
		$updater->initialize();


	}//end method update_checker
}//end class Hooks