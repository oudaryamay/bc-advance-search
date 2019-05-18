<?php
/**
 * Bigcommerce Advance search admin page
 *
 * @since 1.1.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	die( 'Access denied.' );
}

class BigcommerceAdvanceSearch {
	private $bigcommerce_advance_search_options;

	public function __construct() {
		add_action( 'admin_menu', array( $this, 'bigcommerce_advance_search_add_plugin_page' ) );
		add_action( 'admin_init', array( $this, 'bigcommerce_advance_search_page_init' ) );
		ob_start();
	}

	public function bigcommerce_advance_search_add_plugin_page() {
		add_menu_page(
			'Bigcommerce Advance Search', // page_title
			'BC Search', // menu_title
			'manage_options', // capability
			'bigcommerce-advance-search', // menu_slug
			array( $this, 'bigcommerce_advance_search_create_admin_page' ), // function
			plugin_dir_url( dirname( __FILE__ ) ).'assets/img/bas-admin-icon.ico', // icon_url
			40 // position
		);
	}

	public function bigcommerce_advance_search_create_admin_page() {
		$this->bigcommerce_advance_search_options = get_option( 'bigcommerce_advance_search_option_name' ); ?>

		<div class="wrap basConatiner">
			<h2 class="bas-main-heading">::: Bigcommerce Advance Search :::</h2>
			<p class="bas-main-subheading">It provides you extra search facilities. Use <input style="background-color:white; border:1px white solid; color:green; font-weight: bold; width: 148px;" onclick="this.select();" value="[bc-advance-search]" readonly> shortcode to your post/page or you can use <a href="<?php admin_url(); ?>widgets.php">widget.</a></p>

			<?php settings_errors(); ?>

			<form class="bas-table" method="post" action="options.php">
				<?php
					settings_fields( 'bigcommerce_advance_search_option_group' );
					do_settings_sections( 'bigcommerce-advance-search-admin' );
					submit_button();
				?>
			</form>
		</div>
	<?php }

	public function bigcommerce_advance_search_page_init() {
		register_setting(
			'bigcommerce_advance_search_option_group', // option_group
			'bigcommerce_advance_search_option_name', // option_name
			array( $this, 'bigcommerce_advance_search_sanitize' ) // sanitize_callback
		);

		add_settings_section(
			'bigcommerce_advance_search_setting_section', // id
			'Settings', // title
			array( $this, 'bigcommerce_advance_search_section_info' ), // callback
			'bigcommerce-advance-search-admin' // page
		);

		add_settings_field(
			'bc_form_type', // id
			'Search Type', // title
			array( $this, 'bc_form_type_callback' ), // callback
			'bigcommerce-advance-search-admin', // page
			'bigcommerce_advance_search_setting_section' // section
		);
		
		add_settings_field(
			'bc_form_text_placeholder', // id
			'Form Place-holder Text ', // title
			array( $this, 'bc_form_text_placeholdere_callback' ), // callback
			'bigcommerce-advance-search-admin', // page
			'bigcommerce_advance_search_setting_section' // section
		);
		
		add_settings_field(
			'bc_form_text_class', // id
			'Add Extra Class Name ', // title
			array( $this, 'bc_form_text_class_callback' ), // callback
			'bigcommerce-advance-search-admin', // page
			'bigcommerce_advance_search_setting_section' // section
		);
		
		add_settings_field(
			'bas_plugin_show_notice', // id
			'Show Admin Notice', // title
			array( $this, 'bas_plugin_show_notice_callback' ), // callback
			'bigcommerce-advance-search-admin', // page
			'bigcommerce_advance_search_setting_section' // section
		);
		
		add_settings_field(
			'bc_form_custom_css', // id
			'Custom CSS ', // title
			array( $this, 'bc_form_custom_css_callback' ), // callback
			'bigcommerce-advance-search-admin', // page
			'bigcommerce_advance_search_setting_section' // section
		);

		
	}

	public function bigcommerce_advance_search_sanitize($input) {
		$sanitary_values = array();

		if ( isset( $input['bc_form_type'] ) ) {
			$sanitary_values['bc_form_type'] = sanitize_text_field($input['bc_form_type']);
		}
		
		if ( isset( $input['bc_form_text_placeholder'] ) ) {
			$sanitary_values['bc_form_text_placeholder'] = sanitize_text_field($input['bc_form_text_placeholder']);
		}
		
		if ( isset( $input['bc_form_text_class'] ) ) {
			$sanitary_values['bc_form_text_class'] = sanitize_html_class($input['bc_form_text_class']);
		}
		
		if ( isset( $input['bas_plugin_show_notice'] ) ) {
			$sanitary_values['bas_plugin_show_notice'] = sanitize_text_field($input['bas_plugin_show_notice']);
		}
		
		if ( isset( $input['bc_form_custom_css'] ) ) {
			$sanitary_values['bc_form_custom_css'] = $input['bc_form_custom_css'];
		}

		return $sanitary_values;
	}

	public function bigcommerce_advance_search_section_info() {
		
	}
	
	public function bc_form_type_callback() {
		?> <select name="bigcommerce_advance_search_option_name[bc_form_type]" id="bc_form_type">
			<?php $selected = (isset( $this->bigcommerce_advance_search_options['bc_form_type'] ) && $this->bigcommerce_advance_search_options['bc_form_type'] == 'Details Search Results on Keyword Press') ? 'selected' : '' ; ?>
			<option <?php echo $selected; ?>>Details Search Results on Keyword Press</option>
			<?php $selected = (isset( $this->bigcommerce_advance_search_options['bc_form_type'] ) && $this->bigcommerce_advance_search_options['bc_form_type'] == 'Only Autocomplete the Results matches Keyword') ? 'selected' : '' ; ?>
			<option <?php echo $selected; ?>>Only Autocomplete the Results matches Keyword</option>
		</select> <?php
	}
	
	public function bc_form_text_placeholdere_callback() {
		printf(
			'<input class="regular-text" type="text" name="bigcommerce_advance_search_option_name[bc_form_text_placeholder]" id="text_ph" value="%s">',
			isset( $this->bigcommerce_advance_search_options['bc_form_text_placeholder'] ) ? esc_attr( $this->bigcommerce_advance_search_options['bc_form_text_placeholder']) : ''
		);
	}
	
	public function bc_form_text_class_callback() {
		printf(
			'<input class="regular-text" type="text" name="bigcommerce_advance_search_option_name[bc_form_text_class]" id="text_cl" value="%s">',
			isset( $this->bigcommerce_advance_search_options['bc_form_text_class'] ) ? esc_attr( $this->bigcommerce_advance_search_options['bc_form_text_class']) : ''
		);
	}
	
	public function bas_plugin_show_notice_callback() {
		printf(
			'<input type="checkbox" name="bigcommerce_advance_search_option_name[bas_plugin_show_notice]" id="show_error" value="show_error_false" %s> <label for="show_error">Checked not to show plugin warning message.</label>',
			( isset( $this->bigcommerce_advance_search_options['bas_plugin_show_notice'] ) && esc_attr($this->bigcommerce_advance_search_options['bas_plugin_show_notice']) === 'show_error_false' ) ? 'checked' : ''
		);
	}
	
	public function bc_form_custom_css_callback() {
		printf(
			'<textarea class="large-text" rows="5" name="bigcommerce_advance_search_option_name[bc_form_custom_css]" id="bc_form_custom_css">%s</textarea>',
			isset( $this->bigcommerce_advance_search_options['bc_form_custom_css'] ) ? esc_attr( $this->bigcommerce_advance_search_options['bc_form_custom_css']) : ''
		);
	}

}
if ( is_admin() )
	$bigcommerce_advance_search = new BigcommerceAdvanceSearch();

/* 
 * Retrieve this value with:
 * $bigcommerce_advance_search_options = get_option( 'bigcommerce_advance_search_option_name' ); // Array of All Options
 * $search_type = $bigcommerce_advance_search_options['bc_form_type']; // Search Type
 * $placeholder_text = $bigcommerce_advance_search_options['bc_form_text_placeholder']; // Form Place-holder Text
 * $custom_class = $bigcommerce_advance_search_options['bc_form_text_class']; // Add class
 * $custom_css = $bigcommerce_advance_search_options['bc_form_custom_css']; // Custom CSS
 */

