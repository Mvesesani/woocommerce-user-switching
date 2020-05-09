<?php

/**
 * The file that defines the core plugin class
 *
 *
 * @link       https://about.mvesesani.com
 * @since      1.0.0
 *
 * @package    Woocommerce_User_Switching
 * @subpackage Woocommerce_User_Switching/includes
 */

/**
 * The core plugin class.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Woocommerce_User_Switching
 * @subpackage Woocommerce_User_Switching/includes
 * @author     Twaambo Haamucenje <twaambo@mvesesani.com>
 */
class Woocommerce_User_Switching
{

    /**
     * The loader that's responsible for maintaining and registering all hooks that power
     * the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      Woocommerce_User_Switching_Loader    $loader    Maintains and registers all hooks for the plugin.
     */
    protected $loader;

    /**
     * The unique identifier of this plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $woocommerce_user_switching    The string used to uniquely identify this plugin.
     */
    protected $woocommerce_user_switching;

    /**
     * The current version of the plugin.
     *
     * @since    1.0.0
     * @access   protected
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
    public function __construct()
    {
        if (defined('WOOCOMMERCE_USER_SWITCHING_VERSION')) {
            $this->version = WOOCOMMERCE_USER_SWITCHING_VERSION;
        } else {
            $this->version = '1.0.0';
        }
        $this->woocommerce_user_switching = 'woocommerce-user-switching';

        $this->load_dependencies();
        $this->define_admin_hooks();
    }

    /**
     * Load the required dependencies for this plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function load_dependencies()
    {

        /**
         * The class responsible for orchestrating the actions and filters of the
         * core plugin.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-woocommerce-user-switching-loader.php';

        /**
         * The class responsible for defining all actions that occur in the admin area.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-woocommerce-user-switching-admin.php';


        $this->loader = new Woocommerce_User_Switching_Loader();
    }

    /**
     * Register all of the hooks related to the admin area functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_admin_hooks()
    {

        $plugin_admin = new Woocommerce_User_Switching_Admin($this->get_woocommerce_user_switching(), $this->get_version());

        $this->loader->add_action('admin_init', $plugin_admin, 'enforce_woocommerce_dependency');
        $this->loader->add_action('admin_init', $plugin_admin, 'enforce_user_switching_dependency');

        $this->loader->add_filter('manage_edit-shop_order_columns', $plugin_admin, 'add_order_switch_to_user_column_header');
        $this->loader->add_action('manage_shop_order_posts_custom_column', $plugin_admin, 'add_order_switch_to_user_column_content');
        $this->loader->add_action('add_meta_boxes', $plugin_admin, 'add_switch_to_user_metabox');
    }

    /**
     * Run the loader to execute all of the hooks with WordPress.
     *
     * @since    1.0.0
     */
    public function run()
    {
        $this->loader->run();
    }

    /**
     * The name of the plugin used to uniquely identify it within the context of
     * WordPress and to define internationalization functionality.
     *
     * @since     1.0.0
     * @return    string    The name of the plugin.
     */
    public function get_woocommerce_user_switching()
    {
        return $this->woocommerce_user_switching;
    }

    /**
     * The reference to the class that orchestrates the hooks with the plugin.
     *
     * @since     1.0.0
     * @return    Woocommerce_User_Switching_Loader    Orchestrates the hooks of the plugin.
     */
    public function get_loader()
    {
        return $this->loader;
    }

    /**
     * Retrieve the version number of the plugin.
     *
     * @since     1.0.0
     * @return    string    The version number of the plugin.
     */
    public function get_version()
    {
        return $this->version;
    }
}
