<?php
require_once plugin_dir_path( dirname( __FILE__ ) ) . 'classes/ApiAuthentication.php';
/**
 * Fired during plugin deactivation.
 *
 * @since      1.0.0
 * @package    spod_woocommerce_plugin
 * @subpackage spod_woocommerce_plugin/includes
 */
class SpodPluginDeactivator {

	/**
	 *
	 * @since    1.0.0
	 */
	public static function deactivate()
    {
        // plugin disconnection and product deleting only with woocommerce possible
        if ( function_exists( 'WC' ) ) {
            $Api = new ApiAuthentication();
            $Api->disconnectPlugin();
	    }
	}

}
