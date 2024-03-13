<?php
/*
Plugin Name: Product Designer
Plugin URI: https://www.pickplugins.com/item/product-designer/?ref=dashboard
Description: Awesome Product Designer for Woo-Commenrce.
Version: 1.0.32
WC requires at least: 3.0.0
WC tested up to: 5.1
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
		define('product_designer_plugin_version', '1.0.32' );

        require_once( product_designer_plugin_dir . 'includes/class-settings-tabs.php');
        require_once( product_designer_plugin_dir . 'includes/class-request-reviews.php');

		require_once( product_designer_plugin_dir . 'includes/class-functions.php');
		require_once( product_designer_plugin_dir . 'includes/class-shortcodes.php');
		require_once( product_designer_plugin_dir . 'includes/class-settings.php');
		require_once( product_designer_plugin_dir . 'includes/class-posttypes.php');
		require_once( product_designer_plugin_dir . 'includes/class-post-meta.php');
		require_once( product_designer_plugin_dir . 'includes/functions-wc.php');
        require_once( product_designer_plugin_dir . 'includes/settings-hook.php');
        require_once( product_designer_plugin_dir . 'templates/product-designer/product-designer-hook.php');

        require_once( product_designer_plugin_dir . 'includes/metabox-pd_template-hook.php');
        require_once( product_designer_plugin_dir . 'includes/class-meta-boxes.php');
        require_once( product_designer_plugin_dir . 'includes/metabox-clipart-hook.php');
        require_once( product_designer_plugin_dir . 'includes/metabox-shape-hook.php');


		//require_once( product_designer_plugin_dir . 'includes/tshirt-designer-meta.php');

		//require_once( product_designer_plugin_dir . 'includes/designer.php');
		require_once( product_designer_plugin_dir . 'includes/designer-function.php');

		add_action( 'wp_enqueue_scripts', array( $this, '_front_scripts' ) );
		add_action( 'admin_enqueue_scripts', array( $this, '_admin_scripts' ) );
		add_action( 'admin_enqueue_scripts', 'wp_enqueue_media' );
		add_action( 'plugins_loaded', array( $this, 'load_textdomain' ));
		
		add_filter('widget_text', 'do_shortcode');
		
		register_activation_hook( __FILE__, array( $this, '_activation' ) );

		$args = array(
		    'option_name' => 'product_designer_settings',
            'review_url' => 'https://wordpress.org/support/plugin/product-designer/reviews/#new-post',
            'plugin_name' => 'Product Designer',

        );

        $pickplugins_request_reviews = new pickplugins_request_reviews($args);







		}

	public function load_textdomain() {


		$locale = apply_filters( 'plugin_locale', get_locale(), 'product-designer' );
		load_textdomain('product-designer', WP_LANG_DIR .'/product-designer/product-designer-'. $locale .'.mo' );

		load_plugin_textdomain( 'product-designer', false, plugin_basename( dirname( __FILE__ ) ) . '/languages/' );

	}
	
		
	public function _activation(){

        $product_designer_settings = get_option('product_designer_settings');
        $product_designer_page_id = get_option('product_designer_page_id');


        $designer_page_id = isset($product_designer_settings['designer_page_id']) ? $product_designer_settings['designer_page_id'] : '';


        if( empty( $designer_page_id ) ) :

            if(!empty($product_designer_page_id)){
                $page_id = $product_designer_page_id;
            }else{
                $page_id = wp_insert_post( array(
                    'post_title' 	=> __('Designer', 'product-designer'),
                    'slug' 			=> 'designer',
                    'post_type' 	=> 'page',
                    'post_status' 	=> 'publish',
                    'post_content' 	=> '[product_designer]',
                ) );
            }

            $product_designer_settings['designer_page_id'] = $page_id;

        endif;

        $product_designer_settings['font_aw_version'] = 'v_4';


        update_option('product_designer_settings', $product_designer_settings);


        do_action( 'product_designer_activation' );
		
		}		
		
	public function _uninstall(){
		
		do_action( 'product_designer_uninstall' );
		}		
		
	public function _deactivation(){
		
		do_action( 'product_designer_deactivation' );
		}
		
		
	public function _front_scripts(){


        wp_register_style('customize-link', product_designer_plugin_url.'assets/front/css/customize-link.css');


        wp_register_script('jquery-impromptu', plugins_url( '/assets/front/js/jquery-impromptu.min.js' , __FILE__ ) , array( 'jquery' ));
        wp_register_style('jquery-impromptu', product_designer_plugin_url.'assets/front/css/jquery-impromptu.min.css');


        wp_register_script( 'jscolor', plugins_url( 'assets/front/js/jscolor.js', __FILE__ ), array('jquery'), '1.0', false);
        wp_register_script( 'fabric.js', plugins_url( '/assets/front/js/fabric.min.js', __FILE__ ), array('jquery'), '1.0', false);
        //wp_register_script( 'fabric.js', plugins_url( '/assets/front/js/fabric-4.4.0.min.js', __FILE__ ), array('jquery'), '1.0', false);

        wp_register_script( 'jquery.scrollbar', plugins_url( '/assets/front/js/jquery.scrollbar.min.js', __FILE__ ), array('jquery'), '1.0', false);

        wp_register_script('product_designer_js', plugins_url( '/assets/front/js/product-designer.js' , __FILE__ ) , array( 'jquery' ));
        wp_localize_script( 'product_designer_js', 'product_designer_ajax', array( 'product_designer_ajaxurl' => admin_url( 'admin-ajax.php')));
        wp_register_script('fabric.curvedText', plugins_url( '/assets/front/js/fabric.curvedText.js' , __FILE__ ) , array( 'jquery' ));

        wp_register_style('font-awesome-4', product_designer_plugin_url.'assets/global/css/font-awesome-4.css');
        wp_register_style('font-awesome-5', product_designer_plugin_url.'assets/global/css/font-awesome-5.css');
        wp_register_style('hint.min', product_designer_plugin_url.'assets/front/css/hint.min.css');
        wp_register_style('product-designer-editor', product_designer_plugin_url.'assets/front/css/product-designer.css');
        wp_register_style('FontCPD', product_designer_plugin_url.'assets/front/css/FontCPD/FontCPD.css');
        wp_register_style('jquery.scrollbar', product_designer_plugin_url.'assets/front/css/jquery.scrollbar.css');
        wp_enqueue_script('jquery-qrcode.min', plugins_url( '/assets/front/js/jquery-qrcode.min.js' , __FILE__ ) , array( 'jquery' ));
        wp_enqueue_script( 'JsBarcode.all.min.js', plugins_url( 'assets/front/js/JsBarcode.all.min.js', __FILE__ ), array('jquery'), '1.0', false);

        if(isset($_GET['pd_enable']) || isset($_GET['product_id'])){
            wp_enqueue_script('fabric.js');
            wp_enqueue_script('fabric.curvedText');
        }




        do_action('product_designer_front_scripts');
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
        wp_register_script('jquery.lazy', product_designer_plugin_url.'assets/admin/js/jquery.lazy.js', array('jquery'));

		//wp_enqueue_style('font-awesome.min', product_designer_plugin_url.'assets/global/css/font-awesome.min.css');
		
		//wp_enqueue_style( 'wp-color-picker' );
		//wp_enqueue_script( 'product_designer_color_picker', plugins_url('/js/color-picker.js', __FILE__ ), array( 'wp-color-picker' ), false, true );
        wp_register_style('font-awesome-4', product_designer_plugin_url.'assets/global/css/font-awesome-4.css');
        wp_register_style('font-awesome-5', product_designer_plugin_url.'assets/global/css/font-awesome-5.css');

        wp_register_style('settings-tabs', product_designer_plugin_url.'assets/settings-tabs/settings-tabs.css');
        wp_register_script('settings-tabs', product_designer_plugin_url.'assets/settings-tabs/settings-tabs.js'  , array( 'jquery' ));


        if ( $screen->id == 'shop_order' || $screen->id == 'pd_template'){

            $settings_tabs_field = new settings_tabs_field();
            $settings_tabs_field->admin_scripts();

        }


		do_action('product_designer_admin_scripts');
		}		
		




}

new ProductDesigner();