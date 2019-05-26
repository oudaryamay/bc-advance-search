<?php
/**
 * Bigcommerce Advance search front settings page
 *
 * @since 1.2.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	die( 'Access denied.' );
}
$generalSettings = get_option( 'bas_design_search_box_general' );

if($generalSettings) :
	$generalSettingsStatus = array_key_exists('bas_show_search_auto', $generalSettings) ? $generalSettings['bas_show_search_auto'] : '';
	$generalSettingsPosition = array_key_exists('bas_search_appear_position', $generalSettings) ? $generalSettings['bas_search_appear_position'] : '';


if( $generalSettingsStatus == 'show_bas_search' ) :
	
	if ( $generalSettingsPosition == 'Appear In Header' ) {

		add_action('wp_head', 'bas_search_appear_in_header');
		function bas_search_appear_in_header(){
			echo do_shortcode ("[bc-advance-search]");
		};
	
	} elseif ( $generalSettingsPosition == 'Appear In Footer' ) {
		
		add_action('wp_footer', 'bas_search_appear_in_footer');
		function bas_search_appear_in_footer(){
			echo do_shortcode ("[bc-advance-search]");
		};
		
	} else {
		
		add_action('wp_head', 'bas_search_appear_in_header');
		function bas_search_appear_in_header(){
			echo do_shortcode ("[bc-advance-search]");
		};
		
	}

endif; endif;