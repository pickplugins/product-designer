<?php
if ( ! defined('ABSPATH')) exit;  // if direct access

add_action('product_designer', 'product_designer_main');

function product_designer_main(){

    //$session = $_SESSION;
    $session_id = session_id();


    $product_designer_upload_clipart = get_option('product_designer_upload_clipart');
    $product_designer_page_id = get_option('product_designer_page_id');
    $product_designer_page_url = get_permalink($product_designer_page_id);
    $product_designer_canvas_width = get_option( 'product_designer_canvas_width', '500' );
    $product_designer_canvas_height = get_option( 'product_designer_canvas_height', '600' );
    $product_designer_error = array();


    $post_id = get_the_ID();
    $page_url = get_permalink($post_id);


    if(!empty($_GET['product_id'])):

        $product_id = isset($_GET['product_id']) ? sanitize_text_field($_GET['product_id']) : '';

        $product_data = wc_get_product($product_id);
        $is_variable = $product_data->is_type('variable');


        if($is_variable):

            $variation_id = isset($_GET['variation_id']) ? sanitize_text_field($_GET['variation_id']): '';
            $pd_template_id = get_post_meta( $variation_id, 'pd_template_id', true );
            $canvas_settings = get_post_meta( $pd_template_id, 'canvas', true );

            $side_data = get_post_meta( $pd_template_id, 'side_data', true );


            if(empty($variation_id)):
                $product_designer_error['variation_id_missing'] = 'Variation id is missing';
            endif;



        else:

            $pd_template_id = get_post_meta( $product_id, 'pd_template_id', true );
            $canvas_settings = get_post_meta( $pd_template_id, 'canvas', true );

            $side_data = get_post_meta( $pd_template_id, 'side_data', true );


        endif;



        if(empty($side_data)) $side_data = array();

        $pre_templates = get_post_meta( $pd_template_id, 'pre_templates', true );






        if(!empty($_GET['side'])){
            $current_side = isset($_GET['side']) ? sanitize_text_field($_GET['side']) : '';

        }
        else{
            $current_side = '';
            $current_side_empty = array();
            if(!empty($side_data))
                foreach($side_data as $id=>$side){
                    $current_side_empty[] = $id;
                }
            if(!empty($current_side_empty[0])){
                $current_side = $current_side_empty[0];
            }
            else{
                $current_side = '';
            }
        }



        ?>


        <div class="product-designer-notice">
            <?php
            include product_designer_plugin_dir.'/templates/product-designer/product-designer-notice.php';
            ?>
        </div>

        <div class="product-designer">




            <?php do_action('product_designer', $product_id);



            include product_designer_plugin_dir.'/templates/product-designer/product-designer-menu.php';
            include product_designer_plugin_dir.'/templates/product-designer/product-designer-edit-panel.php';
            include product_designer_plugin_dir.'/templates/product-designer/product-designer-canvas.php';


            //include product_designer_plugin_dir.'/templates/product-designer/product-designer-final.php';

            include product_designer_plugin_dir.'/templates/product-designer/product-designer-css.php';
            include product_designer_plugin_dir.'/templates/product-designer/product-designer-js.php';
            include product_designer_plugin_dir.'/templates/product-designer/product-designer-loading.php';
            include product_designer_plugin_dir.'/templates/product-designer/product-designer-welcome-tour.php';
            include product_designer_plugin_dir.'/templates/product-designer/product-designer-preview.php';



            ?>

            <div class="toast">
                <span class="icon"></span> <span class="message"></span>
            </div>

        </div>

    <?php


    endif;

}







