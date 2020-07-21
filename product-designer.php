<?php
/*
Plugin Name: Product Designer
Plugin URI: https://www.pickplugins.com/item/product-designer/?ref=dashboard
Description: Awesome Product Designer for Woo-Commenrce.
Version: 1.0.12
WC requires at least: 3.0.0
WC tested up to: 3.3
Author: PickPlugins
Author URI: http://pickplugins.com
Text Domain: product-designer
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/




class ProductDesigner{
	
	public function __construct(){
		

		define('product_designer_plugin_url', plugins_url('/', __FILE__) );
		define('product_designer_plugin_dir', plugin_dir_path( __FILE__ ) );
		define('product_designer_plugin_name', 'Product Designer' );
		define('product_designer_plugin_version', '1.0.12' );

        require_once( product_designer_plugin_dir . 'includes/class-settings-tabs.php');

		require_once( product_designer_plugin_dir . 'includes/class-functions.php');
		require_once( product_designer_plugin_dir . 'includes/class-shortcodes.php');
		require_once( product_designer_plugin_dir . 'includes/class-settings.php');
		require_once( product_designer_plugin_dir . 'includes/class-posttypes.php');
		require_once( product_designer_plugin_dir . 'includes/class-post-meta.php');
		require_once( product_designer_plugin_dir . 'includes/functions-wc.php');
        require_once( product_designer_plugin_dir . 'includes/settings-hook.php');



		//require_once( product_designer_plugin_dir . 'includes/tshirt-designer-meta.php');
		//require_once( product_designer_plugin_dir . 'includes/functions.php');

		//require_once( product_designer_plugin_dir . 'includes/designer.php');
		require_once( product_designer_plugin_dir . 'includes/designer-function.php');

		add_action( 'wp_enqueue_scripts', array( $this, '_front_scripts' ) );
		add_action( 'admin_enqueue_scripts', array( $this, '_admin_scripts' ) );
		add_action( 'admin_enqueue_scripts', 'wp_enqueue_media' );
		add_action( 'plugins_loaded', array( $this, 'load_textdomain' ));
		
		add_filter('widget_text', 'do_shortcode');
		
		register_activation_hook( __FILE__, array( $this, 'product_designer_install' ) );

		}

	public function load_textdomain() {


		$locale = apply_filters( 'plugin_locale', get_locale(), 'product-designer' );
		load_textdomain('product-designer', WP_LANG_DIR .'/product-designer/product-designer-'. $locale .'.mo' );

		load_plugin_textdomain( 'product-designer', false, plugin_basename( dirname( __FILE__ ) ) . '/languages/' );

	}
	
		
	public function product_designer_install(){

		do_action( 'product_designer_action_install' );
		
		}		
		
	public function product_designer_uninstall(){
		
		do_action( 'product_designer_action_uninstall' );
		}		
		
	public function product_designer_deactivation(){
		
		do_action( 'product_designer_action_deactivation' );
		}
		
		
	public function _front_scripts(){


		wp_enqueue_style('product-designer-style', product_designer_plugin_url.'assets/front/css/style.css');


		$product_designer_sticker_size = get_option( 'product_designer_sticker_size' );
		if(empty($product_designer_sticker_size))
			{
				$product_designer_sticker_size = intval(2*1000*1000);
			}
		else
			{
				$product_designer_sticker_size = intval($product_designer_sticker_size*1000*1000);
			}



		if(is_singular()){
			
			$product_designer_page_id = get_option('product_designer_page_id');

			$page_id = get_the_id();
			if($product_designer_page_id == $page_id){

				wp_enqueue_script('jquery');
				wp_enqueue_script( 'jquery-ui-core' );
				wp_enqueue_script( 'jquery-ui-widget' );
				wp_enqueue_script( 'jquery-ui-mouse' );
				wp_enqueue_script( 'jquery-ui-draggable' );
				wp_enqueue_script( 'jquery-ui-resizable' );

				wp_enqueue_script( 'fabric.min.js', plugins_url( '/assets/front/js/fabric.min.js', __FILE__ ), array('jquery'), '1.0', false);
				wp_enqueue_script( 'jquery.scrollbar.min', plugins_url( '/assets/front/js/jquery.scrollbar.min.js', __FILE__ ), array('jquery'), '1.0', false);
				wp_enqueue_style('jquery.scrollbar', product_designer_plugin_url.'assets/front/css/jquery.scrollbar.css');

				wp_enqueue_script('product_designer_js', plugins_url( '/assets/front/js/product-designer.js' , __FILE__ ) , array( 'jquery' ));
				wp_localize_script( 'product_designer_js', 'product_designer_ajax', array( 'product_designer_ajaxurl' => admin_url( 'admin-ajax.php')));
				wp_enqueue_script('fabric.curvedText', plugins_url( '/assets/front/js/fabric.curvedText.js' , __FILE__ ) , array( 'jquery' ));

				//wp_enqueue_script('anno', plugins_url( '/assets/front/js/anno.js' , __FILE__ ) , array( 'jquery' ));
				//wp_enqueue_style('anno-css', product_designer_plugin_url.'assets/front/css/anno.css');

				wp_enqueue_script('jquery-impromptu.min', plugins_url( '/assets/front/js/jquery-impromptu.min.js' , __FILE__ ) , array( 'jquery' ));
				wp_enqueue_style('jquery-impromptu.min-css', product_designer_plugin_url.'assets/front/css/jquery-impromptu.min.css');




				wp_enqueue_script( 'jscolor.js', plugins_url( 'assets/front/js/jscolor.js', __FILE__ ), array('jquery'), '1.0', false);



				wp_enqueue_style('product-designer-editor', product_designer_plugin_url.'assets/front/css/product-designer.css');
				wp_enqueue_style('FontCPD', product_designer_plugin_url.'assets/front/css/FontCPD/FontCPD.css');
				wp_enqueue_style('font-awesome.min', product_designer_plugin_url.'assets/global/css/font-awesome.min.css');
				wp_enqueue_script('plupload-all');

				wp_enqueue_style('PickIcons', product_designer_plugin_url.'assets/front/css/PickIcons/PickIcons.css');
			}
		}

		do_action('product_designer_action_front_scripts');
		}		
		
	public function _admin_scripts(){

        $screen = get_current_screen();

        //var_dump($screen);


        wp_enqueue_script('jquery');
		wp_enqueue_script('jquery-ui-sortable');

		wp_enqueue_script('product_designer_js', plugins_url( '/assets/admin/js/scripts.js' , __FILE__ ) , array( 'jquery' ));
		wp_localize_script( 'product_designer_js', 'product_designer_ajax', array( 'product_designer_ajaxurl' => admin_url( 'admin-ajax.php')));

		wp_enqueue_style('product_designer_admin', product_designer_plugin_url.'assets/admin/css/style.css');
		wp_enqueue_style('product_designer_style-templates', product_designer_plugin_url.'assets/admin/css/style-templates.css');		

		wp_enqueue_style('font-awesome.min', product_designer_plugin_url.'assets/global/css/font-awesome.min.css');
		
		//wp_enqueue_style( 'wp-color-picker' );
		//wp_enqueue_script( 'product_designer_color_picker', plugins_url('/js/color-picker.js', __FILE__ ), array( 'wp-color-picker' ), false, true );
        wp_register_style('font-awesome-4', product_designer_plugin_url.'assets/global/css/font-awesome-4.css');
        wp_register_style('font-awesome-5', product_designer_plugin_url.'assets/global/css/font-awesome-5.css');

        wp_register_style('settings-tabs', product_designer_plugin_url.'assets/settings-tabs/settings-tabs.css');
        wp_register_script('settings-tabs', product_designer_plugin_url.'assets/settings-tabs/settings-tabs.js'  , array( 'jquery' ));


        if ($screen->id == 'toplevel_page_product_designer'){

            $settings_tabs_field = new settings_tabs_field();
            $settings_tabs_field->admin_scripts();

        }


		do_action('product_designer_action_admin_scripts');
		}		
		




}

new ProductDesigner();