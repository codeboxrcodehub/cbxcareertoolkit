<?php

namespace Cbx\Careertoolkit;

/**
 * Class Helper
 * @package Cbx\Careertoolkit
 * @since 1.0.0
 */
class Helper {
	
	/**
	 * Load textdomain
	 *
	 * @since 1.0.0
	 */
	public function load_plugin_textdomain() {
		load_plugin_textdomain( 'cbxcareertoolkit', false, CBXCAREER_TOOLKIT_ROOT_PATH . 'languages/' );
	}//end method load_plugin_textdomain

	/**
	 * Custom update checker implemented
	 *
	 * @param $transient
	 *
	 * @return mixed
	 */
	public function pre_set_site_transient_update_plugins( $transient ) {
		// Ensure the transient is set
		if ( empty( $transient->checked ) ) {
			return $transient;
		}

		$plugin_slug = 'cbxcareertoolkit';
		$plugin_file = 'cbxcareertoolkit/cbxcareertoolkit.php';

		if ( isset( $transient->response[ $plugin_file ] ) ) {
			return $transient;
		}

		if ( ! function_exists( 'get_plugins' ) ) {
			require_once ABSPATH . 'wp-admin/includes/plugin.php';
		}

		$url = 'https://comforthrm.com/product_updates.json'; // Replace with your remote JSON file URL
		
		// Fetch the remote JSON file
		$response = wp_remote_get( $url );

		if ( is_wp_error( $response ) || wp_remote_retrieve_response_code( $response ) != 200 ) {
			return $transient;
		}

		$data = json_decode( wp_remote_retrieve_body( $response ), true );// Set true for associative array, false for object


		if ( ! isset( $data['cbxcareertoolkit'] ) ) {
			return $transient;
		}

		$remote_data = $data['cbxcareertoolkit'];

		$plugin_url  = isset( $remote_data['url'] ) ? $remote_data['url'] : '';
		$package_url = isset( $remote_data['api_url'] ) ? $remote_data['api_url'] : false;

		$remote_version = isset( $remote_data['new_version'] ) ? sanitize_text_field( $remote_data['new_version'] ) : '';

		if ( $remote_version != '' && version_compare( $remote_version, $transient->checked[ $plugin_file ], '>' ) ) {
			$transient->response[ $plugin_file ] = (object) [
				'slug'        => $plugin_slug,
				'new_version' => $remote_version,
				'url'         => $plugin_url,
				'package'     => $package_url, // Link to the new version
			];
		}

		return $transient;
	}//end method pre_set_site_transient_update_plugins

	public function plugin_info( $res, $action, $args ) {
		// Plugin slug
		$plugin_slug = 'cbxcareertoolkit';                                      // Replace with your plugin slug

		// Ensure we're checking the correct plugin
		if ( $action !== 'plugin_information' || $args->slug !== $plugin_slug ) {
			return $res;
		}

		// Fetch detailed plugin information
		$response = wp_remote_get( 'https://comforthrm.com/product_updates.json' ); // Replace with your API URL

		if ( is_wp_error( $response ) || wp_remote_retrieve_response_code( $response ) != 200 ) {
			return $res;
		}

		$data = json_decode( wp_remote_retrieve_body( $response ), true );
		if ( ! isset( $data[ $plugin_slug ] ) ) {
			return $res;
		}

		$remote_data = $data[ $plugin_slug ];		
		$package_url = isset( $remote_data['api_url'] ) ? $remote_data['api_url'] : false;

		// Build the plugin info response
		return (object) [
			'name'          => isset( $remote_data['name'] ) ? sanitize_text_field( $remote_data['name'] ) : 'CBX Careertoolkit',
			'slug'          => $plugin_slug,
			'version'       => isset( $remote_data['new_version'] ) ? sanitize_text_field( $remote_data['new_version'] ) : '',
			'author'        => isset( $remote_data['author'] ) ? sanitize_text_field( $remote_data['author'] ) : '',
			'homepage'      => isset( $remote_data['url'] ) ? $remote_data['url'] : '',
			'requires'      => isset( $remote_data['requires'] ) ? sanitize_text_field( $remote_data['requires'] ) : '',
			'tested'        => isset( $remote_data['tested'] ) ? sanitize_text_field( $remote_data['tested'] ) : '',
			'download_link' => $package_url,
			'sections'      => [
				'description' => isset( $remote_data['description'] ) ? wp_kses_post( $remote_data['description'] ) : '',
				'changelog'   => isset( $remote_data['changelog'] ) ? wp_kses_post( $remote_data['changelog'] ) : '',
			],
		];

	}//end method plugin_info
}//end class Helper