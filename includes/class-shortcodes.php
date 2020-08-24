<?php
if ( ! defined('ABSPATH')) exit;  // if direct access


class class_product_designer_shortcodes  {

    public function __construct(){

		add_shortcode( 'product_designer', array( $this, 'product_designer_display' ) );

    }

	
	public function product_designer_display($atts, $content = null ) {


        $atts = shortcode_atts(
            array(
                'product_id' => "",
                ),
            $atts
        );

        $product_id = isset($_GET['product_id']) ? sanitize_text_field($_GET['product_id']) : '';

        if(empty($product_id)){
            echo __('Product is not selected. this is probably issue with site permalink settings, please select "Post name" on permalink settings','product-designer') ;
            return;
        }


        $product_designer_settings = get_option('product_designer_settings');

        $font_aw_version = isset($product_designer_settings['font_aw_version']) ? $product_designer_settings['font_aw_version'] : 'v_4';
        $text_price = isset($product_designer_settings['text_price']) ? $product_designer_settings['text_price'] : '';
        $clipart_price = isset($product_designer_settings['clipart_price']) ? $product_designer_settings['clipart_price'] : '';
        $shape_price = isset($product_designer_settings['shape_price']) ? $product_designer_settings['shape_price'] : '';
        $qrcode_price = isset($product_designer_settings['qrcode_price']) ? $product_designer_settings['qrcode_price'] : '';
        $barcode_price= isset($product_designer_settings['barcode_price']) ? $product_designer_settings['barcode_price'] : '';
        $posts_per_page= isset($product_designer_settings['posts_per_page']) ? $product_designer_settings['posts_per_page'] : 10;
        $menu_position= isset($product_designer_settings['menu_position']) ? $product_designer_settings['menu_position'] : 'left';
        $enable_guide= isset($product_designer_settings['enable_guide']) ? $product_designer_settings['enable_guide'] : 'yes';
        $designer_page_id = isset($product_designer_settings['designer_page_id']) ? $product_designer_settings['designer_page_id'] : '';
        $clipart_width = isset($product_designer_settings['clipart_width']) ? $product_designer_settings['clipart_width'] : '';
        $clipart_bg_color = isset($product_designer_settings['clipart_bg_color']) ? $product_designer_settings['clipart_bg_color'] : '';
        $hide_sections = isset($product_designer_settings['hide_sections']) ? $product_designer_settings['hide_sections'] : array();

        $allow_upload_clipart = isset($product_designer_settings['allow_upload_clipart']) ? $product_designer_settings['allow_upload_clipart'] : array();
        $allow_upload_shape = isset($product_designer_settings['allow_upload_shape']) ? $product_designer_settings['allow_upload_shape'] : array();



        $currency_symbol = get_woocommerce_currency_symbol();
        $session_id = session_id();


        $atts['settings']['text_price'] = $text_price;
        $atts['settings']['clipart_price'] = $clipart_price;
        $atts['settings']['shape_price'] = $shape_price;
        $atts['settings']['qrcode_price'] = $qrcode_price;
        $atts['settings']['barcode_price'] = $barcode_price;
        $atts['settings']['posts_per_page'] = $posts_per_page;
        $atts['settings']['menu_position'] = $menu_position;
        $atts['settings']['enable_guide'] = $enable_guide;
        $atts['settings']['designer_page_id'] = $designer_page_id;
        $atts['settings']['designer_page_url'] = get_permalink($designer_page_id);
        $atts['settings']['clipart_width'] = $clipart_width;
        $atts['settings']['clipart_bg_color'] = $clipart_bg_color;
        $atts['settings']['hide_sections'] = $hide_sections;

        $atts['settings']['allow_upload_clipart'] = $allow_upload_clipart;
        $atts['settings']['allow_upload_shape'] = $allow_upload_shape;

        $atts['product_id'] = $product_id;
        $atts['product_title'] = get_the_title($product_id);
        $atts['currency_symbol'] = $currency_symbol;
        $atts['session_id'] = $session_id;


        $product_data = wc_get_product($product_id);
//        $is_variable = $product_data->is_type('variable');
        $product_type = $product_data->get_type();

        if($product_type == 'variable'):

            $variation_id = isset($_GET['variation_id']) ? sanitize_text_field($_GET['variation_id']): '';

            $atts['variation_id'] = $variation_id;


            if(empty($variation_id)){
                echo __('Product variation is not selected.','product-designer') ;
                return;
            }

            $pd_template_id = get_post_meta( $variation_id, 'pd_template_id', true );


            $variation_data = new WC_Product_Variation( $variation_id );

            $sale_price = $variation_data->get_sale_price();
            $regular_price = $variation_data->get_regular_price();

            if(!empty($sale_price)){
                $product_base_price = $sale_price;
                $product_display_price = '<strike>'.$currency_symbol.$regular_price.'</strike> - '.$currency_symbol.$sale_price;;
            }
            else{
                $product_base_price = $regular_price;
                $product_display_price = $currency_symbol.$regular_price;;
            }


            $atts['base_price'] = $product_base_price;
            $atts['display_price'] = $product_display_price;



        elseif($product_type == 'simple'):

            $pd_template_id = get_post_meta( $product_id, 'pd_template_id', true );

            $sale_price = get_post_meta($product_id, '_sale_price', true);
            $regular_price = get_post_meta($product_id, '_regular_price', true);

            if(!empty($sale_price)){
                $product_base_price = $sale_price;
                $product_display_price = $product_data->get_price_html();
            }
            else{
                $product_base_price = $regular_price;
                $product_display_price = $product_data->get_price_html();
            }

            $atts['base_price'] = $product_base_price;
            $atts['display_price'] = $product_display_price;


        endif;

        $atts['pd_template_id'] = $pd_template_id;
        $atts['product_type'] = $product_type;


        $canvas = get_post_meta( $pd_template_id, 'canvas', true );
        $side_data = get_post_meta( $pd_template_id, 'side_data', true );


        $atts['canvas'] = $canvas;
        $atts['side_data'] = $side_data;

        //var_dump($canvas);


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
            $icon_file_image = '<i class="fas fa-file-image"></i>';
            $icon_file_word = '<i class="far fa-file-word"></i>';

            $icon_cube = '<i class="fas fa-cube"></i>';
            $icon_upload = '<i class="fas fa-upload"></i>';
            $icon_shapes = '<i class="fas fa-shapes"></i>';
            $icon_undo = '<i class="fas fa-undo-alt"></i>';
            $icon_redo = '<i class="fas fa-redo-alt"></i>';
            $icon_rotation = '<i class="fas fa-sync-alt"></i>';
            $icon_expand = '<i class="fas fa-expand-alt"></i>';
            $icon_arrows_h = '<i class="fas fa-arrows-alt-h"></i>';
            $icon_arrows_v = '<i class="fas fa-arrows-alt-v"></i>';
            $icon_layers = '<i class="fas fa-layer-group"></i>';
            $icon_text_bold = '<i class="fas fa-bold"></i>';
            $icon_text_italic = '<i class="fas fa-italic"></i>';
            $icon_text_underline = '<i class="fas fa-underline"></i>';
            $icon_text_strikethrough = '<i class="fas fa-strikethrough"></i>';
            $icon_keyboard = '<i class="far fa-keyboard"></i>';
            $icon_cart = '<i class="fas fa-shopping-cart"></i>';
            $icon_spinner = '<i class="fas fa-spinner fa-spin"></i>';
            $icon_unsplash = '<i class="fab fa-unsplash"></i>';



            wp_enqueue_style('font-awesome-5');

        }else{

            $icon_separator = '<i class="fa fa-angle-double-right"></i>';
            $icon_grid = '<i class="fa fa-th"></i>';
            $icon_eraser = '<i class="fa fa-eraser"></i>';
            $icon_trash = '<i class="fa fa-trash"></i>';
            $icon_clone = '<i class="fa fa-files-o"></i>';
            $icon_pencil = '<i class="fa fa-pencil"></i>';
            $icon_zoomin = '<i class="fa fa-search-plus"></i>';
            $icon_zoomout = '<i class="fa fa-search-minus"></i>';
            $icon_hand = '<i class="fa fa-hand-paper-o"></i>';
            $icon_eye = '<i class="fa fa-eye"></i>';
            $icon_download = '<i class="fa fa-download"></i>';
            $icon_times = '<i class="fa fa-times"></i>';
            $icon_lock = '<i class="fa fa-lock"></i>';
            $icon_unlock = '<i class="fa fa-unlock-alt"></i>';
            $icon_file_image = '<i class="fa fa-file-image-o"></i>';
            $icon_file_word = '<i class="fa fa-file-word-o" ></i>';

            $icon_cube = '<i class="fa fa-cube"></i>';
            $icon_upload = '<i class="fa fa-upload"></i>';
            $icon_shapes = '<i class="fa fa-codepen" ></i>';
            $icon_undo = '<i class="fa fa-undo"></i>';
            $icon_redo = '<i class="fa fa-repeat"></i>';
            $icon_rotation = '<i class="fa fa-refresh"></i>';
            $icon_expand = '<i class="fa fa-expand"></i>';
            $icon_arrows_h = '<i class="fa fa-arrows-h"></i>';
            $icon_arrows_v = '<i class="fa fa-arrows-v"></i>';
            $icon_layers = '<i class="fa fa-list-ul"></i>';
            $icon_text_bold = '<i class="fa fa-bold"></i>';
            $icon_text_italic = '<i class="fa fa-italic"></i>';
            $icon_text_underline = '<i class="fa fa-underline"></i>';
            $icon_text_strikethrough = '<i class="fa fa-strikethrough"></i>';
            $icon_keyboard = '<i class="fa fa-keyboard-o" aria-hidden="true"></i>';
            $icon_cart = '<i class="fa fa-shopping-cart" aria-hidden="true"></i>';
            $icon_spinner = '<i class="fa fa-spinner fa-spin"></i>';
            $icon_unsplash = '';


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
            'file_image' => $icon_file_image,
            'file_word' => $icon_file_word,

            'cube' => $icon_cube,
            'upload' => $icon_upload,
            'shapes' => $icon_shapes,
            'undo' => $icon_undo,
            'redo' => $icon_redo,
            'rotation' => $icon_rotation,
            'expand' => $icon_expand,
            'arrows_h' => $icon_arrows_h,
            'arrows_v' => $icon_arrows_v,
            'layers' => $icon_layers,
            'cart' => $icon_cart,
            'text_bold' => $icon_text_bold,
            'text_italic' => $icon_text_italic,
            'text_underline' => $icon_text_underline,
            'text_strikethrough' => $icon_text_strikethrough,
            'keyboard' => $icon_keyboard,
            'spinner' => $icon_spinner,
            'unsplash' => $icon_unsplash,


        );







        $atts = apply_filters('product_designer_shortcode_atts', $atts);


        $editor_class = apply_filters('product_designer_editor_class', 'product-designer');


        ob_start();

        ?>
        <div class="<?php echo $editor_class; ?>">
            <?php
            do_action('product_designer_editor', $atts);
            ?>
        </div>
        <?php




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