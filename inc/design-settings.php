<?php
/**
 * Bigcommerce Advance search design settings page
 *
 * @since 1.2.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	die( 'Access denied.' );
}

class BasDesignSettings {
	
	private $bas_design_search_box_general;
	private $bas_design_search_box;
	private $bas_design_search_button;
	private $bas_design_search_others;
	
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'bas_design_settings_sub_menu' ) );
		add_action( 'admin_init', array( $this, 'bas_design_options_init' ) );
		ob_start();
	}
		
	public function bas_design_settings_sub_menu() {
		add_submenu_page( 'bigcommerce-advance-search', 'Design Settings', 'Design Settings', 'manage_options', 'bas-design-settings',  array($this, 'bas_design_settings_callback'));
	
	}
		
	public function bas_design_settings_callback() {
		
		wp_enqueue_style('admin-design-dynamic-style');
		wp_enqueue_script('admin-design-dynamic-script');

        $this->bas_design_search_box_general = get_option( 'bas_design_search_box_general' );
        $this->bas_design_search_box = get_option( 'bas_design_search_box' );
        $this->bas_design_search_button = get_option( 'bas_design_search_button' );
        $this->bas_design_search_others = get_option( 'bas_design_search_others' ); 
		
		$search_box_screen = ( isset( $_GET['action'] ) && 'bas_search_box' == $_GET['action'] ) ? true : false;
		$search_btn_screen = ( isset( $_GET['action'] ) && 'bas_search_btn' == $_GET['action'] ) ? true : false;
        $search_oth_screen = ( isset( $_GET['action'] ) && 'bas_search_others' == $_GET['action'] ) ? true : false; ?>
		
         <div class="wrap">
		 
		 	<a href="<?php echo admin_url('admin.php?page=bigcommerce-advance-search'); ?>">
				<div class="chip">
				  <img src="https://ps.w.org/bc-advance-search/assets/icon-256x256.png" alt="bc-advance-search" width="96" height="96">
				  <span>Go to Home</span>
				</div>
			</a>
		 
			<h1><b>::: Design Your Search Box | Looks good, do better :::</b></h1>
		 
			 <h2 class="nav-tab-wrapper">
			 
				 <a href="<?php echo admin_url( 'admin.php?page=bas-design-settings' ); ?>" class="nav-tab<?php if ( ! isset( $_GET['action'] ) || isset( $_GET['action'] ) && 'bas_search_btn' != $_GET['action'] && 'bas_search_others' != $_GET['action'] && 'bas_search_box' != $_GET['action'] ) echo ' nav-tab-active'; ?>"><?php esc_html_e( 'General' ); ?></a>
				 
				 <a href="<?php echo esc_url( add_query_arg( array( 'action' => 'bas_search_box' ), admin_url( 'admin.php?page=bas-design-settings' ) ) ); ?>" class="nav-tab<?php if ( $search_box_screen ) echo ' nav-tab-active'; ?>"><?php esc_html_e( 'Search Box' ); ?></a>
				 
				 <a href="<?php echo esc_url( add_query_arg( array( 'action' => 'bas_search_btn' ), admin_url( 'admin.php?page=bas-design-settings' ) ) ); ?>" class="nav-tab<?php if ( $search_btn_screen ) echo ' nav-tab-active'; ?>"><?php esc_html_e( 'Search Button' ); ?></a> 
				 
				 <a href="<?php echo esc_url( add_query_arg( array( 'action' => 'bas_search_others' ), admin_url( 'admin.php?page=bas-design-settings' ) ) ); ?>" class="nav-tab<?php if ( $search_oth_screen ) echo ' nav-tab-active'; ?>"><?php esc_html_e( 'Others' ); ?></a> 
			 
			 </h2>
 
			 <form method="post" action="options.php">
			 <?php 
			 if($search_box_screen) { 
					 settings_fields( 'bas_search_box' );
					 do_settings_sections( 'settings-bas-search-box' );
					 submit_button();
			 } elseif($search_btn_screen) {
					 settings_fields( 'bas_search_btn' );
					 do_settings_sections( 'settings-bas-search-btn' );
					 submit_button();
			 } elseif($search_oth_screen) {
					settings_fields( 'bas_search_others' );
					do_settings_sections( 'settings-bas-search-others' );
					submit_button();
			 } else { 
					 settings_fields( 'bas_search_general' );
					 do_settings_sections( 'settings-bas-search-general' );
					 submit_button(); 
			 } 
			 ?>
			 </form>
			 
         </div>
		<?php
			   
			}
			
		 public function bas_design_options_init() { 
		 
			//general tab
			 register_setting(
				'bas_search_general', // Option group
				'bas_design_search_box_general', // Option name
				array( $this, 'bas_sanitize_field' ) // Sanitize
			);

			add_settings_section(
				'bas-search-general-section', // ID
				'General Settings', // Title
				array( $this, 'general_print_section_info' ), // Callback
				'settings-bas-search-general' // Page
			); 
			
			//general section field.
			add_settings_field(
				'show_bas_search', 
				'Search-box appear : ', 
				array( $this, 'show_bas_search_callback' ), //callback
				'settings-bas-search-general', //page
				'bas-search-general-section' //section
			);  

			add_settings_field(
				'bas_search_appear_position', 
				'Search-box position : ', 
				array( $this, 'bas_search_appear_position_callback' ), //callback
				'settings-bas-search-general', //page
				'bas-search-general-section' //section
			);  	
			
			//search box tab
			register_setting(
				'bas_search_box', // Option group
				'bas_design_search_box', // Option name
				array( $this, 'bas_sanitize_field' ) // Sanitize
			);

			add_settings_section(
				'bas-search-box-section', // ID
				'Search Box Settings', // Title
				array( $this, 'search_box_print_section_info' ), // Callback
				'settings-bas-search-box' // Page
			); 
			
			//search box section field.
			add_settings_field(
				'bas_search_box_size', 
				'Search box size : ', 
				array( $this, 'bas_search_box_size_callback' ), //callback
				'settings-bas-search-box', //page
				'bas-search-box-section' //section
			);  
			add_settings_field(
				'bas_search_box_position', 
				'Search box position : ', 
				array( $this, 'bas_search_box_position_callback' ), //callback
				'settings-bas-search-box', //page
				'bas-search-box-section' //section
			);  
			//search button tab
			register_setting(
				'bas_search_btn', // Option group
				'bas_design_search_button', // Option name
				array( $this, 'bas_sanitize_field' ) // Sanitize
			);

			add_settings_section(
				'bas-search-btn-section', // ID
				'Search Button Settings', // Title
				array( $this, 'search_btn_print_section_info' ), // Callback
				'settings-bas-search-btn' // Page
			); 
			
			add_settings_field(
				'bas_search_btn_colour', 
				'Search button color : ', 
				array( $this, 'bas_search_btn_colour_callback' ), //callback
				'settings-bas-search-btn', //page
				'bas-search-btn-section' //section
			);  
			
			add_settings_field(
				'bas_search_btn_position', 
				'Search button position : ', 
				array( $this, 'bas_search_btn_position_callback' ), //callback
				'settings-bas-search-btn', //page
				'bas-search-btn-section' //section
			);  
			
			//others tab
			register_setting(
				'bas_search_others', // Option group
				'bas_design_search_others', // Option name
				array( $this, 'bas_sanitize_field' ) // Sanitize
			);

			add_settings_section(
				'bas-search-others-section', // ID
				'Others Settings', // Title
				array( $this, 'bas_other_print_section_info' ), // Callback
				'settings-bas-search-others' // Page
			); 
			
			add_settings_field(
				'bas_show_loader', 
				'Show loader in search box : ', 
				array( $this, 'bas_show_loader_callback' ), //callback
				'settings-bas-search-others', //page
				'bas-search-others-section' //section
			);  
	}
	
	public function general_print_section_info() {
		echo 'Edit your search general settings.';
		
	}
	
	public function search_box_print_section_info() {
		echo 'Edit your search box settings.';
		
	}
	
	public function search_btn_print_section_info() {
		echo 'Edit your search button settings.';
		
	}
	
	public function bas_other_print_section_info() {
		echo 'Edit your search other settings.';
		
	}
	
	public function bas_sanitize_field( $input ) {
        $new_input = array();
        
		//general tab section validation
		if ( isset( $input['bas_show_search_auto'] ) ) {
			$new_input['bas_show_search_auto'] = sanitize_text_field($input['bas_show_search_auto']);
		}
		
		if ( isset( $input['bas_search_appear_position'] ) ) {
			$new_input['bas_search_appear_position'] = sanitize_text_field($input['bas_search_appear_position']);
		}
		
		//search box tab section validation
		
		if ( isset( $input['bas_search_box_size'] ) ) {
			$new_input['bas_search_box_size'] = sanitize_text_field($input['bas_search_box_size']);
		}
		
		if ( isset( $input['bas_search_box_position'] ) ) {
			$new_input['bas_search_box_position'] = sanitize_text_field($input['bas_search_box_position']);
		}
		
		//search btn section validation
		if ( isset( $input['bas_search_btn_colour'] ) ) {
			$new_input['bas_search_btn_colour'] = sanitize_text_field($input['bas_search_btn_colour']);
		}
		
		if ( isset( $input['bas_search_btn_position'] ) ) {
			$new_input['bas_search_btn_position'] = sanitize_text_field($input['bas_search_btn_position']);
		}
		
		if ( isset( $input['bas_show_loader'] ) ) {
			$new_input['bas_show_loader'] = sanitize_text_field($input['bas_show_loader']);
		}

         return $new_input;
	}
	
	// general section callback functions
	public function show_bas_search_callback() {
		printf(
			'<input type="checkbox" name="bas_design_search_box_general[bas_show_search_auto]" id="show_search_box" value="show_bas_search" %s> <label for="bas_show_search_auto">Checked search box will appear automatically.</label>',
			( isset( $this->bas_design_search_box_general['bas_show_search_auto'] ) && esc_attr($this->bas_design_search_box_general['bas_show_search_auto']) == 'show_bas_search' ) ? 'checked' : ''
		);
	}
	
	public function bas_search_appear_position_callback () { ?>
	
	<select name="bas_design_search_box_general[bas_search_appear_position]" id="bas_search_appear_position">
		<?php $selected = (isset( $this->bas_design_search_box_general['bas_search_appear_position'] ) && $this->bas_design_search_box_general['bas_search_appear_position'] == 'Appear In Header') ? 'selected' : '' ; ?>
		<option <?php echo $selected; ?>>Appear In Header</option>
		<?php $selected = (isset( $this->bas_design_search_box_general['bas_search_appear_position'] ) && $this->bas_design_search_box_general['bas_search_appear_position'] == 'Appear In Footer') ? 'selected' : '' ; ?>
		<option <?php echo $selected; ?>>Appear In Footer</option>
	</select>
	
	<?php
	}
	
	//search box section callback
	public function bas_search_box_size_callback() {
		printf(
			'<input type="range" min="1" max="100" name="bas_design_search_box[bas_search_box_size]" value="%s" class="bas_search_box_size" id="bas_search_box_size"><p>Size: <span id="bas_search_box_size_view"></span></p>',
			isset( $this->bas_design_search_box['bas_search_box_size'] ) ? $this->bas_design_search_box['bas_search_box_size'] : '100'
		);
		
	}
	
	public function bas_search_box_position_callback() { ?>
		
		<select name="bas_design_search_box[bas_search_box_position]" id="bas_search_box_position">
			<?php $selected = (isset( $this->bas_design_search_box['bas_search_box_position'] ) && $this->bas_design_search_box['bas_search_box_position'] == 'Left') ? 'selected' : '' ; ?>
			<option <?php echo $selected; ?>>Left</option>
			<?php $selected = (isset( $this->bas_design_search_box['bas_search_box_position'] ) && $this->bas_design_search_box['bas_search_box_position'] == 'Right') ? 'selected' : '' ; ?>
			<option <?php echo $selected; ?>>Right</option>
			<?php $selected = (isset( $this->bas_design_search_box['bas_search_box_position'] ) && $this->bas_design_search_box['bas_search_box_position'] == 'Center') ? 'selected' : '' ; ?>
			<option <?php echo $selected; ?>>Center</option>
		</select>
	
	<?php
	}
	
	//search button section callback
	public function bas_search_btn_colour_callback() {
		printf(
		'<input type="color" id="bas_search_btn_colour" name="bas_design_search_button[bas_search_btn_colour]" value="%s"><label for="bas_search_btn_colour"> Click to choose another color.</label>',
		isset( $this->bas_design_search_button['bas_search_btn_colour'] ) ? $this->bas_design_search_button['bas_search_btn_colour'] : '#FF0000'
		);
	}
	
	public function bas_search_btn_position_callback() { ?>
	
		<select name="bas_design_search_button[bas_search_btn_position]" id="bas_search_btn_position">
			<?php $selected = (isset( $this->bas_design_search_button['bas_search_btn_position'] ) && $this->bas_design_search_button['bas_search_btn_position'] == 'Right') ? 'selected' : '' ; ?>
			<option <?php echo $selected; ?>>Right</option>
			<?php $selected = (isset( $this->bas_design_search_button['bas_search_btn_position'] ) && $this->bas_design_search_button['bas_search_btn_position'] == 'Left') ? 'selected' : '' ; ?>
			<option <?php echo $selected; ?>>Left</option>
		</select>
		
	<?php
	}
	
	//other section callback
	public function bas_show_loader_callback() { ?>
	
		<select name="bas_design_search_others[bas_show_loader]" id="bas_show_loader">
			<?php $selected = (isset( $this->bas_design_search_others['bas_show_loader'] ) && $this->bas_design_search_others['bas_show_loader'] == 'Yes') ? 'selected' : '' ; ?>
			<option <?php echo $selected; ?>>Yes</option>
			<?php $selected = (isset( $this->bas_design_search_others['bas_show_loader'] ) && $this->bas_design_search_others['bas_show_loader'] == 'No') ? 'selected' : '' ; ?>
			<option <?php echo $selected; ?>>No</option>
		</select>
	
	<?php
	}
}

if ( is_admin() )
	$BasDesignSettings = new BasDesignSettings();
