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


        $atts = apply_filters('product_designer_atts', $atts);

        ob_start();

        do_action('product_designer', $atts);

        return ob_get_clean();

    }

}

new class_product_designer_shortcodes();