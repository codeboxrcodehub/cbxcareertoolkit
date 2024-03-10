<?php

namespace Cbx\Careertoolkit\Factories;

use Faker\Factory as FakerFactory;

/**
 * Faker data generate class
 * Class Factory
 * @since 1.0.0
 */
abstract class Factory
{

	public function __construct()
	{
		//$this->faker = FakerFactory::create();
		$this->init_commands();
	}

	/**
	 * Initialize commands
	 * @since 1.0.0
	 */
	private function init_commands()
	{

		if (class_exists("WP_CLI")) {
			add_action('cli_init', [$this, 'wp_cli_register_commands']);
		}
	}//end method init_commands

	abstract public function wp_cli_register_commands();

	abstract public function run($args, $assoc_args);

}//end class Factory