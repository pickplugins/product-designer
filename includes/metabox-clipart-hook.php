<?php

/*
* @Author 		PickPlugins
*/

if ( ! defined('ABSPATH')) exit;  // if direct access



add_action('clipart_metabox_tabs_content_general', 'clipart_metabox_tabs_content_general', 10, 2);

function clipart_metabox_tabs_content_general($tab, $post_id){

    $settings_tabs_field = new settings_tabs_field();

    $clipart_price = get_post_meta($post_id, 'clipart_price', true);
    $clipart_thumb_id = get_post_meta($post_id, 'clipart_thumb_id', true);

    //var_dump($post_id);

    $thumb_id = get_post_thumbnail_id( $post_id );
    //var_dump($thumb_id);

    $clipart_thumb_id = !empty($clipart_thumb_id) ? $clipart_thumb_id : $thumb_id;

    //var_dump($clipart_thumb_id);




    ?>
    <div class="section">
        <div class="section-title"><?php echo __('Clipart settings', 'product-designer'); ?></div>
        <p class="description section-description"><?php echo __('Choose options for clipart.', 'product-designer'); ?></p>

        <?php

        $args = array(
            'id'		=> 'clipart_price',
//            'parent'		=> 'canvas',
            'title'		=> __('Price','product-designer'),
            'details'	=> __('Set clipart price, use number only, ex: 2','product-designer'),
            'type'		=> 'text',
            'value'		=> $clipart_price,
            'default'		=> '',
            'placeholder'		=> '2',
        );

        $settings_tabs_field->generate_field($args, $post_id);



        $args = array(
            'id'		=> 'clipart_thumb_id',
//            'parent'		=> 'canvas',
            'title'		=> __('Clipart image','product-designer'),
            'details'	=> __('Set clipart image.','product-designer'),
            'type'		=> 'media',
            'value'		=> $clipart_thumb_id,
            'default'		=> '',
        );

        $settings_tabs_field->generate_field($args, $post_id);




        ?>


    </div>



    <?php

}





add_action('product_designer_clipart_metabox_save','product_designer_clipart_metabox_save');

function product_designer_clipart_metabox_save($job_id){

    $clipart_price = isset($_POST['clipart_price']) ? sanitize_text_field($_POST['clipart_price']) : '';
    update_post_meta($job_id, 'clipart_price', $clipart_price);


    $clipart_thumb_id = isset($_POST['clipart_thumb_id']) ? sanitize_text_field($_POST['clipart_thumb_id']) : '';
    update_post_meta($job_id, 'clipart_thumb_id', $clipart_thumb_id);

}



