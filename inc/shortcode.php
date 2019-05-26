<?php
/**
 * Bigcommerce shortcode
 *
 * @since 1.0
 * @modified 1.1
 * @modified 1.2
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

$searchBoxSettings = get_option( 'bas_design_search_box' );
$searchBoxSizeSettings = $searchBoxSettings['bas_search_box_size'];
$searchBoxPositionSettings = $searchBoxSettings['bas_search_box_position'];

$searchBtnSettings = get_option( 'bas_design_search_button' );
$searchBtnColorSettings = $searchBtnSettings['bas_search_btn_colour'];
$searchBtnPositionSettings = $searchBtnSettings['bas_search_btn_position'];

$searchOtherSettings = get_option( 'bas_design_search_others' );
$searchOtherLoaderSettings = $searchOtherSettings['bas_show_loader'];


	if ( $searchBoxSizeSettings != null ) :
		$hClass = 'basDynamicWidth';
	endif;

	if ( $searchBoxPositionSettings != null ) : 
	
		switch ($searchBoxPositionSettings) {
			case "Right":
				$pClass = 'basPositionRight';
				break;
			case "Center":
				$pClass = 'basPositionCenter';
				break;
			default:
				$pClass = 'basPositionDefault';
		}
	endif;
	
	if( $searchBtnPositionSettings == 'Left' ) :
		$leftPositionBtnCss = 'left: 0;';
		$leftPositionInputCss = 'padding: 15px 40px;';
	endif;

echo '<style>';
	if ( $searchBoxSizeSettings != null ) : ?>
		.basDynamicWidth {
			width: <?php echo $searchBoxSizeSettings; ?>%;
		}
	<?php
	endif;
	
echo '</style>';

wp_enqueue_style('dashicons');
wp_enqueue_style('bas-get-public-style' );
wp_enqueue_style('bas-jquery-auto-complete-css');
wp_enqueue_script('bas-jquery-auto-complete-js');
wp_enqueue_script('bas-autocomplete');
echo '<div class="bas-search-form '.esc_attr($hClass).' '.esc_attr($pClass).' '.esc_attr($bigcommerce_advance_search_options['bc_form_text_class']).'">';

//Setting up my nonce
$ajax_nonce_bas = wp_create_nonce( "bas-security-string" );
echo '<input id="basSecurity" type="hidden" value="'.$ajax_nonce_bas.'">';

if( $bigcommerce_advance_search_options['bc_form_type'] == 'Details Search Results on Keyword Press') : ?>


	<form action="<?php echo site_url(); ?>/products/" class="clearfix search-form <?php echo esc_attr($bigcommerce_advance_search_options['bc_form_text_class']); ?>" method="get" role="search">
	
	<input class="form-control form-inline search-input jsQuickSearch" style="<?php echo $leftPositionInputCss; ?>" type="text" name="s" id="keyword" autocomplete="off" placeholder="<?php echo $placeholder_txt; ?>">
	<button type="submit" class="button-search" style="color: <?php echo $searchBtnColorSettings; ?>;<?php echo $leftPositionBtnCss; ?>"><span class="dashicons dashicons-search"></span></button>
	
	<?php if ($searchOtherLoaderSettings == '' || $searchOtherLoaderSettings == 'Yes' ) : ?>
	  <div class="spinner" id="searchLoader" style="display: none;">
		  <div class="bounce1"></div>
		  <div class="bounce2"></div>
		  <div class="bounce3"></div>
	  </div>
	<?php endif; ?>

	<div class="jsQuickSearchResult product-dropdown-container" id="basDatafetch" style="display:none"><ul class="product-list"></ul></div>
	</form>


<?php 
elseif($bigcommerce_advance_search_options['bc_form_type'] == 'Only Autocomplete the Results matches Keyword') : 
?>


	<form class="clearfix search-form <?php echo esc_attr($bigcommerce_advance_search_options['bc_form_text_class']); ?>" method="get" action="<?php echo site_url(); ?>/products/"  role="search">
	
			<input type="text" name="s" class="form-control form-inline search-input bas-search-autocomplete" style="<?php echo $leftPositionInputCss; ?> placeholder="<?php echo $placeholder_txt; ?>">
			<button type="submit" class="button-search" style="color: <?php echo $searchBtnColorSettings; ?>;<?php echo $leftPositionBtnCss; ?>"><span class="dashicons dashicons-search"></span></button>
		
	</form>


<?php else : ?>

	<form action="<?php echo site_url(); ?>/products/" class="clearfix search-form <?php echo esc_attr($bigcommerce_advance_search_options['bc_form_text_class']); ?>" method="get" role="search">
		<input class="form-control form-inline search-input jsQuickSearch" style="<?php echo $leftPositionInputCss; ?>" type="text" name="s" id="keyword" autocomplete="off" placeholder="<?php echo $placeholder_txt; ?>">
		<button type="submit" class="button-search" style="color: <?php echo $searchBtnColorSettings; ?>;<?php echo $leftPositionBtnCss; ?>"><span class="dashicons dashicons-search"></span></button>
		
		<?php if ($searchOtherLoaderSettings == '' || $searchOtherLoaderSettings == 'Yes' ) : ?>
		  <div class="spinner" id="searchLoader" style="display: none;">
			  <div class="bounce1"></div>
			  <div class="bounce2"></div>
			  <div class="bounce3"></div>
		  </div>
		<?php endif; ?>

		<div class="jsQuickSearchResult product-dropdown-container" id="basDatafetch" style="display:none"><ul class="product-list"></ul></div>
	</form>

<?php
endif;
echo '</div>';
}