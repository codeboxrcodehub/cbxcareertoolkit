<?php

//namespace Cbx\Careertoolkit;

use Cbx\Careertoolkit\Hooks;

final class CBXCareertoolkit {

	/**
	 * The single instance of the class.
	 *
	 * @var self
	 * @since  1.0.0
	 */
	private static $instance = null;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string $plugin_name The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string $version The current version of the plugin.
	 */
	protected $version;

	/**
	 * @var Hooks
	 * @since    1.0.0
	 * @access   protected
	 */
	protected $hooks;

	public function __construct() {
		$this->plugin_name = CBXCAREERTOOLKIT_PLUGIN_NAME;
		$this->version     = CBXCAREERTOOLKIT_PLUGIN_VERSION;

		$this->include_files();

		$this->hooks       = new Hooks();
	}//end constructor

	/**
	 * Main cbx devtool Instance.
	 *
	 * Ensures only one instance of cbx devtool is loaded or can be loaded.
	 *
	 * @return self Main instance.
	 * @since  1.0.0
	 * @static
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}//end method instance

	private function include_files() {
		require_once CBXCAREERTOOLKIT_ROOT_PATH . "lib/autoload.php";
	}//end method include_files

}//end method CBXCareertoolkit