<?php
/**
 * Fired during plugin deactivation
 *
 * @link       https://www.dotmailer.com/
 * @since      1.0.0
 *
 * @package    Dotmailer
 * @subpackage Dotmailer/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Dotmailer
 * @subpackage Dotmailer/includes
 * @author     dotmailer <integrations@dotmailer.com>
 */
class Dotmailer_Deactivator {
	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	private $plugin_name;

	/**
	 * dotmailer's callback URL.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $callback_url    dotmailer's callback URL.
	 */
	private $callback_url;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 *
	 * @param string $plugin_name The name of the plugin.
	 * @param string $callback_url dotmailer's callback URL.
	 */
	public function __construct( $plugin_name, $callback_url ) {

		$this->plugin_name = $plugin_name;
		$this->callback_url = $callback_url;

	}

	/**
	 * Executed upon plugin deactivation.
	 *
	 * Executed upon plugin deactivation and posts to dotmailer's
	 * tracking site to notify that the plugin has been deactivated.
	 *
	 * @since    1.0.0
	 */
	public function deactivate() {
		global $wpdb;
		$dotmailer_table_name = $wpdb->prefix . $this->plugin_name;

		// @codingStandardsIgnoreStart
		$plugin_id = $wpdb->get_var( "SELECT PluginID FROM $dotmailer_table_name" );
		// @codingStandardsIgnoreEnd
		wp_remote_post( "$this->callback_url/e/woocommerce/disable?pluginid=$plugin_id" );
	}
}
