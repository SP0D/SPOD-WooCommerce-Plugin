<?php
/**
 * @link              https://www.spod.com
 * @since             1.0.0
 * @package           spod_plugin
 *
 * @wordpress-plugin
 * Plugin Name:       SPOD WooCommerce Plugin
 * Plugin URI:        https://www.spod.com/
 * Description:       Connect your WooCommerce Shop to the leading provider of whitelabel print-on-demand services. Get an automatic product, order and order status synchronisation and a seamless integration into your WooCommerce setup ready within minutes.
 * Version:           1.0.0
 * Author:            SPOD - Spreadshirt-Print-On-Demand GmbH
 * Author URI:        https://www.spod.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       spod_plugin
 * Domain Path:       /languages
 *
 * WC requires at least: 4.7
 * WC tested up to: 5.1.0
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 */
define( 'SPOD_PLUGIN_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 */
function activate_spod_plugin() {
	require_once plugin_dir_path( __FILE__ ) . 'classes/SpodPluginActivator.php';
    SpodPluginActivator::activate();
}

/**
 * The code that runs during plugin deactivation.
 */
function deactivate_spod_plugin() {
	require_once plugin_dir_path( __FILE__ ) . 'classes/SpodPluginDeactivator.php';
    SpodPluginDeactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_spod_plugin' );
register_deactivation_hook( __FILE__, 'deactivate_spod_plugin' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'classes/SpodPlugin.php';

/**
 * Begins execution of the plugin.
 *
 * @since    1.0.0
 */
function run_spod_plugin() {

	$plugin = new SpodPlugin();
	$plugin->run();

}
run_spod_plugin();