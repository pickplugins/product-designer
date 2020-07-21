<?php



if ( ! defined('ABSPATH')) exit;  // if direct access

class class_product_designer_settings{

	public function __construct(){
		
		add_action('admin_menu', array( $this, 'menu_init' ));
		
		}


    public function menu_init() {

        add_menu_page(__('Product Designer', 'product-designer'), __('Product Designer', 'product-designer'), 'manage_options', 'product_designer', array( $this, 'settings' ), 'dashicons-store');



    }

	public function settings(){
		include(product_designer_plugin_dir.'includes/menu/settings.php');
	}









	
}
	
new class_product_designer_settings();