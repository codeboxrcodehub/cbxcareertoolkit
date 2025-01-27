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
		global $wpdb;

		$plugin = $args[0];
		$exclude_directories = \WP_CLI\Utils\get_flag_value($assoc_args, 'exclude-directories', '');
		$format = \WP_CLI\Utils\get_flag_value($assoc_args, 'format', 'table'); // Default format is table
		$output_file = \WP_CLI\Utils\get_flag_value($assoc_args, 'output-file', '');

		// Set default output file if not provided
		if (empty($output_file)) {
			/*if($format == 'json'){
				$output_file = ABSPATH . 'plugin-check.json';
			}*/
			//else{
				$output_file = ABSPATH . 'plugin-check.log';
			//}
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

		//make the output php editor clickable compatible
		$output_content = $this->makePhpEditorCompatible($output_content);

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


	public function makePhpEditorCompatible($input) {
		// Split the input string into chunks based on the FILE keyword
		$chunks = preg_split('/(?=FILE: )/', $input, -1, PREG_SPLIT_NO_EMPTY);
		$output = '';

		foreach ($chunks as $chunk) {
			// Check if the chunk corresponds to a .php file
			if (preg_match('/FILE: (.+\.php)/', $chunk, $matches)) {
				// Split the chunk into lines
				$lines = explode("\n", trim($chunk));
				$shouldModify = false;

				// Check if any line starts with a non-zero number
				for ($i = 1; $i < count($lines); $i++) {
					$lineParts = preg_split('/\s+/', $lines[$i]);
					if (isset($lineParts[0]) && is_numeric($lineParts[0]) && $lineParts[0] != '0') {
						$shouldModify = true;
						break;
					}
				}

				// Modify the chunk if necessary
				if ($shouldModify) {
					$output .= $lines[0] . "\n";
					$output .= "File                                                                                                               line\tcolumn\ttype\tcode\tmessage\tdocs\n";
					for ($i = 1; $i < count($lines); $i++) {
						$lineParts = preg_split('/\s+/', $lines[$i], 2);
						if (isset($lineParts[0]) && is_numeric($lineParts[0]) && $lineParts[0] != '0') {
							$output .= $lines[0] . " on line " . $lineParts[0] . "\t" . $lineParts[1] . "\n";
						}
					}
					$output .= "\n"; // Add an extra newline after each modified chunk
				} else {
					// If no modification needed, add the original chunk
					$output .= $chunk . "\n\n"; // Add an extra newline after each unmodified chunk
				}
			} else {
				// If the chunk does not correspond to a .php file, add the original chunk
				$output .= $chunk . "\n\n"; // Add an extra newline after each unmodified chunk
			}
		}

		return trim($output);
	}//end method makePhpEditorCompatible
} //end class EasyPluginChecker
