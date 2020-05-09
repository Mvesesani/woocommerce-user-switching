<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://about.mvesesani.com
 * @since      1.0.0
 *
 * @package    Woocommerce_User_Switching
 * @subpackage Woocommerce_User_Switching/admin
 */

/**
 * @package    Woocommerce_User_Switching
 * @subpackage Woocommerce_User_Switching/admin
 * @author     Twaambo Haamucenje <twaambo@mvesesani.com>
 */

class Woocommerce_User_Switching_Admin
{

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $woocommerce_user_switching    The ID of this plugin.
     */
    private $woocommerce_user_switching;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string    $woocommerce_user_switching       The name of this plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct($woocommerce_user_switching, $version)
    {

        $this->woocommerce_user_switching = $woocommerce_user_switching;
        $this->version = $version;
    }

    /**
     * Adds 'Switch To User' column header to 'Orders' page immediately after 'Order' column.
     *
     * @param string[] $columns
     * @return string[] $new_columns
     */
    public function add_order_switch_to_user_column_header($columns)
    {
        $new_columns = array();

        foreach ($columns as $column_name => $column_info) {

            $new_columns[$column_name] = $column_info;

            if ('order_number' === $column_name) {
                $new_columns['order_switch_to_user'] = __('Log In As User', 'my-textdomain');
            }
        }

        return $new_columns;
    }

    /**
     * Adds 'Switch To User' column content to 'Orders' page immediately after 'Order' column.
     *
     * @param string[] $column name of column being displayed
     */
    public function add_order_switch_to_user_column_content($column)
    {
        global $post;

        if ('order_switch_to_user' === $column) {

            $order    = wc_get_order($post->ID);
            $customer = $order->get_user();
            $link = user_switching::maybe_switch_url($customer);

            echo sprintf(
                '<a href="%s">%s</a>',
                esc_url($link),
                esc_html__('Log&nbsp;in&nbsp;as&nbsp;' . $customer->display_name, 'user-switching')
            );
        }
    }

    /**
     * Adds a 'Switch To User' metabox to the Order detail page
     */
    public function add_switch_to_user_metabox()
    {
        add_meta_box('switch_to_user_metabox', __('Switch To User'), array($this, 'switch_to_user_metabox'), array('shop_order', 'shop_subscription'), 'side', 'low');
    }

    /**
     * Adds a link to the 'Switch To User' metabox
     */
    public function switch_to_user_metabox()
    {
        global $post;

        $order    = wc_get_order($post->ID);
        $customer = $order->get_user();
        $link = user_switching::maybe_switch_url($customer);

        echo sprintf(
            '<a href="%s">%s</a>',
            esc_url($link),
            esc_html__('Switch&nbsp;to&nbsp;' . $customer->display_name, 'user-switching')
        );
    }

    /**
     * Deactivates the plugin and throws and error message when User Switching plugin not active
     * @return void
     */
    public function enforce_user_switching_dependency()
    {
        if (!class_exists('user_switching')) {
            $result = deactivate_plugins($this->woocommerce_user_switching . '/' . $this->woocommerce_user_switching . '.php', $this->woocommerce_user_switching  . '.php');

            $html = '
                <div class="notice notice-error">
                    <p>The <strong>User Switching WooCommerce</strong> plugin has been automatically <strong>deactivated</strong>.
                    The "User Switching" plugin by John Blackbourn is required in order for it to work.
                    <br>Please install the "User Switching" plugin, then try activating this plugin again. <strong>
                    Please ignore the Plugin Activated message below</strong>.
                . </p>
                </div>
            ';

            echo $html;
        }
    }

    /**
     * Deactivates the plugin and throws and error message when WooCommerce plugin not active
     * @return void
     */
    public function enforce_woocommerce_dependency()
    {
        if (!class_exists('woocommerce')) {
            $result = deactivate_plugins($this->woocommerce_user_switching . '/' . $this->woocommerce_user_switching . '.php', $this->woocommerce_user_switching  . '.php');

            $html = '
                <div class="notice notice-error">
                    <p>The <strong>User Switching WooCommerce</strong> plugin has been automatically <strong>deactivated</strong>.
                    The "WooCommerce" plugin is required in order for it to work.
                    <br>Please install the "WooCommerce" plugin, then try activating this plugin again. <strong>
                    Please ignore the Plugin Activated message below</strong>.
                . </p>
                </div>
            ';

            echo $html;
        }
    }
}
