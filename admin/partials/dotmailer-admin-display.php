<?php
/**
 * Fired during plugin activation
 *
 * @link       https://www.dotmailer.com/
 * @since      1.0.0
 *
 * @package    Dotmailer
 * @subpackage Dotmailer/includes
 */

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://www.dotmailer.com/
 * @since      1.0.0
 *
 * @package    Dotmailer
 * @subpackage Dotmailer/admin/partials
 */
class Dotmailer_Admin_Display {

	/**
	 * The name of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name   The name of this plugin.
	 */
	private $plugin_name;

	/**
	 * dotmailer's Web App URL.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $webapp_url    dotmailer's Web App URL.
	 */
	private $webapp_url;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 *
	 * @param string $plugin_name 	The name of this plugin.
	 * @param string $webapp_url 	dotmailer's Web App URL.
	 */
	public function __construct( $plugin_name, $webapp_url ) {

		$this->plugin_name = $plugin_name;
		$this->webapp_url = $webapp_url;

	}

	/**
	 * Render the settings page for this plugin.
	 *
	 * @since    1.0.0
	 */
	public function display_plugin_setup_page() {

		$store_name = get_bloginfo( 'name' );
		$store_url = get_bloginfo( 'wpurl' );
		$bridge_url = $store_url . '/bridge2cart/bridge.php';
		$store_root = '\\' === DIRECTORY_SEPARATOR ?
			str_replace( '/', '\\', ABSPATH ) :
			ABSPATH;

		global $wpdb;
		$table_name = $wpdb->prefix . $this->plugin_name;

		// @codingStandardsIgnoreStart
		$plugin_id = $wpdb->get_var( "SELECT PluginID FROM $table_name" );
		// @codingStandardsIgnoreEnd

		$connection_query = http_build_query( array(
			'storename' => $store_name,
			'storeurl' => $store_url,
			'bridgeurl' => $bridge_url,
			'storeroot' => $store_root,
			'pluginid' => $plugin_id,
		) );

		echo '<iframe id="dotmailer-settings" src="' . esc_html( $this->webapp_url ) . '/woocommerce/connect?' . esc_html( $connection_query ) . '"></iframe>';
	}
}
