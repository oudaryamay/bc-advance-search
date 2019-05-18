<?php
/**
 * Plugin Name: BigCommerce Advance Search
 * Description: Most powerful, professional and advance search engine for ::: BigCommerce For WordPress ::: store.
 * Version:  1.1
 * Author: Oudaryamay Burai
 * Author URI: https://oudarya.wordpress.com/
 * License: GPLv2 or later
 */
define( 'BAS_NAME', 'Bigcommerce Advance Search' );

//include necessary files
include_once( plugin_dir_path( __FILE__ ) .'inc/debug.php');
include_once( plugin_dir_path( __FILE__ ) .'inc/settings.php');
include_once( plugin_dir_path( __FILE__ ) .'inc/shortcode.php');
include_once( plugin_dir_path( __FILE__ ) .'inc/ajax.php');
include_once( plugin_dir_path( __FILE__ ) .'inc/ajax-autocomplete.php');
include_once( plugin_dir_path( __FILE__ ) .'inc/widget.php');

//Register the styling
function bas_enqueue_scripts() {
    wp_register_style( 'bas-get-public-style', plugins_url( 'assets/css/public-style.css', __FILE__ ), array(), '1.0.0', 'all' );
	}
add_action( 'wp_enqueue_scripts', 'bas_enqueue_scripts' );

//adding css to admin end
function bas_admin_wp_enqueue_scripts() {
    wp_enqueue_style('jquery-ui-css', plugins_url('assets/css/admin-style.css',__FILE__));
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