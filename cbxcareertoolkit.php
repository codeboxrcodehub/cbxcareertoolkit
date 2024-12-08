<?php

/**
 *
 * @link              https://codeboxr.com
 * @since             1.0.0
 * @package           CBXcareertoolkit
 *
 * @wordpress-plugin
 * Plugin Name:       CBX Career Toolkit
 * Plugin URI:        https://github.com/codeboxrcodehub/cbxcareertoolkit/
 * Description:       Helper plugin for CBX Career plugins
 * Version:           1.0.0
 * Requires at least: 3.7
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

defined( 'CBXCAREER_TOOLKIT_PLUGIN_NAME' ) or define( 'CBXCAREER_TOOLKIT_PLUGIN_NAME', 'cbxcareertoolkit' );
defined( 'CBXCAREER_TOOLKIT_PLUGIN_VERSION' ) or define( 'CBXCAREER_TOOLKIT_PLUGIN_VERSION', '1.0.0' );
defined( 'CBXCAREER_TOOLKIT_BASE_NAME' ) or define( 'CBXCAREER_TOOLKIT_BASE_NAME', plugin_basename( __FILE__ ) );
defined( 'CBXCAREER_TOOLKIT_ROOT_PATH' ) or define( 'CBXCAREER_TOOLKIT_ROOT_PATH', plugin_dir_path( __FILE__ ) );
defined( 'CBXCAREER_TOOLKIT_ROOT_URL' ) or define( 'CBXCAREER_TOOLKIT_ROOT_URL', plugin_dir_url( __FILE__ ) );

defined( 'CBX_DEBUG' ) or define( 'CBX_DEBUG', false );
defined( 'CBXCAREER_TOOLKIT_DEV_MODE' ) or define( 'CBXCAREER_TOOLKIT_DEV_MODE', CBX_DEBUG );


require_once CBXCAREER_TOOLKIT_ROOT_PATH . "lib/autoload.php";


/**
 * The code that runs during plugin activation.
 */
function activate_cbx_career_toolkit() {
	\Cbx\Careertoolkit\CBXCareertoolkit::activate();
}//end function activate_cbx_career_toolkit

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
	return \Cbx\Careertoolkit\CBXCareertoolkit::instance();
}//end function run_cbxcareer_toolkit


add_action( "plugin_loaded", "run_cbxcareer_toolkit" );