<?php
/**
 * Plugin Name: BigCommerce Advance Search
 * Description: Most powerful, professional and advance search engine for ::: BigCommerce For WordPress ::: store.
 * Version:  1.2
 * Author: Oudaryamay Burai
 * Author URI: https://oudarya.wordpress.com/
 * License: GPLv2 or later
 */
 
 /**
 * BigCommerce Advance Search
 *
 * @since 1.0
 * @modified 1.2
 */
define( 'BAS_NAME', 'Bigcommerce Advance Search' );

//include necessary files
include_once( plugin_dir_path( __FILE__ ) .'inc/debug.php');
include_once( plugin_dir_path( __FILE__ ) .'inc/settings.php');
include_once( plugin_dir_path( __FILE__ ) .'inc/shortcode.php');
include_once( plugin_dir_path( __FILE__ ) .'inc/ajax.php');
include_once( plugin_dir_path( __FILE__ ) .'inc/ajax-autocomplete.php');
include_once( plugin_dir_path( __FILE__ ) .'inc/widget.php');
include_once( plugin_dir_path( __FILE__ ) .'inc/design-settings.php');
include_once( plugin_dir_path( __FILE__ ) .'inc/design-settings-public.php');
include_once( plugin_dir_path( __FILE__ ) .'inc/promote/promote.php');

//Register the styling
function bas_enqueue_scripts() {
    wp_register_style( 'bas-get-public-style', plugins_url( 'assets/css/public-style.css', __FILE__ ), array(), '1.0.0', 'all' );
	}
add_action( 'wp_enqueue_scripts', 'bas_enqueue_scripts' );

//adding css/js to admin end
function bas_admin_wp_enqueue_scripts() {
    wp_enqueue_style('jquery-ui-css', plugins_url('assets/css/admin-style.css',__FILE__));
	
    wp_register_style('admin-design-dynamic-style', plugins_url('assets/css/admin-design-dynamic-style.css',__FILE__));
    wp_register_script('admin-design-dynamic-script', plugins_url('assets/js/admin-design-dynamic-script.js',__FILE__));
}
add_action( 'admin_enqueue_scripts', 'bas_admin_wp_enqueue_scripts' );

//adding setting link
function bas_add_settings_link( $links ) {
    $settings_link = '<a href="admin.php?page=bigcommerce-advance-search">' . __( 'Go to settings' ) . '</a>';
    array_push( $links, $settings_link );
    return $links;
}
$plugin = plugin_basename( __FILE__ );
add_filter( "plugin_action_links_$plugin", 'bas_add_settings_link' );