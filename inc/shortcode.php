<?php
/**
 * Bigcommerce shortcode
 *
 * @since 1.1.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	die( 'Access denied.' );
}

// Shortcode for form
add_shortcode( 'bc-advance-search', 'bas_search_form' );
function bas_search_form( $atts ) {
$bigcommerce_advance_search_options = get_option( 'bigcommerce_advance_search_option_name' );
$placeholder_txt = ($bigcommerce_advance_search_options['bc_form_text_placeholder'] != '') ? esc_attr($bigcommerce_advance_search_options['bc_form_text_placeholder']) : 'What are you looking for?';
//getting custom CSS inline
if($bigcommerce_advance_search_options['bc_form_custom_css'] != null) :
	echo '<style>'.$bigcommerce_advance_search_options['bc_form_custom_css'].'</style>';
endif;
wp_enqueue_style('dashicons');
wp_enqueue_style('bas-get-public-style' );
wp_enqueue_style('bas-jquery-auto-complete-css');
wp_enqueue_script('bas-jquery-auto-complete-js');
wp_enqueue_script('bas-autocomplete');
//Setting up my nonce
$ajax_nonce_bas = wp_create_nonce( "bas-security-string" );
echo '<input id="basSecurity" type="hidden" value="'.$ajax_nonce_bas.'">';
echo '<div class="bas-search-form '.esc_attr($bigcommerce_advance_search_options['bc_form_text_class']).'">';

if( $bigcommerce_advance_search_options['bc_form_type'] == 'Details Search Results on Keyword Press') : ?>


	<form action="<?php echo site_url(); ?>/products/" class="clearfix search-form <?php echo esc_attr($bigcommerce_advance_search_options['bc_form_text_class']); ?>" method="get" role="search">
	
	<input class="form-control form-inline search-input jsQuickSearch" type="text" name="s" id="keyword" autocomplete="off" placeholder="<?php echo $placeholder_txt; ?>">
	<button type="submit" class="button-search"><span class="dashicons dashicons-search"></span></button>
	  <div class="spinner" id="searchLoader" style="display: none;">
	  <div class="bounce1"></div>
	  <div class="bounce2"></div>
	  <div class="bounce3"></div>
	  
	</div>				
		

	<div class="jsQuickSearchResult product-dropdown-container" id="basDatafetch" style="display:none"><ul class="product-list"></ul></div>
	</form>


<?php 
elseif($bigcommerce_advance_search_options['bc_form_type'] == 'Only Autocomplete the Results matches Keyword') : 
?>


	<form class="clearfix search-form <?php echo esc_attr($bigcommerce_advance_search_options['bc_form_text_class']); ?>" method="get" action="<?php echo site_url(); ?>/products/"  role="search">
	
			<input type="text" name="s" class="form-control form-inline search-input bas-search-autocomplete" placeholder="<?php echo $placeholder_txt; ?>">
				<button type="submit" class="button-search"><span class="dashicons dashicons-search"></span></button>

		
	</form>


<?php else : ?>

	<form action="<?php echo site_url(); ?>/products/" class="clearfix search-form <?php echo esc_attr($bigcommerce_advance_search_options['bc_form_text_class']); ?>" method="get" role="search">
	
	<input class="form-control form-inline search-input jsQuickSearch" type="text" name="s" id="keyword" autocomplete="off" placeholder="<?php echo $placeholder_txt; ?>">
	<button type="submit" class="button-search"><span class="dashicons dashicons-search"></span></button>
	  <div class="spinner" id="searchLoader" style="display: none;">
	  <div class="bounce1"></div>
	  <div class="bounce2"></div>
	  <div class="bounce3"></div>
	  
	</div>				
		

	<div class="jsQuickSearchResult product-dropdown-container" id="basDatafetch" style="display:none"><ul class="product-list"></ul></div>
	</form>

<?php
endif;
echo '</div>';
}