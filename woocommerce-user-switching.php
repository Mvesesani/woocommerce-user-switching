<?php

/**
 * @link              https://about.mvesesani.com
 * @since             1.0.0
 * @package           woocommerce-user-switching
 *
 * @wordpress-plugin
 * Plugin Name:       User Switching for WooCommerce
 * Plugin URI:        https://about.mvesesani.com
 * Description:       Extends the User Switching plugin by making the option available for WooCommerce Orders
 * Version:           1.0.0
 * Author:            Mvesesani
 * Author URI:        https://about.mvesesani.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       woocommerce-user-switching
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define('WOOCOMMERCE_USER_SWITCHING_VERSION', '1.0.0');

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-woocommerce-user-switching-activator.php
 */
function activate_woocommerce_user_switching()
{
    require_once plugin_dir_path(__FILE__) . 'includes/class-woocommerce-user-switching-activator.php';
    Woocommerce_User_Switching_Activator::activate();
}

register_activation_hook(__FILE__, 'activate_woocommerce_user_switching');
register_deactivation_hook(__FILE__, 'deactivate_woocommerce_user_switching');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__) . 'includes/class-woocommerce-user-switching.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_woocommerce_user_switching()
{

    $plugin = new Woocommerce_User_Switching();
    $plugin->run();
}
run_woocommerce_user_switching();
