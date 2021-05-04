<?php
/**
 * Fired when the plugin is uninstalled.
 *
 * @link       https://www.spod.com
 * @since      1.0.0
 *
 * @package    spod_plugin
 */

// If uninstall not called from WordPress, then exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}