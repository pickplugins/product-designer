<?php

/*
* @Author 		PickPlugins
*/

if ( ! defined('ABSPATH')) exit;  // if direct access



add_action('shape_metabox_tabs_content_general', 'shape_metabox_tabs_content_general', 10, 2);

function shape_metabox_tabs_content_general($tab, $post_id){

    $settings_tabs_field = new settings_tabs_field();

    $shape_thumb_id = get_post_meta($post_id, 'shape_thumb_id', true);

    //var_dump($post_id);

    $thumb_id = get_post_thumbnail_id( $post_id );
    //var_dump($thumb_id);

    $shape_thumb_id = !empty($shape_thumb_id) ? $shape_thumb_id : $thumb_id;

    //var_dump($shape_thumb_id);




    ?>
    <div class="section">
        <div class="section-title"><?php echo __('Shape settings', 'product-designer'); ?></div>
        <p class="description section-description"><?php echo __('Choose options for shape.', 'product-designer'); ?></p>

        <?php


        $args = array(
            'id'		=> 'shape_thumb_id',
//            'parent'		=> 'canvas',
            'title'		=> __('shape/svg image','product-designer'),
            'details'	=> __('Upload svg image. Get svg shape from bellow source<br><ul><li><a href="https://www.flaticon.com/search?word=shapes">https://www.flaticon.com</a></li><li><a href="https://www.iconfinder.com/search/?price=free&q=shape">https://www.iconfinder.com</a></li><li><a href="https://freeicons.io/filter/popular/all/shape">https://freeicons.io</a></li></ul>','product-designer'),
            'type'		=> 'media',
            'placeholder_text'		=> 'placeholder.svg',

            'value'		=> $shape_thumb_id,
            'default'		=> '',
        );

        $settings_tabs_field->generate_field($args, $post_id);




        ?>


    </div>



    <?php

}





add_action('product_designer_shape_metabox_save','product_designer_shape_metabox_save');

function product_designer_shape_metabox_save($job_id){


    $shape_thumb_id = isset($_POST['shape_thumb_id']) ? sanitize_text_field($_POST['shape_thumb_id']) : '';
    update_post_meta($job_id, 'shape_thumb_id', $shape_thumb_id);

}


function product_designer_custom_mime_types( $mimes ) {

    // New allowed mime types.
    $mimes['svg'] = 'image/svg+xml';
    $mimes['svgz'] = 'image/svg+xml';
    //$mimes['doc'] = 'application/msword';
//    ["txt|asc|c|cc|h|srt"]=> "text/plain"

    // Optional. Remove a mime type.
    //unset( $mimes['exe'] );

    return $mimes;
}
add_filter( 'upload_mimes', 'product_designer_custom_mime_types' );
