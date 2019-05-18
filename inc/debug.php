<?php
/**
 * Bigcommerce debug page
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	die( 'Access denied.' );
}

//Check dependent plugin
function bas_check_bigcommerce_plugin_status() {
 if ( ! is_plugin_active ( 'bigcommerce/bigcommerce.php' ) ) {
       function bas_requirements_error() {
	   $notice_status = get_option( 'bigcommerce_advance_search_option_name' );

	   if( isset($notice_status['bas_plugin_show_notice']) != 'show_error_false' ) :
	   //print_r($notice_status);
	   echo '<div class="notice notice-warning is-dismissible" >';
	   echo '<p>It requires BigCommerce For WordPress Plugin activated to working properly. <a href="'.admin_url().'plugin-install.php?s=BigCommerce+For+WordPress&tab=search&type=term"><img style="height: 30px; padding: 0px 10px; margin: -10px;" src="'.plugins_url( '../assets/img/click-here.png', __FILE__ ).'"></a> to download the plugin.</p>';
	   echo '</div>';
	   endif;
	
	   }
	   add_action( 'admin_notices', 'bas_requirements_error' );
    }
	
}
add_action( 'admin_init', 'bas_check_bigcommerce_plugin_status' );

//Save error in DB
/* function bas_save_error() {
    update_option( 'bas_plugin_error',  ob_get_contents() );
}
add_action( 'activated_plugin', 'bas_save_error' ); */
/* Then to display the error message: */
//echo get_option( 'bas_plugin_error' );