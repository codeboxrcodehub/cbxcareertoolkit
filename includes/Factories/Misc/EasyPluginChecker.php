<?php
namespace Cbx\Careertoolkit\Factories\Misc;
use Cbx\Careertoolkit\Factories\Factory;

/**
 * Easy plugin checker command command
 * Class EasyPluginChecker
 * @since 1.0.1
 */
class EasyPluginChecker extends Factory{

	/**
	 * Register CLI command
	 * @since 1.0.0
	 */
	public function wp_cli_register_commands() {
		\WP_CLI::add_command( 'easy-plugin-check', [ $this, "run" ] );
	} //end method wp_cli_register_commands

	/**
	 * Command activity
	 *
	 * @param $args
	 * @param $assoc_args
	 *
	 * @since 1.0.0
	 */
	public function run( $args, $assoc_args ) {
		\WP_CLI::success("Plugin check output written to");
		global $wpdb;

		$plugin = $args[0];
		$exclude_directories = \WP_CLI\Utils\get_flag_value($assoc_args, 'exclude-directories', '');
		$format = \WP_CLI\Utils\get_flag_value($assoc_args, 'format', 'table'); // Default format is table
		$output_file = \WP_CLI\Utils\get_flag_value($assoc_args, 'output-file', '');

		// Set default output file if not provided
		if (empty($output_file)) {
			$output_file = ABSPATH . 'plugin-check.log';
		}

		// Build the command to check the plugin
		$command = sprintf(
			'wp plugin check %s --exclude-directories=%s --format=%s',
			escapeshellarg($plugin),
			escapeshellarg($exclude_directories),
			escapeshellarg($format)
		);

		// Execute the command and capture the output
		exec($command, $output, $return_var);

		if ($return_var !== 0) {
			\WP_CLI::error('Error running the plugin check command.');
		}

		// Combine the output into a single string
		$output_content = implode("\n", $output);

		// Clean the file (truncate) before writing new output
		if (file_put_contents($output_file, '') === false) {
			\WP_CLI::error('Failed to clear the output file.');
		}

		// Write the output to the file
		if (file_put_contents($output_file, $output_content) === false) {
			\WP_CLI::error('Failed to write output to the file.');
		}

		\WP_CLI::success("Plugin check output written to {$output_file}");
	} //end method run
} //end class EasyPluginChecker
