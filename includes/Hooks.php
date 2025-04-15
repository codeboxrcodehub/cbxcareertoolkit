<?php

namespace Cbx\Careertoolkit;

use Cbx\Careertoolkit\Factories\Resume\DummyResumeGenerate;
use Cbx\Careertoolkit\Factories\Job\DummyJobGenerate;
use Cbx\Careertoolkit\Factories\Misc\EasyPluginChecker;

class Hooks {

	public function __construct() {
		$this->init_commands();
		$this->update_checker();

		$helper = new Helper();

		add_filter( 'init', [ $helper, 'load_plugin_textdomain' ]);
	}

	public function init_commands() {
		if ( class_exists( "WP_CLI" ) ) {
			$resume = new DummyResumeGenerate();
			$jobs   = new DummyJobGenerate();
			$epc   = new EasyPluginChecker();
		}
	}//end method init_commands

	/**
	 * Plugin updater hooks
	 *
	 * @return void
	 */
	public function update_checker() {

		$helper = new Helper();

		add_filter( 'pre_set_site_transient_update_plugins', [
			$helper,
			'pre_set_site_transient_update_plugins'
		] );
		add_filter( 'plugins_api', [ $helper, 'plugin_info' ], 10, 3 );
	}//end method update_checker
}//end class Hooks