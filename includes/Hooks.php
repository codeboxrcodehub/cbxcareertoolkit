<?php

namespace Cbx\Careertoolkit;

use Cbx\Careertoolkit\Factories\Resume\DummyResumeGenerate;
use Cbx\Careertoolkit\Factories\Job\DummyJobGenerate;
use Cbx\Careertoolkit\Factories\Misc\EasyPluginChecker;

class Hooks {
	public function __construct() {
		$this->init_commands();



		$helper = new Helper();

		add_filter( 'init', [ $helper, 'load_plugin_textdomain' ]);
		add_filter( 'pre_set_site_transient_update_plugins', [
			$helper,
			'pre_set_site_transient_update_plugins'
		] );
		add_filter( 'plugins_api', [ $helper, 'plugin_info' ], 10, 3 );

		add_filter( 'plugin_row_meta', [ $helper, 'plugin_row_meta' ], 10, 4 );
	}//end constructor

	public function init_commands() {
		if ( class_exists( "WP_CLI" ) ) {
			$resume = new DummyResumeGenerate();
			$jobs   = new DummyJobGenerate();
			$epc   = new EasyPluginChecker();
		}
	}//end method init_commands
}//end class Hooks