<?php
/**
 * Enqueue scripts and styles.
 *
 * @since 1.0.0
 */
function bas_autocomplete_enqueues() {
	wp_register_style(
		'bas-jquery-auto-complete-css',
		plugin_dir_url( dirname( __FILE__ ) ) . 'assets/css/auto-complete.css',
		array(),
		'1.0.7'
	);
	wp_register_script(
		'bas-jquery-auto-complete-js',
		plugin_dir_url( dirname( __FILE__ ) ) . 'assets/js/auto-complete.min.js',
		array( 'jquery' ),
		'1.0.7',
		true
	);
	wp_register_script(
		'bas-autocomplete',
		plugin_dir_url( dirname( __FILE__ ) ) . 'assets/js/autocomplete.js',
		array( 'jquery' ),
		'1.0.0',
		true
	);
	wp_localize_script(
		'bas-autocomplete',
		'autocomplete',
		array(
			'ajax' => admin_url( 'admin-ajax.php' ),
		)
	);
}
add_action( 'wp_enqueue_scripts', 'bas_autocomplete_enqueues' );
/**
 * Live autocomplete search feature.
 *
 * @since 1.0.0
 */
function bas_autocomplete_ajax_search() {
	$results = new WP_Query( array(
		'post_type'     => array( 'bigcommerce_product' ),
		'post_status'   => 'publish',
		'nopaging'      => true,
		'posts_per_page'=> 100,
		's'             => stripslashes( sanitize_text_field($_POST['search']) ),
	) );
	$items = array();
	if ( !empty( $results->posts ) ) {
		foreach ( $results->posts as $result ) {
			$items[] = $result->post_title;
			
		}
	}
	wp_send_json_success( $items );
}
add_action( 'wp_ajax_bas_search_product',        'bas_autocomplete_ajax_search' );
add_action( 'wp_ajax_nopriv_bas_search_product', 'bas_autocomplete_ajax_search' );