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

        $html = '';
        $post_id = isset($atts['id']) ? sanitize_text_field($atts['id']) : '';


        ob_start();
        include product_designer_plugin_dir.'/templates/product-designer/product-designer.php';
        echo $html;
        return ob_get_clean();

    }

}

new class_product_designer_shortcodes();