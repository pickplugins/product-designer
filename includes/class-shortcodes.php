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

            $icon_separator = '<i class="fas fa-angle-double-right"></i>';
            $icon_grid = '<i class="fa fa-th"></i>';
            $icon_eraser = '<i class="fas fa-eraser"></i>';
            $icon_trash = '<i class="fas fa-trash-alt"></i>';
            $icon_clone = '<i class="far fa-copy"></i>';
            $icon_pencil = '<i class="fas fa-pencil-ruler"></i>';
            $icon_zoomin = '<i class="fas fa-search-plus"></i>';
            $icon_zoomout = '<i class="fas fa-search-minus"></i>';
            $icon_hand = '<i class="far fa-hand-paper"></i>';
            $icon_eye = '<i class="far fa-eye"></i>';
            $icon_download = '<i class="fas fa-download"></i>';
            $icon_times = '<i class="fas fa-times"></i>';
            $icon_lock = '<i class="fas fa-lock"></i>';
            $icon_unlock = '<i class="fas fa-unlock-alt"></i>';
            $icon_file = '<i class="fas fa-unlock-alt"></i>';
            $icon_cube = '<i class="fas fa-cube"></i>';
            $icon_upload = '<i class="fas fa-upload"></i>';



            wp_enqueue_style('font-awesome-5');

        }else{

            $icon_separator = '<i class="fa fa-angle-double-right"></i>';
            $icon_grid = '<i class="fa fa-th"></i>';
            $icon_eraser = '<i class="fa fa-eraser"></i>';
            $icon_trash = '<i class="fa fa-trash"></i>';
            $icon_clone = '<i class="fa fa-files-o" aria-hidden="true"></i>';
            $icon_pencil = '<i class="fa fa-pencil" aria-hidden="true"></i>';
            $icon_zoomin = '<i class="fa fa-search-plus" aria-hidden="true"></i>';
            $icon_zoomout = '<i class="fa fa-search-minus" aria-hidden="true"></i>';
            $icon_hand = '<i class="fa fa-hand-paper-o" aria-hidden="true"></i>';
            $icon_eye = '<i class="fa fa-eye" aria-hidden="true"></i>';
            $icon_download = '<i class="fa fa-download" aria-hidden="true"></i>';
            $icon_times = '<i class="fa fa-times" aria-hidden="true"></i>';
            $icon_lock = '<i class="fa fa-lock" aria-hidden="true"></i>';
            $icon_unlock = '<i class="fa fa-unlock-alt" aria-hidden="true"></i>';
            $icon_file = '<i class="fa fa-unlock-alt" aria-hidden="true"></i>';
            $icon_cube = '<i class="fa fa-cube" aria-hidden="true"></i>';
            $icon_upload = '<i class="fa fa-upload" aria-hidden="true"></i>';


            wp_enqueue_style('font-awesome-4');
        }

        $atts['icons'] = array(
            'separator' => $icon_separator,
            'grid' => $icon_grid,
            'eraser' => $icon_eraser,
            'trash' => $icon_trash,
            'clone' => $icon_clone,
            'pencil' => $icon_pencil,
            'zoomin' => $icon_zoomin,
            'zoomout' => $icon_zoomout,
            'hand' => $icon_hand,
            'eye' => $icon_eye,
            'download' => $icon_download,
            'times' => $icon_times,
            'lock' => $icon_lock,
            'unlock' => $icon_unlock,
            'file' => $icon_file,
            'cube' => $icon_cube,
            'upload' => $icon_upload,


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