<?php
if ( ! defined('ABSPATH')) exit;  // if direct access


class class_product_designer_shortcodes  {

    public function __construct(){

		add_shortcode( 'product_designer', array( $this, 'product_designer_display' ) );

    }

	
	public function product_designer_display($atts, $content = null ) {


        $atts = shortcode_atts(
            array(
                'id' => "",
                ),
            $atts);

        $product_designer_settings = get_option('product_designer_settings');
        $font_aw_version = isset($product_designer_settings['font_aw_version']) ? $product_designer_settings['font_aw_version'] : 'v_4';

        //var_dump($font_aw_version);



        if($font_aw_version == 'v_5'){
            $separator_icon = '<i class="fas fa-angle-double-right"></i>';



            wp_enqueue_style('font-awesome-5');
        }elseif ($font_aw_version == 'v_4'){

            $separator_icon = '<i class="fa fa-angle-double-right"></i>';



            wp_enqueue_style('font-awesome-4');
        }

        $atts['icons'] = array(
            'separator_icon' => $separator_icon,

        );


        $atts = apply_filters('product_designer_atts', $atts);




        ob_start();

        do_action('product_designer_editor', $atts);


        wp_enqueue_style('hint.min');
        wp_enqueue_style('PickIcons');
        wp_enqueue_style('product-designer-editor');
        wp_enqueue_style('FontCPD');
        wp_enqueue_style('jquery.scrollbar');
        wp_enqueue_style('product-designer-style');
        wp_enqueue_style('jquery-impromptu');
        wp_enqueue_script('plupload-all');
        //wp_enqueue_script('product_designer_vue');



        wp_enqueue_script('jquery');
        wp_enqueue_script( 'jquery-ui-core' );
        wp_enqueue_script( 'jquery-ui-tabs' );
        wp_enqueue_script('jquery-ui-accordion');



        wp_enqueue_script('jquery.scrollbar');

        wp_enqueue_script('jquery-impromptu');

        wp_enqueue_script('jscolor');
        wp_enqueue_script('plupload-all');
        wp_enqueue_script('product_designer_js');






        return ob_get_clean();

    }

}

new class_product_designer_shortcodes();