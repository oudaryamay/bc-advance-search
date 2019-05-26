<?php
/**
 * Bigcommerce Advance search promotion page
 *
 * @since 1.2.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	die( 'Access denied.' );
}

	function bas_promote_sub_menu() {
			add_submenu_page( 'bigcommerce-advance-search', 'Promotion', 'Promotion', 'manage_options', 'bas-promotion', 'bas_promote_callback');
		
		}
	add_action( 'admin_menu', 'bas_promote_sub_menu' );
	
	
	function bas_promote_callback() { ?>
	
	<style>
	.chip {
	  display: inline-block;
	  padding: 0 25px;
	  height: 50px;
	  font-size: 16px;
	  line-height: 50px;
	  border-radius: 25px;
	  background-color: #000000;
	  float: right;
	}

	.chip img {
	  float: left;
	  margin: 0 10px 0 -25px;
	  height: 50px;
	  width: 50px;
	  border-radius: 50%;
	}
	.chip span {
	color: #ffffff;
	}
	
	.card {
	  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
	  max-width: 300px;
	  margin: auto;
	  text-align: center;
	  font-family: arial;
	  display: inline-block;
	}
	.card button {
	  border: none;
	  outline: 0;
	  padding: 12px;
	  color: white;
	  background-color: #000;
	  text-align: center;
	  cursor: pointer;
	  width: 100%;
	  font-size: 18px;
	}

	.card button:hover {
	  opacity: 0.7;
	}
	</style>

<div class="wrap">
	
	<a href="<?php echo admin_url('admin.php?page=bigcommerce-advance-search'); ?>">
		<div class="chip">
		  <img src="https://ps.w.org/bc-advance-search/assets/icon-256x256.png" alt="bc-advance-search" width="96" height="96">
		  <span>Go to Home</span>
		</div>
	</a>	
	
	<div class="card">
		<img src="https://ps.w.org/ob-db-excel-converter/assets/icon-256x256.png" alt="OB DB Excel Converter" style="width:100%">
		  <h1>OB DB Excel Converter</h1><hr>
		  <p>This plugin provide you the functionality to export MySql database table to excel file. The plugin is very easy to use. It also allow you to show all database table’s value with “Convert To Excel” option in admin panel.</p>
		  <p><button onclick="window.open('https://wordpress.org/plugins/ob-db-excel-converter/')">Go to Plugin</button></p>
	</div>
		
	<div class="card">
		  <img src="https://ps.w.org/ob-event-manger/assets/icon-256x256.png" alt="OB Event Manger" style="width:100%">
		  <h1>OB Event Manger</h1><hr>
		  <p>OB Event Manger is a lightweight and full-featured event management plugin for adding event listing functionality to your WordPress site. The shortcode lists all the events with date and time with search funcility, it can work with any theme.</p>
		  <p><button onclick="window.open('https://wordpress.org/plugins/ob-event-manger/')">Go to Plugin</button></p>
	</div>
</div>
	
	<?php
		}