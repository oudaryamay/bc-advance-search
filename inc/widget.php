<?php
/**
 * Bigcommerce widget page
 *
 * @since 1.0
 * @modified 1.1
 */
 
if ( ! defined( 'ABSPATH' ) ) {
	die( 'Access denied.' );
}

// Register and load the widget
function bas_load_widget() {
    register_widget( 'bas_widget' );
}
add_action( 'widgets_init', 'bas_load_widget' );
 
// Creating the widget 
class bas_widget extends WP_Widget {
 
function __construct() {
parent::__construct(
 
// Base ID of your widget
'bas_widget', 
 
// Widget name will appear in UI
__('BigCommerce Advance Search Widget', 'bas'), 
 
// Widget description
array( 'description' => __( 'Autocomplete bigcommerce advance search widget.', 'bas' ), ) 
);
}
 
// Creating widget front-end
 
public function widget( $args, $instance ) {
$title = apply_filters( 'widget_title', $instance['title'] );
 
// before and after widget arguments are defined by themes
echo $args['before_widget'];
if ( ! empty( $title ) )
echo $args['before_title'] . $title . $args['after_title'];
 
// This is where you run the code and display the output

$bigcommerce_advance_search_options = get_option( 'bigcommerce_advance_search_option_name' );
$placeholder_txt = ($bigcommerce_advance_search_options['bc_form_text_placeholder'] != '') ? esc_attr($bigcommerce_advance_search_options['bc_form_text_placeholder']) : 'Enter your keyword here...';
wp_enqueue_style('bas-get-public-style' );

//getting custom CSS
echo '<style>'.$bigcommerce_advance_search_options['bc_form_custom_css'].'</style>';
echo '<div class="bas-search-form '.esc_attr($bigcommerce_advance_search_options['bc_form_text_class']).'">';
?>

	<form class="clearfix search-form <?php echo esc_attr($bigcommerce_advance_search_options['bc_form_text_class']); ?>" method="get" action="<?php echo site_url(); ?>/products/"  role="search">
		<input type="text" name="s" class="form-control form-inline search-input bas-search-autocomplete" placeholder="<?php echo $placeholder_txt; ?>">
		<button type="submit" class="button-search"><span class="dashicons dashicons-search"></span></button>
	</form>

<?php
echo '</div>';
echo $args['after_widget'];
}
         
// Widget Backend 
public function form( $instance ) {
if ( isset( $instance[ 'title' ] ) ) {
$title = $instance[ 'title' ];
}
else {
$title = __( 'Search', 'wpb_widget_domain' );
}
// Widget admin form
?>
<p>
<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
</p>
<?php 
}
     
// Updating widget replacing old instances with new
public function update( $new_instance, $old_instance ) {
$instance = array();
$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
return $instance;
}
} // Class bas_widget ends here