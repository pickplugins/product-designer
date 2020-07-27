<?php
if ( ! defined('ABSPATH')) exit;  // if direct access

add_action('product_designer_settings_content_general', 'product_designer_settings_content_general');

function product_designer_settings_content_general(){
    $settings_tabs_field = new settings_tabs_field();

    $product_designer_settings = get_option('product_designer_settings');

    $font_aw_version = isset($product_designer_settings['font_aw_version']) ? $product_designer_settings['font_aw_version'] : 'none';
    $designer_page_id = isset($product_designer_settings['designer_page_id']) ? $product_designer_settings['designer_page_id'] : '';
    $allow_upload_clipart = isset($product_designer_settings['allow_upload_clipart']) ? $product_designer_settings['allow_upload_clipart'] : 'no';
    $quotes = isset($product_designer_settings['quotes']) ? $product_designer_settings['quotes'] : array();
    $google_fonts = isset($product_designer_settings['google_fonts']) ? $product_designer_settings['google_fonts'] : array();
    $custom_fonts = isset($product_designer_settings['custom_fonts']) ? $product_designer_settings['custom_fonts'] : array();

    $menu_position = isset($product_designer_settings['menu_position']) ? $product_designer_settings['menu_position'] : '';



    //echo '<pre>'.var_export($product_designer_settings, true).'</pre>';

    ?>
    <div class="section">
        <div class="section-title"><?php echo __('General', 'post-grid'); ?></div>
        <p class="description section-description"><?php echo __('Choose some general options.', 'post-grid'); ?></p>

        <?php

        $args = array(
            'id'		=> 'designer_page_id',
            'parent'		=> 'product_designer_settings',
            'title'		=> __('Designer page','post-grid'),
            'details'	=> __('Display product desginer, use shortcode <code>[product_designer]</code> on that page.','post-grid'),
            'type'		=> 'select',
            'value'		=> $designer_page_id,
            'default'		=> '',
            'args'		=> product_designer_get_pages(),
        );

        $settings_tabs_field->generate_field($args);

        $args = array(
            'id'		=> 'font_aw_version',
            'parent'		=> 'product_designer_settings',
            'title'		=> __('Font-awesome version','post-grid'),
            'details'	=> __('Choose font awesome version you want to load.','post-grid'),
            'type'		=> 'select',
            'value'		=> $font_aw_version,
            'default'		=> '',
            'args'		=> array('v_5'=>__('Version 5+','post-grid'), 'v_4'=>__('Version 4+','post-grid'), 'none'=>__('None','post-grid')  ),
        );

        $settings_tabs_field->generate_field($args);



        $args = array(
            'id'		=> 'allow_upload_clipart',
            'parent'		=> 'product_designer_settings',
            'title'		=> __('Can user upload clipart?','post-grid'),
            'details'	=> __('Choose to allow upload cliparts','post-grid'),
            'type'		=> 'select',
            'value'		=> $allow_upload_clipart,
            'default'		=> '',
            'args'		=> array('no'=>__('No','post-grid'), 'yes'=>__('Yes','post-grid')  ),
        );

        $settings_tabs_field->generate_field($args);




        $args = array(
            'id'		=> 'quotes',
            'parent'		=> 'product_designer_settings',
            'title'		=> __('Quotes','post-grid'),
            'details'	=> __('Add quotes','post-grid'),
            'type'		=> 'text_multi',
            'value'		=> $quotes,
            'default'		=> array(),
        );

        $settings_tabs_field->generate_field($args);



        $font_fields = array(

            array(
                'id'		=> 'name',
                'title'		=> __('Font Name','team'),
                'details'	=> __('Write font name here.','team'),
                'type'		=> 'text',
                'value'		=> '',
                'default'		=> '',
                'placeholder'		=> 'Open Sans',
            ),
            array(
                'id'		=> 'url',
                'title'		=> __('Font URL','team'),
                'details'	=> __('Write font source url.','team'),
                'type'		=> 'text',
                'value'		=> '',
                'default'		=> '',
                'placeholder'		=> 'url',
            ),


        );


        $args = array(
            'id'		=> 'google_fonts',
            'parent'		=> 'product_designer_fonts',
            'title'		=> __('Google Fonts','text-domain'),
            'details'	=> __('Add google fonts','text-domain'),
            'collapsible'=> true,
            'type'		=> 'repeatable',
            'limit'		=> 10,
            'title_field'		=> 'name',
            'value'		=> $google_fonts,
            'fields'    => $font_fields,
        );

        $settings_tabs_field->generate_field($args);



        $font_fields = array(

            array(
                'id'		=> 'font_family',
                'title'		=> __('Font family','team'),
                'details'	=> __('Write font family here.','team'),
                'type'		=> 'text',
                'value'		=> '',
                'default'		=> '',
                'placeholder'		=> 'My Font',
            ),
            array(
                'id'		=> 'src',
                'title'		=> __('Font URL','team'),
                'details'	=> __('Write font source url.','team'),
                'type'		=> 'text',
                'value'		=> '',
                'default'		=> '',
                'placeholder'		=> 'http://www.yourwebsite.com/fonts/my-font.ttf',
            ),
            array(
                'id'		=> 'font_weight',
                'title'		=> __('Font weight','team'),
                'details'	=> __('Write font weight.','team'),
                'type'		=> 'text',
                'value'		=> '',
                'default'		=> '',
                'placeholder'		=> 'normal',
            ),



        );

        $args = array(
            'id'		=> 'custom_fonts',
            'parent'		=> 'product_designer_fonts',
            'title'		=> __('Custom Fonts','text-domain'),
            'details'	=> __('Add custom fonts','text-domain'),
            'collapsible'=> true,
            'type'		=> 'repeatable',
            'limit'		=> 10,
            'title_field'		=> 'name',
            'value'		=> $custom_fonts,
            'fields'    => $font_fields,
        );

        $settings_tabs_field->generate_field($args);


        $args = array(
            'id'		=> 'menu_position',
            'parent'		=> 'product_designer_settings',
            'title'		=> __('Menu position?','post-grid'),
            'details'	=> __('Choose menu position','post-grid'),
            'type'		=> 'select',
            'value'		=> $menu_position,
            'default'		=> '',
            'args'		=> array('left'=>__('Left','post-grid'), 'right'=>__('Right','post-grid')  ),
        );

        $settings_tabs_field->generate_field($args);

        ?>

    </div>

    <?php





}


add_action('product_designer_settings_content_help_support', 'product_designer_settings_content_help_support');

if(!function_exists('product_designer_settings_content_help_support')) {
    function product_designer_settings_content_help_support($tab){

        $settings_tabs_field = new settings_tabs_field();


        ?>
        <div class="section">
            <div class="section-title"><?php echo __('Get support', 'post-grid'); ?></div>
            <p class="description section-description"><?php echo __('Use following to get help and support from our expert team.', 'post-grid'); ?></p>

            <?php

            ob_start();
            ?>

            <p><?php echo __('Ask question for free on our forum and get quick reply from our expert team members.', 'post-grid'); ?></p>
            <a class="button" href="https://www.pickplugins.com/create-support-ticket/"><?php echo __('Create support ticket', 'post-grid'); ?></a>

            <p><?php echo __('Read our documentation before asking your question.', 'post-grid'); ?></p>
            <a class="button" href="https://www.pickplugins.com/documentation/product-designer/"><?php echo __('Documentation', 'post-grid'); ?></a>

<!--            <p>--><?php //echo __('Watch video tutorials.', 'post-grid'); ?><!--</p>-->
<!--            <a class="button" href="https://www.youtube.com/playlist?list=PL0QP7T2SN94Yut5Y0MSVg1wqmqWz0UYpt"><i class="fab fa-youtube"></i> --><?php //echo __('All tutorials', 'post-grid'); ?><!--</a>-->

<!--            <ul>-->
<!--                <li><i class="far fa-dot-circle"></i> <a href="https://youtu.be/YVtsIbEb9zs">Latest Version 2.0.46 Overview</a></li>-->
<!---->
<!--            </ul>-->



            <?php

            $html = ob_get_clean();

            $args = array(
                'id'		=> 'get_support',
                //'parent'		=> '',
                'title'		=> __('Ask question','post-grid'),
                'details'	=> '',
                'type'		=> 'custom_html',
                'html'		=> $html,

            );

            $settings_tabs_field->generate_field($args);


            ob_start();
            ?>

            <p class="">We wish your 2 minutes to write your feedback about the <b>Post Grid</b> plugin. give us <span style="color: #ffae19"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></span></p>

            <a target="_blank" href="https://wordpress.org/support/plugin/product-designer/reviews/#new-post" class="button"><i class="fab fa-wordpress"></i> Write a review</a>


            <?php

            $html = ob_get_clean();

            $args = array(
                'id'		=> 'reviews',
                //'parent'		=> '',
                'title'		=> __('Submit reviews','post-grid'),
                'details'	=> '',
                'type'		=> 'custom_html',
                'html'		=> $html,

            );

            $settings_tabs_field->generate_field($args);



            ?>


        </div>
        <?php


    }
}




add_action('product_designer_settings_content_templates', 'product_designer_settings_content_templates');

if(!function_exists('product_designer_settings_content_templates')) {
    function product_designer_settings_content_templates($tab){

        $settings_tabs_field = new settings_tabs_field();

        ?>
        <div class="section">
            <div class="section-title"><?php echo __('Templates', 'post-grid'); ?></div>
            <p class="description section-description"><?php echo __('Choose page templates for various page.', 'post-grid'); ?></p>

            <?php




            ?>


        </div>
        <?php


    }
}




add_action('product_designer_settings_content_buy_pro', 'product_designer_settings_content_buy_pro');

if(!function_exists('product_designer_settings_content_buy_pro')) {
    function product_designer_settings_content_buy_pro($tab){

        $settings_tabs_field = new settings_tabs_field();


        ?>
        <div class="section">
            <div class="section-title"><?php echo __('Get Premium', 'post-grid'); ?></div>
            <p class="description section-description"><?php echo __('Thanks for using our plugin, if you looking for some advance feature please buy premium version.', 'post-grid'); ?></p>

            <?php


            ob_start();
            ?>

            <p><?php echo __('If you love our plugin and want more feature please consider to buy pro version.', 'post-grid'); ?></p>
            <a class="button" href="https://www.pickplugins.com/item/product-designer/?ref=dashobard"><?php echo __('Buy premium', 'post-grid'); ?></a>
            <a class="button" href="http://www.pickplugins.com/demo/product-designer/?ref=dashobard"><?php echo __('See all demo', 'post-grid'); ?></a>

            <h2><?php echo __('See the differences','post-grid'); ?></h2>

            <table class="pro-features">
                <thead>
                <tr>
                    <th class="col-features"><?php echo __('Features','post-grid'); ?></th>
                    <th class="col-free"><?php echo __('Free','post-grid'); ?></th>
                    <th class="col-pro"><?php echo __('Premium','post-grid'); ?></th>
                </tr>
                </thead>

                <tr>
                    <td colspan="3" class="col-features">
                        <h3><?php echo __('Post Query','post-grid'); ?></h3>
                    </td>
                </tr>
                <tr>
                    <td class="col-features"><?php echo __('Lazy load','post-grid'); ?> </td>
                    <td><i class="fas fa-check"></i></td>
                    <td><i class="fas fa-check"></i></td>
                </tr>
                <tr>
                    <td class="col-features"><?php echo __('Lazy load image source','post-grid'); ?> </td>
                    <td><i class="fas fa-check"></i></td>
                    <td><i class="fas fa-check"></i></td>
                </tr>
                
                <tr>
                    <td class="col-features"><?php echo __('Event Organiser','post-grid'); ?> </td>
                    <td><i class="fas fa-times"></i></td>
                    <td><i class="fas fa-check"></i></td>
                </tr>










                <tr>
                    <th class="col-features"><?php echo __('Features','post-grid'); ?></th>
                    <th class="col-free"><?php echo __('Free','post-grid'); ?></th>
                    <th class="col-pro"><?php echo __('Premium','post-grid'); ?></th>
                </tr>
                <tr>
                    <td class="col-features"><?php echo __('Buy now','post-grid'); ?></td>
                    <td> </td>
                    <td><a class="button" href="https://www.pickplugins.com/item/product-designer/?ref=dashobard"><?php echo __('Buy premium', 'post-grid'); ?></a></td>
                </tr>

            </table>



            <?php

            $html = ob_get_clean();

            $args = array(
                'id'		=> 'get_pro',
                'title'		=> __('Get pro version','post-grid'),
                'details'	=> '',
                'type'		=> 'custom_html',
                'html'		=> $html,

            );

            $settings_tabs_field->generate_field($args);


            ?>


        </div>

        <style type="text/css">
            .pro-features{
                margin: 30px 0;
                border-collapse: collapse;
                border: 1px solid #ddd;
            }
            .pro-features th{
                width: 120px;
                background: #ddd;
                padding: 10px;
            }
            .pro-features tr{
            }
            .pro-features td{
                border-bottom: 1px solid #ddd;
                padding: 10px 10px;
                text-align: center;
            }
            .pro-features .col-features{
                width: 230px;
                text-align: left;
            }

            .pro-features .col-free{
            }
            .pro-features .col-pro{
            }

            .pro-features i.fas.fa-check {
                color: #139e3e;
                font-size: 16px;
            }
            .pro-features i.fas.fa-times {
                color: #f00;
                font-size: 17px;
            }
        </style>
        <?php


    }
}









add_action('product_designer_settings_save', 'product_designer_settings_save');

function product_designer_settings_save(){

    $product_designer_settings = isset($_POST['product_designer_settings']) ?  stripslashes_deep($_POST['product_designer_settings']) : array();
    update_option('product_designer_settings', $product_designer_settings);
}



function product_designer_get_pages(){

    $pages_array = array( '' => __( 'Select Page', 'woo-wishlist' ) );

    foreach( get_pages() as $page ):
        $pages_array[ $page->ID ] = $page->post_title;
    endforeach;

    return $pages_array;
}