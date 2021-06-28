<?php
if ( ! defined('ABSPATH')) exit;  // if direct access

add_action('product_designer_settings_content_general', 'product_designer_settings_content_general', 10);

function product_designer_settings_content_general(){
    $settings_tabs_field = new settings_tabs_field();

    $product_designer_settings = get_option('product_designer_settings');

    $font_aw_version = isset($product_designer_settings['font_aw_version']) ? $product_designer_settings['font_aw_version'] : 'none';
    $designer_page_id = isset($product_designer_settings['designer_page_id']) ? $product_designer_settings['designer_page_id'] : '';
    $menu_position = isset($product_designer_settings['menu_position']) ? $product_designer_settings['menu_position'] : '';
    $posts_per_page = isset($product_designer_settings['posts_per_page']) ? $product_designer_settings['posts_per_page'] : '';

    $customize_button_text = isset($product_designer_settings['customize_button']['text']) ? $product_designer_settings['customize_button']['text'] : '';
    $customize_button_bg_color = isset($product_designer_settings['customize_button']['bg_color']) ? $product_designer_settings['customize_button']['bg_color'] : '';

    $clipart_width = isset($product_designer_settings['clipart_width']) ? $product_designer_settings['clipart_width'] : '';
    $clipart_bg_color = isset($product_designer_settings['clipart_bg_color']) ? $product_designer_settings['clipart_bg_color'] : '';

    //echo '<pre>'.var_export($product_designer_settings, true).'</pre>';

    ?>
    <div class="section">
        <div class="section-title"><?php echo __('General', 'product-designer'); ?></div>
        <p class="description section-description"><?php echo __('Choose some general options.', 'product-designer'); ?></p>

        <?php

        $args = array(
            'id'		=> 'designer_page_id',
            'parent'		=> 'product_designer_settings',
            'title'		=> __('Designer page','product-designer'),
            'details'	=> __('Display product desginer, use shortcode <code>[product_designer]</code> on that page.','product-designer'),
            'type'		=> 'select',
            'value'		=> $designer_page_id,
            'default'		=> '',
            'args'		=> product_designer_get_pages(),
        );

        $settings_tabs_field->generate_field($args);

        $args = array(
            'id'		=> 'font_aw_version',
            'parent'		=> 'product_designer_settings',
            'title'		=> __('Font-awesome version','product-designer'),
            'details'	=> __('Choose font awesome version you want to load.','product-designer'),
            'type'		=> 'select',
            'value'		=> $font_aw_version,
            'default'		=> '',
            'args'		=> array('v_5'=>__('Version 5+','product-designer'), 'v_4'=>__('Version 4+','product-designer'), 'none'=>__('None','product-designer')  ),
        );

        $settings_tabs_field->generate_field($args);


        $args = array(
            'id'		=> 'posts_per_page',
            'parent'		=> 'product_designer_settings',
            'title'		=> __('Post per page','product-designer'),
            'details'	=> __('Set custom number of posts per page, ex: 10','product-designer'),
            'type'		=> 'text',
            'value'		=> $posts_per_page,
            'default'		=> '',
            'placeholder'		=> '',

        );

        $settings_tabs_field->generate_field($args);


        $args = array(
            'id'		=> 'clipart_width',
            'parent'		=> 'product_designer_settings',
            'title'		=> __('Clipart width','product-designer'),
            'details'	=> __('Set custom width for clipart list item. ex: 80px','product-designer'),
            'type'		=> 'text',
            'value'		=> $clipart_width,
            'default'		=> '',
            'placeholder'		=> '56px',

        );

        $settings_tabs_field->generate_field($args);

        $args = array(
            'id'		=> 'clipart_bg_color',
            'parent'		=> 'product_designer_settings',
            'title'		=> __('Clipart background color','product-designer'),
            'details'	=> __('Set custom background color for clipart list item. ex: 80px','product-designer'),
            'type'		=> 'colorpicker',
            'value'		=> $clipart_bg_color,
            'default'		=> '',
            'placeholder'		=> '',

        );

        $settings_tabs_field->generate_field($args);


        $args = array(
            'id'		=> 'menu_position',
            'parent'		=> 'product_designer_settings',
            'title'		=> __('Menu position?','product-designer'),
            'details'	=> __('Choose menu position','product-designer'),
            'type'		=> 'select',
            'value'		=> $menu_position,
            'default'		=> '',
            'args'		=> array('left'=>__('Left','product-designer'), 'right'=>__('Right','product-designer')  ),
        );

        $settings_tabs_field->generate_field($args);


        ?>
        <div class="section-title"><?php echo __('Customize button', 'product-designer'); ?></div>
        <p class="description section-description"><?php echo __('Choose options for customize button.', 'product-designer'); ?></p>

        <?php

        $args = array(
            'id'		=> 'text',
            'parent'		=> 'product_designer_settings[customize_button]',
            'title'		=> __('Customize button text','product-designer'),
            'details'	=> __('Custom text for customize button','product-designer'),
            'type'		=> 'text',
            'value'		=> $customize_button_text,
            'default'		=> '',
            'placeholder'		=> 'Customize',

        );

        $settings_tabs_field->generate_field($args);


        $args = array(
            'id'		=> 'bg_color',
            'parent'		=> 'product_designer_settings[customize_button]',
            'title'		=> __('Background color','product-designer'),
            'details'	=> __('Custom background color for customize button','product-designer'),
            'type'		=> 'colorpicker',
            'value'		=> $customize_button_bg_color,
            'default'		=> '',
            'placeholder'		=> '',

        );

        $settings_tabs_field->generate_field($args);

        ?>

    </div>

    <?php





}




add_action('product_designer_settings_content_editor', 'product_designer_settings_content_editor');

if(!function_exists('product_designer_settings_content_editor')) {
    function product_designer_settings_content_editor($tab){

        $settings_tabs_field = new settings_tabs_field();
        $product_designer_settings = get_option('product_designer_settings');

        $hide_sections = isset($product_designer_settings['hide_sections']) ? $product_designer_settings['hide_sections'] : array();
        $editor_bg_color = isset($product_designer_settings['editor_bg_color']) ? $product_designer_settings['editor_bg_color'] : '#314861';
        $section_bg_color = isset($product_designer_settings['section_bg_color']) ? $product_designer_settings['section_bg_color'] : '#3c526b';
        $section_hover_bg_color = isset($product_designer_settings['section_hover_bg_color']) ? $product_designer_settings['section_hover_bg_color'] : '#314861';

        $section_title_bg_color = isset($product_designer_settings['section_title_bg_color']) ? $product_designer_settings['section_title_bg_color'] : '#3a5673';



        $sections = array('editor_action'=>__('Editor action','product-designer'), 'layers'=>__('Layers','product-designer'), 'keyboard_shortcuts'=>__('Keyboard shortcuts','product-designer'), 'product_sides'=>__('Product sides','product-designer'), 'clipart_assets'=>__('Clipart assets','product-designer'),'edit_image'=>__('Image actions','product-designer'), 'clipart'=>__('Clipart','product-designer'),   'text'=>__('Text','product-designer'), 'edit_text'=>__('Edit text','product-designer'),  );

        $sections = apply_filters('product_designer_editor_sections', $sections);


        ?>
        <div class="section">
            <div class="section-title"><?php echo __('Editor setup', 'product-designer'); ?></div>
            <p class="description section-description"><?php echo __('Setup editor options', 'product-designer'); ?></p>

            <?php

            $args = array(
                'id'		=> 'hide_sections',
                'parent'		=> 'product_designer_settings',
                'title'		=> __('Hide sections','product-designer'),
                'details'	=> __('Choose section to hide','product-designer'),
                'type'		=> 'checkbox',
                'value'		=> $hide_sections,
                'style'		=> array('inline' => false),

                'default'		=> array(),
                'args'		=> $sections,
            );

            $settings_tabs_field->generate_field($args);




            $args = array(
                'id'		=> 'editor_bg_color',
                'parent'		=> 'product_designer_settings',
                'title'		=> __('Background color','product-designer'),
                'details'	=> __('Custom background color for customize button','product-designer'),
                'type'		=> 'colorpicker',
                'value'		=> $editor_bg_color,
                'default'		=> '',
                'placeholder'		=> '',

            );

            $settings_tabs_field->generate_field($args);

            $args = array(
                'id'		=> 'section_bg_color',
                'parent'		=> 'product_designer_settings',
                'title'		=> __('Section background color','product-designer'),
                'details'	=> __('Set section background color','product-designer'),
                'type'		=> 'colorpicker',
                'value'		=> $section_bg_color,
                'default'		=> '',
                'placeholder'		=> '',

            );

            $settings_tabs_field->generate_field($args);


            $args = array(
                'id'		=> 'section_hover_bg_color',
                'parent'		=> 'product_designer_settings',
                'title'		=> __('Section hover background color','product-designer'),
                'details'	=> __('Set section hover background color','product-designer'),
                'type'		=> 'colorpicker',
                'value'		=> $section_hover_bg_color,
                'default'		=> '',
                'placeholder'		=> '',

            );

            $settings_tabs_field->generate_field($args);

            $args = array(
                'id'		=> 'section_title_bg_color',
                'parent'		=> 'product_designer_settings',
                'title'		=> __('Section title background color','product-designer'),
                'details'	=> __('Set section title background color','product-designer'),
                'type'		=> 'colorpicker',
                'value'		=> $section_title_bg_color,
                'default'		=> '',
                'placeholder'		=> '',

            );

            $settings_tabs_field->generate_field($args);


            ?>


        </div>
        <?php

    }
}








add_action('product_designer_settings_content_tour_guide', 'product_designer_settings_content_tour_guide');

if(!function_exists('product_designer_settings_content_tour_guide')) {
    function product_designer_settings_content_tour_guide($tab){

        $settings_tabs_field = new settings_tabs_field();
        $product_designer_settings = get_option('product_designer_settings');

        $enable_guide = isset($product_designer_settings['enable_guide']) ? $product_designer_settings['enable_guide'] : '';


        ?>
        <div class="section">
            <div class="section-title"><?php echo __('Tour guide setup', 'product-designer'); ?></div>
            <p class="description section-description"><?php echo __('Setup tour guide options', 'product-designer'); ?></p>

            <?php

            $args = array(
                'id'		=> 'enable_guide',
                'parent'		=> 'product_designer_settings',
                'title'		=> __('Enable guide','product-designer'),
                'details'	=> __('Enable tour guide on page load','product-designer'),
                'type'		=> 'select',
                'value'		=> $enable_guide,
                'default'		=> '',
                'args'		=> array('yes'=>__('Yes','product-designer'), 'no'=>__('No','product-designer')  ),
            );

            $settings_tabs_field->generate_field($args);











            ?>


        </div>
        <?php









    }
}




add_action('product_designer_settings_content_help_support', 'product_designer_settings_content_help_support');

if(!function_exists('product_designer_settings_content_help_support')) {
    function product_designer_settings_content_help_support($tab){

        $settings_tabs_field = new settings_tabs_field();


        ?>
        <div class="section">
            <div class="section-title"><?php echo __('Get support', 'product-designer'); ?></div>
            <p class="description section-description"><?php echo __('Use following to get help and support from our expert team.', 'product-designer'); ?></p>

            <?php

            ob_start();
            ?>

            <p><?php echo __('Ask question for free on our forum and get quick reply from our expert team members.', 'product-designer'); ?></p>
            <a class="button" href="https://www.pickplugins.com/create-support-ticket/"><?php echo __('Create support ticket', 'product-designer'); ?></a>

            <p><?php echo __('Read our documentation before asking your question.', 'product-designer'); ?></p>
            <a class="button" href="https://www.pickplugins.com/documentation/product-designer/"><?php echo __('Documentation', 'product-designer'); ?></a>

<!--            <p>--><?php //echo __('Watch video tutorials.', 'product-designer'); ?><!--</p>-->
<!--            <a class="button" href="https://www.youtube.com/playlist?list=PL0QP7T2SN94Yut5Y0MSVg1wqmqWz0UYpt"><i class="fab fa-youtube"></i> --><?php //echo __('All tutorials', 'product-designer'); ?><!--</a>-->

<!--            <ul>-->
<!--                <li><i class="far fa-dot-circle"></i> <a href="https://youtu.be/YVtsIbEb9zs">Latest Version 2.0.46 Overview</a></li>-->
<!---->
<!--            </ul>-->



            <?php

            $html = ob_get_clean();

            $args = array(
                'id'		=> 'get_support',
                //'parent'		=> '',
                'title'		=> __('Ask question','product-designer'),
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
                'title'		=> __('Submit reviews','product-designer'),
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
            <div class="section-title"><?php echo __('Templates', 'product-designer'); ?></div>
            <p class="description section-description"><?php echo __('Choose page templates for various page.', 'product-designer'); ?></p>

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
            <div class="section-title"><?php echo __('Get Premium', 'product-designer'); ?></div>
            <p class="description section-description"><?php echo __('Thanks for using our plugin, if you looking for some advance feature please buy premium version.', 'product-designer'); ?></p>

            <?php


            ob_start();
            ?>

            <p><?php echo __('If you love our plugin and want more feature please consider to buy pro version.', 'product-designer'); ?></p>
            <a class="button" href="https://www.pickplugins.com/item/product-designer/?ref=dashobard"><?php echo __('Buy premium', 'product-designer'); ?></a>
            <a class="button" href="https://www.pickplugins.com/demo/product-designer/?ref=dashobard"><?php echo __('See all demo', 'product-designer'); ?></a>

            <h2><?php echo __('See the differences','product-designer'); ?></h2>

            <table class="pro-features">
                <thead>
                <tr>
                    <th class="col-features"><?php echo __('Features','product-designer'); ?></th>
                    <th class="col-free"><?php echo __('Free','product-designer'); ?></th>
                    <th class="col-pro"><?php echo __('Premium','product-designer'); ?></th>
                </tr>
                </thead>

                <tr>
                    <td colspan="3" class="col-features">
                        <h3><?php echo __('Canvas Options','product-designer'); ?></h3>
                    </td>
                </tr>
                <tr>
                    <td class="col-features"><?php echo __('Canvas width','product-designer'); ?> </td>
                    <td><i class="fas fa-check"></i></td>
                    <td><i class="fas fa-check"></i></td>
                </tr>

                <tr>
                    <td class="col-features"><?php echo __('Canvas height','product-designer'); ?> </td>
                    <td><i class="fas fa-check"></i></td>
                    <td><i class="fas fa-check"></i></td>
                </tr>

                <tr>
                    <td class="col-features"><?php echo __('Output file format','product-designer'); ?> </td>
                    <td><i class="fas fa-check"></i></td>
                    <td><i class="fas fa-check"></i></td>
                </tr>

                <tr>
                    <td class="col-features"><?php echo __('Design preview','product-designer'); ?> </td>
                    <td><i class="fas fa-check"></i></td>
                    <td><i class="fas fa-check"></i></td>
                </tr>

                <tr>
                    <td class="col-features"><?php echo __('Preview file format','product-designer'); ?> </td>
                    <td><i class="fas fa-check"></i></td>
                    <td><i class="fas fa-check"></i></td>
                </tr>



                <tr>
                    <td class="col-features"><?php echo __('Download preview','product-designer'); ?> </td>
                    <td><i class="fas fa-times"></i></td>
                    <td><i class="fas fa-check"></i></td>
                </tr>

                <tr>
                    <td class="col-features"><?php echo __('Download file format','product-designer'); ?> </td>
                    <td><i class="fas fa-times"></i></td>
                    <td><i class="fas fa-check"></i></td>
                </tr>


                <tr>
                    <td class="col-features"><?php echo __('Product sides','product-designer'); ?> </td>
                    <td><i class="fas fa-check"></i></td>
                    <td><i class="fas fa-check"></i></td>
                </tr>

                <tr>
                    <td class="col-features"><?php echo __('Pre-saved templates','product-designer'); ?> </td>
                    <td><i class="fas fa-times"></i></td>
                    <td><i class="fas fa-check"></i></td>
                </tr>


                <tr>
                    <td class="col-features"><?php echo __('Unlimited Clip-art','product-designer'); ?> </td>
                    <td><i class="fas fa-check"></i></td>
                    <td><i class="fas fa-check"></i></td>
                </tr>

                <tr>
                    <td class="col-features"><?php echo __('Clip-art categories.','product-designer'); ?> </td>
                    <td><i class="fas fa-check"></i></td>
                    <td><i class="fas fa-check"></i></td>
                </tr>


                <tr>
                    <td class="col-features"><?php echo __('Custom Clip-art upload','product-designer'); ?> </td>
                    <td><i class="fas fa-times"></i></td>
                    <td><i class="fas fa-check"></i></td>
                </tr>


                <tr>
                    <td class="col-features"><?php echo __('Custom Clip-art price','product-designer'); ?> </td>
                    <td><i class="fas fa-times"></i></td>
                    <td><i class="fas fa-check"></i></td>
                </tr>

                <tr>
                    <td class="col-features"><?php echo __('Text art.','product-designer'); ?> </td>
                    <td><i class="fas fa-check"></i></td>
                    <td><i class="fas fa-check"></i></td>
                </tr>

                <tr>
                    <td class="col-features"><?php echo __('Curve text.','product-designer'); ?> </td>
                    <td><i class="fas fa-times"></i></td>
                    <td><i class="fas fa-check"></i></td>
                </tr>

                <tr>
                    <td class="col-features"><?php echo __('Quotes text.','product-designer'); ?> </td>
                    <td><i class="fas fa-times"></i></td>
                    <td><i class="fas fa-check"></i></td>
                </tr>

                <tr>
                    <td class="col-features"><?php echo __('Bar code','product-designer'); ?> </td>
                    <td><i class="fas fa-times"></i></td>
                    <td><i class="fas fa-check"></i></td>
                </tr>

                <tr>
                    <td class="col-features"><?php echo __('QR Code','product-designer'); ?> </td>
                    <td><i class="fas fa-times"></i></td>
                    <td><i class="fas fa-check"></i></td>
                </tr>

                <tr>
                    <td class="col-features"><?php echo __('Custom shapes.','product-designer'); ?> </td>
                    <td><i class="fas fa-check"></i></td>
                    <td><i class="fas fa-check"></i></td>
                </tr>


                <tr>
                    <td class="col-features"><?php echo __('Google Fonts.','product-designer'); ?> </td>
                    <td><i class="fas fa-times"></i></td>
                    <td><i class="fas fa-check"></i></td>
                </tr>

                <tr>
                    <td class="col-features"><?php echo __('Custom Fonts.','product-designer'); ?> </td>
                    <td><i class="fas fa-times"></i></td>
                    <td><i class="fas fa-check"></i></td>
                </tr>
                <tr>
                    <td class="col-features"><?php echo __('Menu position.','product-designer'); ?> </td>
                    <td><i class="fas fa-check"></i></td>
                    <td><i class="fas fa-check"></i></td>
                </tr>





                <tr>
                    <th class="col-features"><?php echo __('Features','product-designer'); ?></th>
                    <th class="col-free"><?php echo __('Free','product-designer'); ?></th>
                    <th class="col-pro"><?php echo __('Premium','product-designer'); ?></th>
                </tr>
                <tr>
                    <td class="col-features"><?php echo __('Buy now','product-designer'); ?></td>
                    <td> </td>
                    <td><a class="button" href="https://www.pickplugins.com/item/product-designer/?ref=dashobard"><?php echo __('Buy premium', 'product-designer'); ?></a></td>
                </tr>

            </table>



            <?php

            $html = ob_get_clean();

            $args = array(
                'id'		=> 'get_pro',
                'title'		=> __('Get pro version','product-designer'),
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

    $product_designer_settings = isset($_POST['product_designer_settings']) ?  product_designer_recursive_sanitize_arr($_POST['product_designer_settings']) : array();
    update_option('product_designer_settings', $product_designer_settings);
}



function product_designer_get_pages(){

    $pages_array = array( '' => __( 'Select Page', 'woo-wishlist' ) );

    foreach( get_pages() as $page ):
        $pages_array[ $page->ID ] = $page->post_title;
    endforeach;

    return $pages_array;
}