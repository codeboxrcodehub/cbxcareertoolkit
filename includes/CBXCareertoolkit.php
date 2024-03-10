<?php

namespace Cbx\Careertoolkit;

class CBXCareertoolkit
{

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

	public function __construct()
	{
		$this->plugin_name = CBXCAREER_TOOLKIT_PLUGIN_NAME;
		$this->version = CBXCAREER_TOOLKIT_PLUGIN_VERSION;
		$this->hooks = new Hooks();
	}

	/**
	 * Main cbx devtool Instance.
	 *
	 * Ensures only one instance of cbx devtool is loaded or can be loaded.
	 *
	 * @return self Main instance.
	 * @since  1.0.0
	 * @static
	 */
	public static function instance()
	{
		if (is_null(self::$instance)) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	public static function activate()
	{
	}//end method activate

	public static function deactivate()
	{
	}//end method activate

}