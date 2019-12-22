<?php
if ( ! defined('ABSPATH')) exit;  // if direct access 	


class product_designer_class_settings  {
	
	
    public function __construct(){

		add_action( 'admin_menu', array( $this, 'admin_menu' ), 9 );

    }
	
	
	public function admin_menu() {


		add_menu_page(__('Product Designer', 'product-designer'), __('Product Designer', 'product-designer'), 'manage_options', 'product_designer', array( $this, 'settings' ));
		add_submenu_page('product_designer', __('Clip Art Categories', 'product-designer'), __('Clip Art Categories', 'product-designer'), 'manage_options', 'edit-tags.php?taxonomy=clipart_cat&post_type=clipart' );


	}
	
	public function settings(){
		
		include( 'menu/settings.php' );	
		
		}
	


}


new product_designer_class_settings();

