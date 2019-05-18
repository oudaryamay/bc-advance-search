<?php
/**
 * Bigcommerce Live Search Ajax
 *
 * @since 1.1.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	die( 'Access denied.' );
}

// add the ajax fetch js
add_action( 'wp_footer', 'bas_ajax_fetch' );
function bas_ajax_fetch() {
?>
<script type="text/javascript">
//function basFetch(){
jQuery("#keyword").on('keyup change focus mouseover', function() {
	jQuery("#searchLoader").show();
    jQuery.ajax({
        url: '<?php echo admin_url('admin-ajax.php'); ?>',
        type: 'post',
        data: { action: 'bas_data_fetch', keyword: jQuery('#keyword').val(), security: jQuery('#basSecurity').val() },
        success: function(data) {
			jQuery("#searchLoader").hide();
			if( jQuery('#keyword').val() == "" ) {
				jQuery("#basDatafetch").css("display", "none");
			} else {
				jQuery("#basDatafetch").css("display", "block");
			}
			jQuery('#basDatafetch').html( data );
		}
    });

//}
});
</script>

<?php
}

	// the ajax function
	add_action('wp_ajax_bas_data_fetch' , 'bas_data_fetch');
	add_action('wp_ajax_nopriv_bas_data_fetch','bas_data_fetch');
	function bas_data_fetch(){
		if( strlen(esc_attr( $_POST['keyword'] )) > 2 ) :
	//check nonce
	check_ajax_referer( 'bas-security-string', 'security' );
	
	if($_POST['keyword'] != null && strlen(esc_attr( $_POST['keyword'] )) > 2 ):
	global $wpdb;
	
    $the_query = new WP_Query( array( 'posts_per_page' => -1, 's' => esc_attr( sanitize_text_field( trim ($_POST['keyword'] ) ) ), 'post_type' => 'bigcommerce_product' ) );
    if( $the_query->have_posts() ) :
		echo '<ul class="product-dropdown product-row list-unstyled">';
        while( $the_query->have_posts() ): $the_query->the_post(); 
		$id = get_the_ID(); 
		$thumbnail_url = wp_get_attachment_image_src(get_post_thumbnail_id($id), array('220','220'), false );
		$bigcommerce_calculated_price = get_post_meta($id, 'bigcommerce_calculated_price', true);
		$bigcommerce_product_id = get_post_meta($id, 'bigcommerce_id', true);
		$bigcommerce_currency_symbol = get_option('bigcommerce_currency_symbol');
		
		$results = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}bc_products WHERE bc_id = $bigcommerce_product_id", OBJECT );
		
		//$demo_img_url = plugins_url().'/bc-advance-search/assets/img/bc-product-default-img.jpg';
		$demo_img_url =  plugin_dir_url( dirname( __FILE__ ) ).'assets/img/bc-product-default-img.jpg';
		?>	
		
		<li class="list-group-item">
			<a href="<?php echo esc_url( post_permalink() ); ?>">
			<div class="media">
			<div class="media-left">
			<?php if( $thumbnail_url[0] == '' ): ?>
			<img src="<?php echo $demo_img_url; ?>" height="120" width="120">
			<?php else : ?>
			<img src="<?php echo $thumbnail_url[0]; ?>" height="120" width="120">
			<?php endif; ?>
			</div>
			<div class="media-body">
            <h3 class="product-row__item__title"><?php the_title(); ?></h3>
			<?php 
			/*print_r($results);*/ 
			foreach ($results as $result) :
			$price = $result->price; 
			endforeach;
			?>
			<?php if( $price == $bigcommerce_calculated_price ) : ?>
			<h4 class="product-price"><?php echo $bigcommerce_currency_symbol; ?><?php echo $bigcommerce_calculated_price; ?></h4>
			<?php else : ?>
			<h4 class="product-price"><?php echo $bigcommerce_currency_symbol; ?><?php echo $bigcommerce_calculated_price; ?></h4>
			<h4 class="product-price discount product-price--discount"><span><?php echo $bigcommerce_currency_symbol; ?><?php echo $price; ?></span></h4>
			<?php endif; ?>
			</div>
			</div>
			</a>
		</li>
		
					<?php endwhile;
					echo '</ul>';
				wp_reset_postdata();  
			endif;
		endif;
	wp_die();
 endif; 
}