<?php
/**
 *
 * @link              https://codeboxr.com
 * @since             1.0.0
 * @package           CBXcareertoolkit
 *
 * @wordpress-plugin
 * Plugin Name:       CBX Career(Comfort HRM) Toolkit
 * Plugin URI:        https://github.com/codeboxrcodehub/cbxcareertoolkit/
 * Description:       Helper plugin for CBX Career(comfort hrm) plugins
 * Version:           1.0.2
 * Requires at least: 5.3
 * Requires PHP:      8.2
 * Author:            Codeboxr
 * Author URI:        https://codeboxr.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       cbxcareertoolkit
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

defined( 'CBXCAREERTOOLKIT_PLUGIN_NAME' ) or define( 'CBXCAREERTOOLKIT_PLUGIN_NAME', 'cbxcareertoolkit' );
defined( 'CBXCAREERTOOLKIT_PLUGIN_VERSION' ) or define( 'CBXCAREERTOOLKIT_PLUGIN_VERSION', '1.0.2' );
defined( 'CBXCAREERTOOLKIT_BASE_NAME' ) or define( 'CBXCAREERTOOLKIT_BASE_NAME', plugin_basename( __FILE__ ) );
defined( 'CBXCAREERTOOLKIT_ROOT_PATH' ) or define( 'CBXCAREERTOOLKIT_ROOT_PATH', plugin_dir_path( __FILE__ ) );
defined( 'CBXCAREERTOOLKIT_ROOT_URL' ) or define( 'CBXCAREERTOOLKIT_ROOT_URL', plugin_dir_url( __FILE__ ) );

defined( 'CBX_DEBUG' ) or define( 'CBX_DEBUG', false );
defined( 'CBXCAREERTOOLKIT_DEV_MODE' ) or define( 'CBXCAREERTOOLKIT_DEV_MODE', CBX_DEBUG );

// Include the main ComfortJob class.
if ( ! class_exists( 'CBXCareertoolkit', false ) ) {
	include_once CBXCAREERTOOLKIT_ROOT_PATH . 'includes/CBXCareertoolkit.php';
}

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_cbxcareer_toolkit() {
	// phpcs:ignore WordPress.NamingConventions.ValidFunctionName
	return CBXCareertoolkit::instance();
}//end function run_cbxcareer_toolkit


add_action( 'plugin_loaded', 'run_cbxcareer_toolkit' );