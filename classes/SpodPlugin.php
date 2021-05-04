<?php
/**
 * The core plugin class.
 *
 *
 * @since      1.0.0
 * @package    spod_woocommerce_plugin
 * @subpackage spod_woocommerce_plugin/classes
 */
class SpodPlugin {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @var      SpodPluginLoader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'SPOD_PLUGIN_VERSION' ) ) {
			$this->version = SPOD_PLUGIN_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'spod_woocommerce_plugin';

		$this->loadDependencies();
		$this->setLocale();
		$this->defineAdminHooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * @since    1.0.0
	 */
	private function loadDependencies() {

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'classes/SpodPluginLoader.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'classes/SpodPluginI18n.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'classes/SpodPluginAdmin.php';

		$this->loader = new SpodPluginLoader();
	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * @since    1.0.0
	 */
	private function setLocale() {

		$plugin_i18n = new SpodPluginI18n();
		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 */
	private function defineAdminHooks() {

		$plugin_admin = new SpodPluginAdmin( $this->getPluginName(), $this->getVersion() );
        if (isset($_GET['page']) && ($_GET['page'] == 'spod_woocommerce_plugin')) {
            $this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueueStyles' );
            $this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueueScripts' );
            $this->loader->add_filter('upload_mimes', $plugin_admin, 'addMimeType');
        }
        $this->loader->add_action('wp_ajax_serversidefunction', $plugin_admin, 'serversideAjax' );
        $this->loader->add_action('admin_menu', $plugin_admin, 'addPages', 10,5);
        $this->loader->add_action('woocommerce_order_status_processing', $plugin_admin,  'hookOrderStatusProcessing', 10, 1 );
        $this->loader->add_action('woocommerce_order_status_cancelled', $plugin_admin,  'hookOrderStatusCancelled', 10, 1 );
        $this->loader->add_action('init', $plugin_admin,  'registerShippedOrderState', 10, 1 );
        $this->loader->add_action('admin_notices', $plugin_admin,  'showAdminNotices', 10, 1 );
        $this->loader->add_filter('wc_order_statuses', $plugin_admin,'addShippedOrderState' );
        #$this->loader->add_filter('woocommerce_hide_invisible_variations', $plugin_admin, '__return_false' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function getPluginName() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    SpodPluginLoader   Orchestrates the hooks of the plugin.
	 */
	public function getLoader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function getVersion() {
		return $this->version;
	}

}