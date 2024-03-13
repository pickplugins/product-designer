<?php
if ( ! defined('ABSPATH')) exit;  // if direct access






add_action('product_designer_editor', 'product_designer_editor_notice', 0);

function product_designer_editor_notice($atts){

    ?>
    <div class="product-designer-notice" id="product-designer-notice">
        <div class="notices">
        </div>
    </div>
    <?php

}








add_action('product_designer_editor', 'product_designer_editor_panel', 15);

function product_designer_editor_panel($atts){

    ?>
    <div class="menu">
        <?php

        do_action('product_designer_panel', $atts);

        ?>
    </div>
    <?php


}


add_action('product_designer_panel', 'product_designer_panel_main_tabs', 10);

function product_designer_panel_main_tabs($atts){

    ?>
    <div class="editor-tabs">
        <ul class="editor-tab-navs">
            <li class="nav tab-nav" data-id="0"><?php echo __('Editor','product-designer'); ?></li>
            <li class="nav tab-nav" data-id="1"><?php echo __('Assets','product-designer'); ?></li>
        </ul>

        <div class="editor-tab-content data-id-0">
            <?php
            do_action('product_designer_panel_tab_content_editor', $atts);
            ?>
        </div>
        <div class="editor-tab-content data-id-1">
            <?php
            do_action('product_designer_panel_tab_content_assets', $atts);
            ?>
        </div>


    </div>
    <?php

}







add_action('product_designer_panel_tab_content_assets', 'product_designer_side_list', 5);

function product_designer_side_list($atts){

    $side_data = isset($atts['side_data']) ? $atts['side_data'] : '';
    $icons = isset($atts['icons']) ? $atts['icons'] : '';
    $cube = isset($icons['cube']) ? $icons['cube'] : '';
    $check_circle = isset($icons['check_circle']) ? $icons['check_circle'] : '';

    $settings = isset($atts['settings']) ? $atts['settings'] : array();
    $hide_sections = isset($settings['hide_sections']) ? $settings['hide_sections'] : array();

    if(in_array('product_sides', $hide_sections )) return;


   ?>
    <div class="side  pd-panel-section accordions  pd-guide-1" title="Sides">
        <div class="panel-section-title "><?php echo sprintf(__('%s Sides','product-designer'), $cube); ?></div>
        <div class="pd-panel-section-inner">
            <ul class="side-list">
                <?php

                if(!empty($side_data)){
                    foreach($side_data as $id=>$side){

                        $name = isset($side['name']) ? $side['name'] : '';
                        $icon = isset($side['icon']) ? $side['icon'] : '';

                        if(!empty($icon)){
                            ?>
                            <li side_id="<?php echo $id; ?>" data-side_name="<?php echo $name; ?>" >
                                <img src="<?php echo $icon; ?>" />
                                <span class="name"><?php echo $name; ?></span>

                            </li>
                            <?php
                        }
                    }
                }
                else{
                    ?>
                    <span>
                        <?php
                        __('Not available.', "product-designer")
                        ?>
                    </span>
                    <?php

                }

                ?>
            </ul>
        </div>
    </div>
    <?php

}





add_action('product_designer_panel_tab_content_assets', 'product_designer_panel_clipart', 10);

function product_designer_panel_clipart($atts){

    $icons = isset($atts['icons']) ? $atts['icons'] : '';
    $file_image = isset($icons['file_image']) ? $icons['file_image'] : '';

    $settings = isset($atts['settings']) ? $atts['settings'] : array();
    $hide_sections = isset($settings['hide_sections']) ? $settings['hide_sections'] : array();

    if(in_array('clipart_assets', $hide_sections )) return;

    $img_types = array();


    if(!in_array('clipart', $hide_sections )){
        $img_types['clipart'] = __('Clipart','product-designer');
    }


    $img_types = apply_filters('product_designer_image_types', $img_types, $atts);

    ?>
    <div class="clipart accordions pd-panel-section pd-guide-2" title="<?php echo __('Clip Art', "product-designer"); ?>">
        <div class="panel-section-title"><?php echo sprintf(__('%s Clipart & Images','product-designer'), $file_image); ?></div>
        <div class="pd-panel-section-inner">
            <div class="tabs">
                <ul class="navs">
                    <?php

                    if(!empty($img_types))
                    foreach ($img_types as $typeIndex => $type):
                        ?>
                        <li class="nav"><a href="#tabs-<?php echo $typeIndex; ?>"><?php echo $type; ?></a></li>
                        <?php
                    endforeach;
                    ?>
                </ul>
                <?php
                if(!empty($img_types))
                foreach ($img_types as $typeIndex => $type):
                    ?>
                    <div class="nav-content" id="tabs-<?php echo $typeIndex; ?>">
                        <?php
                        do_action('product_designer_image_type_content_'.$typeIndex, $atts);
                        ?>
                    </div>
                    <?php
                endforeach;
                ?>
            </div>
        </div>
    </div>
    <?php
}




add_action('product_designer_image_type_content_clipart', 'product_designer_image_type_content_clipart', 20);

function product_designer_image_type_content_clipart($atts){

    $settings = isset($atts['settings']) ? $atts['settings'] : array();
    $posts_per_page = isset($settings['posts_per_page']) ? $settings['posts_per_page'] : 10;

    $icons = isset($atts['icons']) ? $atts['icons'] : '';
    $spinner = isset($icons['spinner']) ? $icons['spinner'] : '';



    ?>
    <select title="<?php echo __('Categories', "product-designer"); ?>" id="clipart-cat">
        <?php
        $args = array(
            'orderby' => 'name',
            'order' => 'ASC',
            'taxonomy' => 'clipart_cat',
        );
        ?>
        <option value="all"><?php echo __('All', "product-designer"); ?></option>
        <?php
        $categories = get_categories($args);

        if(!empty($categories))
        foreach($categories as $category){
            ?>
            <option value='<?php echo $category->cat_ID; ?>'><?php echo $category->cat_name; ?></option>
            <?php
        }
        ?>
    </select>

    <span class="clipart-loading" style="display: none; color:#fff;"><?php echo $spinner; ?></span>
    <div class="clipart-list">
        <?php
        $args = array(
            'post_type'=>'clipart',
            'posts_per_page'=> $posts_per_page,
        );

        $clipart_query = new WP_Query($args);

        if ( $clipart_query->have_posts() ) :
            while ( $clipart_query->have_posts() ) : $clipart_query->the_post();

                $clipart_id = get_the_ID();
                $clipart_thumb_id = get_post_meta(get_the_ID(),'clipart_thumb_id', true);
                $clipart_price = get_post_meta(get_the_ID(),'clipart_price', true);

                $clipart_url = wp_get_attachment_image_src($clipart_thumb_id, 'full' );
                $clipart_url = isset($clipart_url['0']) ? $clipart_url['0']  : '';

                $thumb = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), 'full' );
                $thumb_url = isset($thumb['0']) ? $thumb['0']  : '';


                $clipart_url = !empty($clipart_url) ? $clipart_url : $thumb_url;

                if(!empty($clipart_url)){
                    ?>
                    <img data-attachment-id="<?php echo $clipart_id; ?>" data-price="<?php echo $clipart_price; ?>" class="" title="<?php echo get_the_title(); ?>" src="<?php echo esc_url_raw($clipart_url); ?>" />
                    <?php
                }
            endwhile;

            wp_reset_query();
        endif;
        ?>


    </div>
    <div class="clipart-pagination">
        <?php
        $paged = 1;
        $big = 999999999; // need an unlikely integer

        echo paginate_links( array(
            'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
            'format' => '?paged=%#%',
            'current' => max( 1, $paged ),
            'prev_text'          => '',
            'next_text'          => '',
            'total' => $clipart_query->max_num_pages
        ) );
        ?>
    </div>
    <?php
}



add_action('product_designer_panel_tab_content_assets', 'product_designer_panel_text', 25);

function product_designer_panel_text($atts){

    $icons = isset($atts['icons']) ? $atts['icons'] : '';
    $file_word = isset($icons['file_word']) ? $icons['file_word'] : '';

    $settings = isset($atts['settings']) ? $atts['settings'] : array();
    $hide_sections = isset($settings['hide_sections']) ? $settings['hide_sections'] : array();

    if(in_array('text_quotes', $hide_sections )) return;


    $settings = isset($atts['settings']) ? $atts['settings'] : array();
    $hide_sections = isset($settings['hide_sections']) ? $settings['hide_sections'] : array();


    $text_types = array();

    if(!in_array('text', $hide_sections )) {
        $text_types['text'] = __('Text','product-designer');
    }

    $text_types = apply_filters('product_designer_text_types', $text_types, $atts);

    ?>
    <div class="text pd-panel-section accordions pd-guide-3" title="<?php echo __('Text Art', 'product-designer'); ?>">
        <div class="panel-section-title"><?php echo sprintf(__('%s Text & Quotes','product-designer'), $file_word); ?></div>
        <div class="pd-panel-section-inner">
            <div class="tabs">
                <ul class="navs">
                    <?php

                    if(!empty($text_types))
                    foreach ($text_types as $typeIndex => $type):
                        ?>
                        <li class="nav"><a href="#tabs-<?php echo $typeIndex; ?>"><?php echo $type; ?></a></li>
                        <?php
                    endforeach;
                    ?>
                </ul>
                <?php

                if(!empty($text_types))
                foreach ($text_types as $typeIndex => $type):
                    ?>
                    <div class="nav-content" id="tabs-<?php echo $typeIndex; ?>">
                        <?php
                        do_action('product_designer_text_type_content_'.$typeIndex, $atts);
                        ?>
                    </div>
                    <?php
                endforeach;
                ?>
            </div>
        </div>
    </div>
    <?php

}

add_action('product_designer_text_type_content_text', 'product_designer_text_type_content_text', 15);

function product_designer_text_type_content_text(){

    ?>
    <textarea placeholder="<?php echo __('Text here...', "product-designer"); ?>" class="input-text asset-text"></textarea>
    <div class="add-text"><?php echo __('Add Text', "product-designer"); ?></div>

    <?php
}



add_action('product_designer_panel_tab_content_assets', 'product_designer_panel_shapes', 30);

function product_designer_panel_shapes($atts){


    $settings = isset($atts['settings']) ? $atts['settings'] : array();
    $posts_per_page = isset($settings['posts_per_page']) ? $settings['posts_per_page'] : 10;

    $icons = isset($atts['icons']) ? $atts['icons'] : '';
    $spinner = isset($icons['spinner']) ? $icons['spinner'] : '';
    $shapes = isset($icons['shapes']) ? $icons['shapes'] : '';

    $hide_sections = isset($settings['hide_sections']) ? $settings['hide_sections'] : array();

    if(in_array('shapes', $hide_sections )) return;


    ?>
    <div class="shapes pd-panel-section accordions pd-guide-4" title="<?php echo __('Shapes', "product-designer"); ?>">
        <div class="panel-section-title"><?php echo sprintf(__('%s Shapes','product-designer'), $shapes); ?></div>
        <div class="pd-panel-section-inner">

            <?php

            do_action('product_designer_panel_shapes_content', $atts );

            ?>


            <select title="<?php echo __('Categories', "product-designer"); ?>" id="shape-cat">
                <?php
                $args = array(
                    'orderby' => 'name',
                    'order' => 'ASC',
                    'taxonomy' => 'shape_cat',
                );
                ?>
                <option value="all"><?php echo __('All', "product-designer"); ?></option>
                <?php
                $categories = get_categories($args);

                if(!empty($categories))
                    foreach($categories as $category){
                        ?>
                        <option value='<?php echo $category->cat_ID; ?>'><?php echo $category->cat_name; ?></option>
                        <?php
                    }
                ?>
            </select>

            <span class="shape-loading" style="display: none; color:#fff;"><?php echo $spinner; ?></span>
            <div class="shape-list">
                <?php
                $args = array(
                    'post_type'=>'shape',
                    'posts_per_page'=> $posts_per_page,
                );

                $clipart_query = new WP_Query($args);

                if ( $clipart_query->have_posts() ) :
                    while ( $clipart_query->have_posts() ) : $clipart_query->the_post();

                        $clipart_id = get_the_ID();

                        $clipart_thumb_id = get_post_meta(get_the_ID(),'shape_thumb_id', true);
                        $clipart_price = get_post_meta(get_the_ID(),'shape_price', true);

                        $clipart_url = wp_get_attachment_image_src($clipart_thumb_id, 'full' );
                        $clipart_url = isset($clipart_url['0']) ? $clipart_url['0']  : '';

                        $thumb = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), 'full' );
                        $thumb_url = isset($thumb['0']) ? $thumb['0']  : '';


                        $clipart_url = !empty($clipart_url) ? $clipart_url : $thumb_url;

                        if(!empty($clipart_url)){
                            ?>

                                <img data-attachment-id="<?php echo $clipart_id; ?>" data-price="<?php echo $clipart_price; ?>" class="add-shape" title="<?php echo get_the_title(); ?>" src="<?php echo esc_url_raw($clipart_url); ?>" />



                            <?php
                        }
                    endwhile;

                    wp_reset_query();
                endif;
                ?>


            </div>
            <div class="shape-pagination">
                <?php
                $paged = 1;
                $big = 999999999; // need an unlikely integer

                echo paginate_links( array(
                    'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                    'format' => '?paged=%#%',
                    'current' => max( 1, $paged ),
                    'prev_text'          => '',
                    'next_text'          => '',
                    'total' => $clipart_query->max_num_pages
                ) );
                ?>
            </div>


        </div>

    </div>

    <?php

}






//add_action('product_designer_panel_tab_content_assets', 'product_designer_panel_images', 15);

function product_designer_panel_images($atts){


    $settings = isset($atts['settings']) ? $atts['settings'] : array();
    $posts_per_page = isset($settings['posts_per_page']) ? $settings['posts_per_page'] : 10;

    $icons = isset($atts['icons']) ? $atts['icons'] : '';
    $spinner = isset($icons['spinner']) ? $icons['spinner'] : '';
    $shapes = isset($icons['shapes']) ? $icons['shapes'] : '';
    $file_image = isset($icons['file_image']) ? $icons['file_image'] : '';

    $hide_sections = isset($settings['hide_sections']) ? $settings['hide_sections'] : array();

    if(in_array('shapes', $hide_sections )) return;


    ?>
    <div class="shapes pd-panel-section accordions " title="<?php echo __('Images', "product-designer"); ?>">
        <div class="panel-section-title"><?php echo sprintf(__('%s Images','product-designer'), $file_image); ?></div>
        <div class="pd-panel-section-inner">

            <?php

            do_action('product_designer_panel_images_content', $atts);

            ?>

        </div>

    </div>

    <?php

}



//add_action('product_designer_panel_images_content', 'product_designer_panel_images_content_unsplash', 15);

function product_designer_panel_images_content_unsplash($atts){


    $settings = isset($atts['settings']) ? $atts['settings'] : array();
    $posts_per_page = isset($settings['posts_per_page']) ? $settings['posts_per_page'] : 10;

    $icons = isset($atts['icons']) ? $atts['icons'] : '';
    $icon_unsplash = isset($icons['unsplash']) ? $icons['unsplash'] : '';



    ?>
    <div class="pd-panel-section accordions" title="<?php echo __('Images', "product-designer"); ?>">
        <div class="panel-section-title"><?php echo sprintf(__('%s Unsplash ','product-designer'), $icon_unsplash); ?></div>
        <div class="pd-panel-section-inner">

            Hello

        </div>

    </div>

    <?php

}








add_action('product_designer_panel_tab_content_editor', 'product_designer_panel_tab_content_editor', 20);

function product_designer_panel_tab_content_editor($atts){

    ?>
    <div class="editing">

        <?php

        do_action('product_designer_tools', $atts);

        ?>
    </div>
    <?php

}



add_action('product_designer_tools', 'product_designer_tools_editor_actions', 5);

function product_designer_tools_editor_actions($atts){

    $settings = isset($atts['settings']) ? $atts['settings'] : array();
    $icons = isset($atts['icons']) ? $atts['icons'] : '';
    $hide_sections = isset($settings['hide_sections']) ? $settings['hide_sections'] : array();


    if(in_array('editor_action', $hide_sections )) return;

    $canvas = isset($atts['canvas']) ? $atts['canvas'] : array();
    $enable_download = !empty($canvas['download']['enable']) ? $canvas['download']['enable'] : 'no';
    $enable_preview = !empty($canvas['preview']['enable']) ? $canvas['preview']['enable'] : 'no';

    $icon_grid = isset($icons['grid']) ? $icons['grid'] : '';
    $icon_eraser = isset($icons['eraser']) ? $icons['eraser'] : '';
    $icon_trash = isset($icons['trash']) ? $icons['trash'] : '';
    $icon_clone = isset($icons['clone']) ? $icons['clone'] : '';
    $icon_pencil = isset($icons['pencil']) ? $icons['pencil'] : '';
    $icon_zoomin = isset($icons['zoomin']) ? $icons['zoomin'] : '';
    $icon_zoomout = isset($icons['zoomout']) ? $icons['zoomout'] : '';
    $icon_hand = isset($icons['hand']) ? $icons['hand'] : '';
    $icon_undo = isset($icons['undo']) ? $icons['undo'] : '';
    $icon_redo = isset($icons['redo']) ? $icons['redo'] : '';
    $icon_rotation = isset($icons['rotation']) ? $icons['rotation'] : '';
    $icon_arrows_h = isset($icons['arrows_h']) ? $icons['arrows_h'] : '';
    $icon_arrows_v = isset($icons['arrows_v']) ? $icons['arrows_v'] : '';
    $icon_expand = isset($icons['expand']) ? $icons['expand'] : '';
    $icon_eye = isset($icons['eye']) ? $icons['eye'] : '';
    $icon_download = isset($icons['download']) ? $icons['download'] : '';
    $icon_object_group = isset($icons['object_group']) ? $icons['object_group'] : '';
    $icon_object_ungroup = isset($icons['object_ungroup']) ? $icons['object_ungroup'] : '';


    //var_dump($enable_preview);

    ?>
    <div class="section-editor-action pd-panel-section pd-guide-5">
        <div class="panel-section-title"><?php echo __('Editor Actions', 'product-designer'); ?></div>
        <div class="pd-panel-section-inner">
            <span class="pack-button hint--top" id="editor-show-grid" aria-label="<?php echo __('Show grid', 'product-designer'); ?>"><?php echo $icon_grid; ?></span>
            <span class="pack-button hint--top" id="editor-clear" aria-label="<?php echo __('Clear All', 'product-designer'); ?>"><?php echo $icon_eraser; ?></span>
            <span class="pack-button hint--top" id="editor-delete-item" aria-label="<?php echo __('Delete', 'product-designer'); ?>"><?php echo $icon_trash; ?></span>
            <span class="pack-button hint--top" id="editor-clone-item" aria-label="<?php echo __('Clone', 'product-designer'); ?>"><?php echo $icon_clone; ?></span>
            <span class="pack-button hint--top" id="editor-DrawingMode" aria-label="<?php echo __('Drawing Mode', 'product-designer'); ?>"><?php echo $icon_pencil; ?></span>
            <span class="pack-button hint--top" id="editor-object-group" aria-label="<?php echo __('Object group', 'product-designer'); ?>"><?php echo $icon_object_group; ?></span>
            <span class="pack-button hint--top" id="editor-object-ungroup" aria-label="<?php echo __('Object ungroup', 'product-designer'); ?>"><?php echo $icon_object_ungroup; ?></span>


            <span class="pack-button hint--top" id="editor-zoomin" aria-label="<?php echo __('Zoom in', 'product-designer'); ?>"><?php echo $icon_zoomin; ?></span>
            <span class="pack-button hint--top" id="editor-zoomout" aria-label="<?php echo __('Zoom Out', 'product-designer'); ?>"><?php echo $icon_zoomout; ?></span>
            <span class="pack-button hint--top" id="editor-pan" aria-label="<?php echo __('Panning', 'product-designer'); ?>"><?php echo $icon_hand; ?></span>
            <span class="pack-button hint--top" id="editor-item-bringForward" aria-label="<?php echo __('Bring Forward', 'product-designer'); ?>"><i class="cpd-icon-move-up" ></i></span>
            <span class="pack-button hint--top" id="editor-item-sendBackwards" aria-label="<?php echo __('Send Backwards', 'product-designer'); ?>"><i class="cpd-icon-move-down" ></i></span>
            <span class="pack-button hint--top" id="editor-flip-v" aria-label="<?php echo __('Flip vertical', 'product-designer'); ?>" ><i class="cpd-icon-flip-vertical" ></i></span>
            <span class="pack-button hint--top" id="editor-flip-h" aria-label="<?php echo __('Flip horizontal', 'product-designer'); ?>" ><i class="cpd-icon-flip-horizontal" ></i></span>
            <span class="pack-button hint--top" id="editor-center-h" aria-label="<?php echo __('Center horizontally', 'product-designer'); ?>" ><i class="cpd-icon-align-horizontal-middle"></i></span>
            <span class="pack-button hint--top" id="editor-center-v" aria-label="<?php echo __('Center vertically', 'product-designer'); ?>" ><i class="cpd-icon-align-vertical-middle"></i></span>
            <span class="pack-button hint--top" id="editor-lockMovementX" aria-label="<?php echo __('Lock X movement', 'product-designer'); ?>" ><?php echo $icon_arrows_v; ?></span>
            <span class="pack-button hint--top" id="editor-lockMovementY" aria-label="<?php echo __('Lock Y movement', 'product-designer'); ?>" ><?php echo $icon_arrows_h; ?></span>
            <span class="pack-button hint--top" id="editor-lockRotation" aria-label="<?php echo __('Lock rotation', 'product-designer'); ?>" ><?php echo $icon_rotation; ?></span>
            <span class="pack-button hint--top" id="editor-lockScalingX" aria-label="<?php echo __('Lock X Scaling', 'product-designer'); ?>" ><span style="transform: rotate(45deg);display: inline-block;" ><?php echo $icon_expand; ?></span></span>
            <span class="pack-button hint--top" id="editor-lockScalingY" aria-label="<?php echo __('Lock Y Scaling', 'product-designer'); ?>" ><span style="transform: rotate(-45deg);display: inline-block;"><?php echo $icon_expand; ?></span></span>
            <span class="pack-button hint--top" id="editor-undo" aria-label="<?php echo __('Undo', 'product-designer'); ?>" ><?php echo $icon_undo; ?></span>
            <span class="pack-button hint--top" id="editor-redo" aria-label="<?php echo __('Redo', 'product-designer'); ?>" ><?php echo $icon_redo; ?></span>

            <div class="clear"></div>
            <?php
            if($enable_preview =='yes'): ?>
                <div class="editor-preview pd-guide-6"><?php echo sprintf(__('%s Preview','product-designer'), $icon_eye); ?></div>
            <?php
            endif;

            if($enable_download =='yes'): ?>
                <div class="editor-download pd-guide-7"><?php echo sprintf(__('%s Download','product-designer'), $icon_download); ?></div>
            <?php
            endif;
            ?>
        </div>
    </div>
    <?php
}

add_action('product_designer_tools', 'product_designer_tools_object_list', 20);

function product_designer_tools_object_list($atts){

    $icons = isset($atts['icons']) ? $atts['icons'] : '';
    $icon_layers = isset($icons['layers']) ? $icons['layers'] : '';
    $settings = isset($atts['settings']) ? $atts['settings'] : array();

    $hide_sections = isset($settings['hide_sections']) ? $settings['hide_sections'] : array();


    if(in_array('layers', $hide_sections )) return;


    ?>
    <div class="object-list accordions pd-panel-section pd-guide-8">
        <div class="panel-section-title"><?php echo sprintf(__('%s Layers','product-designer'), $icon_layers); ?></div>
        <div class="pd-panel-section-inner">
            <div class="layer-item layers-list ">
                <?php echo __('No layers','product-designer'); ?>
            </div>
        </div>

    </div>
    <?php

}


add_action('product_designer_tools', 'product_designer_tools_edit_text', 20);

function product_designer_tools_edit_text($atts){

    $settings = isset($atts['settings']) ? $atts['settings'] : array();

    $hide_sections = isset($settings['hide_sections']) ? $settings['hide_sections'] : array();


    if(in_array('edit_text', $hide_sections )) return;


    $icons = isset($atts['icons']) ? $atts['icons'] : '';
    $icon_text_bold = isset($icons['text_bold']) ? $icons['text_bold'] : '';
    $icon_text_italic = isset($icons['text_italic']) ? $icons['text_italic'] : '';
    $icon_text_underline = isset($icons['text_underline']) ? $icons['text_underline'] : '';
    $icon_text_strikethrough = isset($icons['text_strikethrough']) ? $icons['text_strikethrough'] : '';


    ?>

    <div class="edit-text pd-panel-section section-edit-text">
        <div class="panel-section-title"><?php echo __('Edit Text', 'product-designer'); ?></div>
        <div class="pd-panel-section-inner">
            <form id="edit-assets-text" action="#" method="get">
                <div class="setting-field full">
                    <div class="field-label" aria-label="<?php echo __('Write text content', 'product-designer'); ?>"><?php echo __('Text Content', 'product-designer'); ?></div>
                    <div class="field-input">
                        <textarea class="" id="text-content"></textarea>
                    </div>
                </div>

                <div class="setting-field full">
                    <span class="pack-button hint--top" aria-label="<?php echo __('Bold text', 'product-designer'); ?>" id="text-bold"><?php echo $icon_text_bold; ?></span>
                    <span class="pack-button hint--top" aria-label="<?php echo __('Italic text', 'product-designer'); ?>" id="text-italic"><?php echo $icon_text_italic; ?></span>
                    <span class="pack-button hint--top" aria-label="<?php echo __('Underline text', 'product-designer'); ?>" id="text-underline"><?php echo $icon_text_underline; ?></span>
                    <span class="pack-button hint--top" aria-label="<?php echo __('Strikethrough text', 'product-designer'); ?>" id="text-strikethrough"><?php echo $icon_text_strikethrough; ?></span>
                </div>

                <div class="clear"></div>

                <div class="setting-field half">
                    <div class="field-label hint--top" aria-label="Set text size">Text size</div>
                    <div class="field-input">
                        <input type="number" id="font-size" name="fontSize" placeholder="15" value="">
                    </div>
                </div>

                <div class="setting-field half">
                    <div class="field-label"><?php echo __('Text color:', 'product-designer'); ?></div>
                    <div class="field-input">
                        <input data-jscolor="" class="tool-button" id="font-color" aria-label="Text Color" placeholder="rgba(255,255,255,1)" type="text" value="rgba(255,255,255,1)">
                    </div>
                </div>

                <div class="setting-field half">
                    <div class="field-label"><?php echo __('Background color:', 'product-designer'); ?></div>
                    <div class="field-input">
                        <input data-jscolor="" class="tool-button" id="font-bg-color" aria-label="Background Color" placeholder="rgba(255,255,255,1)" type="text" value="rgba(255,255,255,1)">
                    </div>
                </div>


                <div class="setting-field half">
                    <div class="field-label"><?php echo __('Outline color:', 'product-designer'); ?></div>
                    <div class="field-input">
                        <input data-jscolor="" class="tool-button" id="stroke-color" aria-label="Outline Color" placeholder="rgba(255,255,255,1)" type="text" value="rgba(255,255,255,1)">
                    </div>
                </div>


                <div class="setting-field half">
                    <div class="field-label"><?php echo __('Text outline:', 'product-designer'); ?></div>
                    <div class="field-input">
                        <input class="" id="stroke-size" aria-label="Text Outline" type="number" placeholder="2" value="">
                    </div>
                </div>


                <div class="setting-field half">
                    <div class="field-label"><?php echo __('SkewX:', 'product-designer'); ?></div>
                    <div class="field-input">
                        <input class="" id="text-skewX" aria-label="Text SkewX" type="number" placeholder="2" value="">
                    </div>
                </div>



                <div class="setting-field half">
                    <div class="field-label"><?php echo __('SkewY:', 'product-designer'); ?></div>
                    <div class="field-input">
                        <input class="" id="text-skewY" aria-label="Text skewY" type="number" placeholder="2" value="">
                    </div>
                </div>

                <div class="setting-field half">
                    <div class="field-label"><?php echo __('Character spacing:', 'product-designer'); ?></div>
                    <div class="field-input">
                        <input class="" id="text-charSpacing" type="number" placeholder="10" value="">
                    </div>
                </div>

                <div class="setting-field half">
                    <div class="field-label"><?php echo __('Rotate:', 'product-designer'); ?></div>
                    <div class="field-input">
                        <input class="" id="text-angle" type="range" min="0" max="360" step="1" placeholder="10" value="">
                    </div>
                </div>



                <div class="setting-field half">
                    <div class="field-label"><?php echo __('Text transform :', 'product-designer'); ?></div>
                    <div class="field-input">
                        <select id="text-transform">
                            <option value="none">None</option>
                            <option value="uppercase">UPPERCASE</option>
                            <option value="lowercase">lowercase</option>
                            <option value="capitalize">Capitalize</option>

                        </select>
                    </div>
                </div>

                <div class="setting-field half">
                    <div class="field-label"><?php echo __('Font family:', 'product-designer'); ?></div>
                    <div class="field-input">
                        <?php
                        $product_designer_fonts = product_designer_fonts();
                        ?>
                        <select class=" font-family" aria-label="<?php echo __('Font family', 'product-designer'); ?>" id="font-family">
                            <?php
                            foreach($product_designer_fonts as $font){
                                $name = $font['name'];
                                $name_id = str_replace(' ','+',$name);
                                ?>
                                <option style="font-family:<?php echo $name_id; ?>" value="<?php echo $name; ?>"><?php echo $name; ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="setting-field half">
                    <div class="field-label"><?php echo __('Opacity:', 'product-designer'); ?></div>
                    <div class="field-input">
                        <input  class=" tool-button" aria-label="Opacity" id="font-opacity" type="range" min="0" max="1" step="0.1" value="1" />
                    </div>
                </div>
            </form>
        </div>
    </div>

    <?php

}





add_action('product_designer_tools', 'product_designer_tools_edit_img', 20);

function product_designer_tools_edit_img($atts){


    $settings = isset($atts['settings']) ? $atts['settings'] : array();

    $hide_sections = isset($settings['hide_sections']) ? $settings['hide_sections'] : array();


    if(in_array('edit_image', $hide_sections )) return;

    ?>
    <div class="edit-img pd-panel-section section-image-action">
        <div class="panel-section-title"><?php echo __('Edit Images', 'product-designer'); ?></div>
        <div class="pd-panel-section-inner">


            <div class="setting-field half">
                <div class="field-label"><?php echo __('Opacity', 'product-designer'); ?></div>
                <div class="field-input">
                    <label><input id="img-enable-opacity" type="checkbox">Enable</label>
                    <input  class="" aria-label="Opacity" id="img-opacity" type="range" min="0" max="1" step="0.1" value="1" />
                </div>
            </div>

            <div class="setting-field half">
                <div class="field-label"><?php echo __('Grayscale', 'product-designer'); ?></div>
                <div class="field-input">
                    <label><input id="img-enable-grayscale" type="checkbox">Enable</label>
                </div>
            </div>

            <div class="setting-field half">
                <div class="field-label"><?php echo __('Invert', 'product-designer'); ?></div>
                <div class="field-input">
                    <label><input id="img-enable-invert" type="checkbox">Enable</label>
                </div>
            </div>

            <div class="setting-field half">
                <div class="field-label"><?php echo __('Sepia', 'product-designer'); ?></div>
                <div class="field-input">
                    <label><input id="img-enable-sepia" type="checkbox">Enable</label>
                </div>
            </div>

            <div class="setting-field half">
                <div class="field-label"><?php echo __('Noise', 'product-designer'); ?></div>
                <div class="field-input">
                    <label><input id="img-enable-noise" type="checkbox">Enable</label>
                    <input  class="" aria-label="Noise" id="img-noise" type="range" min="0" max="1000" step="1" value="100" />
                </div>
            </div>

            <div class="setting-field half">
                <div class="field-label"><?php echo __('Pixelate', 'product-designer'); ?></div>
                <div class="field-input">
                    <label><input id="img-enable-pixelate" type="checkbox">Enable</label>
                    <input  class="" aria-label="Pixelate" id="img-pixelate" type="range" min="2" max="20" step="1" value="5" />
                </div>
            </div>




<!--            <div class="setting-field half">-->
<!--                <div class="field-label">--><?php //echo __('Brightness', 'product-designer'); ?><!--</div>-->
<!--                <div class="field-input">-->
<!--                    <label><input id="img-enable-brightness" type="checkbox">Enable?</label>-->
<!--                    <input  class="" aria-label="Brightness" id="img-brightness" type="range" min="-1" max="1" step="0.01" value="0" />-->
<!--                </div>-->
<!--            </div>-->

<!--            <div class="setting-field half">-->
<!--                <div class="field-label">--><?php //echo __('Contrast', 'product-designer'); ?><!--</div>-->
<!--                <div class="field-input">-->
<!--                    <label><input id="img-enable-contrast" type="checkbox">Enable?</label>-->
<!--                    <input  class="" aria-label="Contrast" id="img-contrast" type="range" min="-1" max="1" step="0.01" value="1" />-->
<!--                </div>-->
<!--            </div>-->

<!--            <div class="setting-field half">-->
<!--                <div class="field-label">--><?php //echo __('Saturation', 'product-designer'); ?><!--</div>-->
<!--                <div class="field-input">-->
<!--                    <label><input id="img-enable-saturation" type="checkbox">Enable?</label>-->
<!--                    <input  class="" aria-label="Saturation" id="img-saturation" type="range" min="-1" max="1" step="0.01" value="1" />-->
<!--                </div>-->
<!--            </div>-->





<!--            <div class="setting-field half">-->
<!--                <div class="field-label">--><?php //echo __('Blur', 'product-designer'); ?><!--</div>-->
<!--                <div class="field-input">-->
<!--                    <label><input id="img-enable-blur" type="checkbox">Enable?</label>-->
<!--                    <input  class="" aria-label="Blur" id="img-blur" type="range" min="0" max="1" step="0.1" value="1" />-->
<!--                </div>-->
<!--            </div>-->


<!--            <div class="setting-field half">-->
<!--                <div class="field-label">--><?php //echo __('Vintage', 'product-designer'); ?><!--</div>-->
<!--                <div class="field-input">-->
<!--                    <label><input id="img-enable-vintage" type="checkbox">Enable?</label>-->
<!--                </div>-->
<!--            </div>-->

<!---->
<!--            <div class="setting-field half">-->
<!--                <div class="field-label">--><?php //echo __('Brownie', 'product-designer'); ?><!--</div>-->
<!--                <div class="field-input">-->
<!--                    <label><input id="img-enable-brownie" type="checkbox">Enable?</label>-->
<!--                </div>-->
<!--            </div>-->
<!---->
<!--            <div class="setting-field half">-->
<!--                <div class="field-label">--><?php //echo __('Kodachrome', 'product-designer'); ?><!--</div>-->
<!--                <div class="field-input">-->
<!--                    <label><input id="img-enable-kodachrome" type="checkbox">Enable?</label>-->
<!--                </div>-->
<!--            </div>-->
<!---->
<!--            <div class="setting-field half">-->
<!--                <div class="field-label">--><?php //echo __('Technicolor', 'product-designer'); ?><!--</div>-->
<!--                <div class="field-input">-->
<!--                    <label><input id="img-enable-technicolor" type="checkbox">Enable?</label>-->
<!--                </div>-->
<!--            </div>-->
<!---->
<!--            <div class="setting-field half">-->
<!--                <div class="field-label">--><?php //echo __('Polaroid', 'product-designer'); ?><!--</div>-->
<!--                <div class="field-input">-->
<!--                    <label><input id="img-enable-polaroid" type="checkbox">Enable?</label>-->
<!--                </div>-->
<!--            </div>-->




















        </div>
    </div>
    <?php

}



add_action('product_designer_tools', 'product_designer_tools_edit_shape', 20);

function product_designer_tools_edit_shape($atts){


    $settings = isset($atts['settings']) ? $atts['settings'] : array();

    $hide_sections = isset($settings['hide_sections']) ? $settings['hide_sections'] : array();


    if(in_array('edit_shapes', $hide_sections )) return;


    ?>
    <div class="edit-shape pd-panel-section">
        <div class="panel-section-title"><?php echo __('Edit Shapes', 'product-designer'); ?></div>
        <div class="pd-panel-section-inner">

            <div class="setting-field half">
                <div class="field-label"><?php echo __('Opacity', 'product-designer'); ?></div>
                <div class="field-input">
                    <input  class="" aria-label="Opacity" id="shape-opacity" type="range" min="0" max="1" step="0.1" value="1" />
                </div>
            </div>
            <div class="setting-field half">
                <div class="field-label"><?php echo __('Color', 'product-designer'); ?></div>
                <div class="field-input">
                    <input  data-jscolor="" aria-label="<?php echo __('Color', 'product-designer'); ?>" id="shape-color" class=" " placeholder="<?php echo __('Color', 'product-designer'); ?>"  type="text" value="rgba(255,255,255,1)" />
                </div>
            </div>
        </div>
    </div>
    <?php

}


add_action('product_designer_tools', 'product_designer_tools_product_info', 50);

function product_designer_tools_product_info($atts){

    $product_id = isset($atts['product_id']) ? $atts['product_id'] : '';
    $variation_id = isset($atts['variation_id']) ? $atts['variation_id'] : '';

    $product_title = isset($atts['product_title']) ? $atts['product_title'] : '';
    $currency_symbol = isset($atts['currency_symbol']) ? $atts['currency_symbol'] : '';
    $pd_template_id = isset($atts['pd_template_id']) ? $atts['pd_template_id'] : '';
    $base_price = isset($atts['base_price']) ? $atts['base_price'] : '';
    $display_price = isset($atts['display_price']) ? $atts['display_price'] : '';

    $icons = isset($atts['icons']) ? $atts['icons'] : '';
    $cart = isset($icons['cart']) ? $icons['cart'] : '';

    $product_data = wc_get_product($product_id);
//        $is_variable = $product_data->is_type('variable');
    $product_type = $product_data->get_type();

    if($product_type == 'variable'){
        $product_title = get_the_title($variation_id);
    }


    ?>

    <div class="product-info accordions pd-panel-section pd-guide-9">
        <div class="panel-section-title"><?php echo sprintf(__('%s Product info','product-designer'), $cart); ?></div>
        <div class="pd-panel-section-inner">
            <form class="cart" enctype="multipart/form-data" method="post" action="#">
                <input type="hidden" value="<?php echo $product_id; ?>" name="add-to-cart">
                <input type="hidden" value="<?php echo $pd_template_id; ?>" name="pd_template_id">

                <?php
                if(!empty($variation_id)){
                    ?>
                    <input type="hidden"  name="variation_id" value="<?php echo $variation_id; ?>">
                    <?php
                }

                ?>


                <div class="setting-field half">
                    <div class="field-label"><?php echo __('You are editing', 'product-designer'); ?></div>
                    <div class="field-input">
                        <strong><?php echo $product_title; ?></strong>
                    </div>
                </div>


                <div class="setting-field half">
                    <div class="field-label"><?php echo __('Base price', 'product-designer'); ?></div>
                    <div class="field-input">
                        <?php echo $display_price; ?>
                    </div>
                </div>

                <div class="setting-field half assets-price-wrap">
                    <div class="field-label"><?php echo __('Assets price', 'product-designer'); ?></div>
                    <div class="field-input">
                        <div class="" id="assets-price"><?php echo $currency_symbol; ?><span>0.00</span></div>
                        <input class="" type="hidden" value="" id="assets-price-val" name="assets_price">
                    </div>
                </div>


                <div class="setting-field half">
                    <div class="field-label"><?php echo __('Quantity', 'product-designer'); ?></div>
                    <div class="field-input">
                        <input class="input-text quantity text" type="number" size="4" aria-label="<?php echo __('Quantity', 'product-designer'); ?>" value="1" name="quantity" min="1" step="1">
                    </div>
                </div>


                <div class="input-group product">

                    <div class="generate-side-output"><?php echo __('Generate', 'product-designer'); ?> </div>
                    <div class="output-side-items"></div>
                    <div class="output-side-items-attach-ids"></div>
                    <div class="output-side-items-json"></div>
                    <button class="pd-addtocart button alt addtocart" type="submit" name="addtocart" value="addtocart"><?php echo __('Add to cart', 'product-designer'); ?></button>

                </div>
            </form>
        </div>


    </div>


    <?php

}



add_action('product_designer_tools', 'product_designer_tools_keyboard', 90);

function product_designer_tools_keyboard($atts){

    $icons = isset($atts['icons']) ? $atts['icons'] : '';
    $keyboard = isset($icons['keyboard']) ? $icons['keyboard'] : '';

    $settings = isset($atts['settings']) ? $atts['settings'] : array();

    $hide_sections = isset($settings['hide_sections']) ? $settings['hide_sections'] : array();


    if(in_array('keyboard_shortcuts', $hide_sections )) return;


    ?>
    <div class="pd-panel-section accordions pd-guide-10">
        <div class="panel-section-title"><?php echo sprintf(__('%s Keyboard Shortcut','product-designer'), $keyboard); ?></div>
        <div class="pd-panel-section-inner">

            <div class="shortcut">
                <?php echo sprintf(__('%s Delete selected item','product-designer'), '<kbd>Delete</kbd>'); ?>
            </div>
            <div class="shortcut">
                <?php echo sprintf(__('%s Clear canvas','product-designer'), '<kbd>Shift + Delete</kbd>'); ?>

            </div>
            <div class="shortcut">
                <?php echo sprintf(__('%s Zoom in','product-designer'), '<kbd>Ctrl + +</kbd> '); ?>

            </div>
            <div class="shortcut">
                <?php echo sprintf(__('%s Zoom out','product-designer'), '<kbd>Ctrl + -</kbd> '); ?>

            </div>

            <div class="shortcut">
                <?php echo sprintf(__('%s Preview','product-designer'), '<kbd>Ctrl + P</kbd>'); ?>

            </div>

            <div class="shortcut">
                <?php echo sprintf(__('%s Download','product-designer'), '<kbd>Ctrl + D</kbd>'); ?>

            </div>


            <div class="shortcut">
                <?php echo sprintf(__('%s Undo','product-designer'), '<kbd>Ctrl + Z</kbd>'); ?>

            </div>

            <div class="shortcut">
                <?php echo sprintf(__('%s Redo','product-designer'), '<kbd>Ctrl + Y</kbd>'); ?>

            </div>
            <div class="shortcut">
                <?php echo sprintf(__('%s Panning','product-designer'), '<kbd>Ctrl + Space</kbd>'); ?>

            </div>





            <div class="shortcut">
                <kbd>Tab</kbd> Switch tabs
            </div>


        </div>


    </div>
    <?php

}




add_action('product_designer_editor', 'product_designer_canvas', 25);

function product_designer_canvas(){


    ?>
    <div id="designer" class="designer">
        <canvas id="c"></canvas>
    </div>
    <?php
}





add_action('product_designer_editor', 'product_designer_scripts', 30);

function product_designer_scripts($atts){

    $product_id = isset($atts['product_id']) ? sanitize_text_field($atts['product_id']) : '';
    $canvas = isset($atts['canvas']) ? $atts['canvas'] : array();
    $currency_symbol = isset($atts['currency_symbol']) ? $atts['currency_symbol'] : '';
    $side_data = isset($atts['side_data']) ? $atts['side_data'] : '';
    $pd_template_id = isset($atts['pd_template_id']) ? $atts['pd_template_id'] : '';
    $base_price = isset($atts['base_price']) ? $atts['base_price'] : '';
    $display_price = isset($atts['display_price']) ? $atts['display_price'] : '';





    $variation_id = isset($atts['variation_id']) ? $atts['variation_id'] : '';
    $product_type = isset($atts['product_type']) ? $atts['product_type'] : '';

    $settings = isset($atts['settings']) ? $atts['settings'] : '';
    $enable_guide = isset($settings['enable_guide']) ? $settings['enable_guide'] : '';


    $text_price = isset($settings['text_price']) ? $settings['text_price'] : '';
    $clipart_price = isset($settings['clipart_price']) ? $settings['clipart_price'] : '';
    $shape_price = isset($settings['shape_price']) ? $settings['shape_price'] : '';
    $qrcode_price = isset($settings['qrcode_price']) ? $settings['qrcode_price'] : '';
    $barcode_price = isset($settings['barcode_price']) ? $settings['barcode_price'] : '';



    $session_id = session_id();
    $product_designer_fonts = product_designer_fonts();


    $product_designer_editor['product_type']  = $product_type;

    $product_designer_editor['text_price']  = $text_price;
    $product_designer_editor['clipart_price']  = $clipart_price;
    $product_designer_editor['shape_price']  = $shape_price;
    $product_designer_editor['qrcode_price']  = $qrcode_price;
    $product_designer_editor['barcode_price']  = $barcode_price;



    $product_designer_editor['variation_id']  = $variation_id;
    $product_designer_editor['product_base_price']  = $base_price;
    $product_designer_editor['product_display_price']  = $display_price;



    $product_designer_editor['product_id']  = $product_id;


    $product_designer_editor['product_title']  = get_the_title($product_id);
    $product_designer_editor['wc_currency_symbol']  = $currency_symbol;

    $product_designer_editor['session_id']  = $session_id;

    $product_designer_editor['width']  = isset($canvas['width']) ? $canvas['width'] : '500';
    $product_designer_editor['height']  = isset($canvas['height']) ? $canvas['height'] : '500';


    $product_designer_editor['output_file_format']  = isset($canvas['output']['file_format']) ? $canvas['output']['file_format'] : 'png';
    $product_designer_editor['preview_file_format']  = isset($canvas['preview']['file_format']) ? $canvas['preview']['file_format'] : 'png';


    $side_data_ids = array_keys($side_data);
    $current_side_id = isset($side_data_ids[0]) ? $side_data_ids[0] : '';

    $product_designer_editor['pd_template_id']  = $pd_template_id;
    $product_designer_editor['pre_template_id']  = '';

    $product_designer_editor['side_data_ids']  = $side_data_ids;
    $product_designer_editor['current_side_id']  = $current_side_id;
    $product_designer_editor['side_data']  = $side_data;
    $product_designer_editor['side_serialized_data']  = array();
    $product_designer_editor['side_json_data']  = array();
    $product_designer_editor['side_ids_preview_data']  = array();


    $class_product_designer_functions = new class_product_designer_functions();
    $tour_guide_steps = $class_product_designer_functions->tour_guide_steps();


    $product_designer_editor['tour_guide']  = array(

        'tour_hide'=>false,
        'tour_complete'=>false,
        'enable'=> ($enable_guide == 'yes') ? true : false,
        'steps'=> $tour_guide_steps,

    );



    $product_designer_editor['cart_attach_ids']  = array();


    ?>

    <script>

        jQuery(document).ready(function($){
            $(".accordions").accordion({
                collapsible:true,
                active: 999,
                heightStyle: "full",
            })

        })

        //jQuery(document).ready(function($){

            var product_designer_editor = <?php echo json_encode($product_designer_editor); ?>;


            var product_id = product_designer_editor.product_id;
            var variation_id = product_designer_editor.variation_id;
            var current_side_id = product_designer_editor.current_side_id;
            var side_data = product_designer_editor.side_data;
            var current_side_data = side_data[current_side_id];


            if (typeof current_side_data['background_fit_canvas_size'] != "undefined"){
                var background_fit_canvas_size = current_side_data['background_fit_canvas_size'];
            }

            if (typeof current_side_data['overlay_fit_canvas_size'] != "undefined"){
                var overlay_fit_canvas_size = current_side_data['overlay_fit_canvas_size'];
            }


            var canvas = new fabric.Canvas('c');







            //canvas.backgroundImageStretch = true;
            // Canvas dimension
            canvas.setHeight(<?php echo $canvas['height']; ?>);
            canvas.setWidth(<?php echo $canvas['width']; ?>);

            if(background_fit_canvas_size == 1){

                canvas.setBackgroundImage(current_side_data['background'], canvas.renderAll.bind(canvas),{
                    // Needed to position backgroundImage at 0/0
                    originX: 'left',
                    originY: 'top',
                    width: canvas.width,
                    height: canvas.height,
                });

            }
            else{

                canvas.setBackgroundImage(current_side_data['background'], canvas.renderAll.bind(canvas),{
                    // Needed to position backgroundImage at 0/0
                    originX: 'left',
                    originY: 'top',
//            width: canvas.width,
//            height: canvas.height,
                });

            }



            if(overlay_fit_canvas_size == 1){
                canvas.setOverlayImage(current_side_data['overlay'], canvas.renderAll.bind(canvas), {
                    // Needed to position overlayImage at 0/0
                    originX: 'left',
                    originY: 'top',
                    width: canvas.width,
                    height: canvas.height, // canvas.height
                });
            }
            else{
                canvas.setOverlayImage(current_side_data['overlay'], canvas.renderAll.bind(canvas), {
                    // Needed to position overlayImage at 0/0
                    originX: 'left',
                    originY: 'top',
                    //width: canvas.width,
                    //height: 'auto', // canvas.height
                });
            }


        //})





    </script>

    <style>
        <?php
        foreach($product_designer_fonts as $font){


            $Fontname = $font['name'];
            $name = str_replace(' ','+',$Fontname);

            if(!empty($font['src'])){
                $src = isset($font['src']) ? esc_url_raw($font['src']) : '';
                ?>
                @font-face{
                    font-family: <?php echo $Fontname; ?>;
                    src: url("<?php echo $src; ?>");
                }

                <?php


            }
            else{
                ?>
                @import url('https://fonts.googleapis.com/css?family=<?php echo $name; ?>');

                <?php
            }


    }






?>
    </style>

    <?php







}






add_action('product_designer_editor', 'product_designer_loading', 35);

function product_designer_loading(){

    ?>
    <div class="editor-busy">
        <div class="inner-content">
            <span class="icon"></span> <span class="message"></span>

        </div>
    </div>
    <?php

}


add_action('product_designer_editor', 'product_designer_welcome_tour', 40);

function product_designer_welcome_tour($atts){

    $settings = isset($atts['settings']) ? $atts['settings'] : '';
    $enable_guide = isset($settings['enable_guide']) ? $settings['enable_guide'] : '';


    if($enable_guide != 'yes') return;

    ?>
    <div class="welcome-tour">
        <div class="inner-content">
            <?php
            do_action('product_designer_welcome_tour_content', $atts);
            ?>

            <button class="start-tour"><?php echo __('Start Tour', "product-designer"); ?></button>
            <button class="end-tour"><?php echo __('End Tour', "product-designer"); ?></button>
        </div>
    </div>
    <?php

}


add_action('product_designer_welcome_tour_content', 'product_designer_welcome_tour_content', 10);

function product_designer_welcome_tour_content(){
    ?>
    <h2 class="headeline"><?php echo __('Welcome to the Product Designer', "product-designer"); ?></h2>
    <p class="details"><?php echo __('Please see the welcome guide to see how the editor work and get stunning product design.', "product-designer"); ?></p>
    <?php
}


add_action('product_designer_editor', 'product_designer_preview', 45);

function product_designer_preview(){

    ?>
    <div class="preview ">
        <div class="preview-img ">
            <span class="preview-close"><i class="fa fa-times"></i></span>
            <div class="img"></div>
        </div>
    </div>
    <?php

}




add_action('product_designer_editor', 'product_designer_toast', 50);

function product_designer_toast(){

    ?>
    <div class="toast">
        <span class="icon"></span> <span class="message"></span>
    </div>
    <?php

}


add_action('product_designer_editor', 'product_designer_editor_style', 90);

function product_designer_editor_style($atts){

    $canvas = isset($atts['canvas']) ? $atts['canvas'] : array();
    $canvas_bg_color  = isset($canvas['bg_color']) ? $canvas['bg_color'] : '';
    $enable_tile_bg = !empty($canvas['enable_tile_bg']) ? $canvas['enable_tile_bg'] : '';
    $tile_bg_src = !empty($canvas['tile_bg_src']) ? $canvas['tile_bg_src'] : '';

    $settings = isset($atts['settings']) ? $atts['settings'] : array();
    $menu_position = isset($settings['menu_position']) ? $settings['menu_position'] : 'left';
    $clipart_width = isset($settings['clipart_width']) ? $settings['clipart_width'] : '';
    $clipart_bg_color = isset($settings['clipart_bg_color']) ? $settings['clipart_bg_color'] : '';
    $editor_bg_color = isset($settings['editor_bg_color']) ? $settings['editor_bg_color'] : '';
    $section_bg_color = isset($settings['section_bg_color']) ? $settings['section_bg_color'] : '';
    $section_title_bg_color = isset($settings['section_title_bg_color']) ? $settings['section_title_bg_color'] : '';

    //var_dump($editor_bg_color);

    ?>
    <style type="text/css">

        .product-designer .menu, .editor-tabs .editor-tab-navs .nav.active{
            background: <?php echo $editor_bg_color; ?> !important;


        }

        .product-designer .pd-panel-section{
            background: <?php echo $section_bg_color; ?> !important;

        }
        .product-designer .panel-section-title, .editor-tabs .editor-tab-navs .nav{
            background: <?php echo $section_title_bg_color; ?> !important;

        }

        .product-designer .canvas-container{
            <?php if(!empty($canvas_bg_color)): ?>
            background-color: <?php echo $canvas_bg_color; ?> !important;
            <?php endif; ?>

        <?php if($enable_tile_bg=='yes' && !empty($tile_bg_src)): ?>
            background-image: url(<?php echo $tile_bg_src; ?>) !important;
        <?php endif; ?>

        }

        .product-designer .clipart-list img{
            <?php if(!empty($clipart_width)): ?>
                max-width: <?php echo $clipart_width; ?> !important;
            <?php endif; ?>
            <?php if(!empty($clipart_bg_color)): ?>
                background: <?php echo $clipart_bg_color; ?> !important;
            <?php endif; ?>

        }


        <?php

        if($menu_position == 'left'){
            ?>
            body{
                margin-left: 370px;
            }
            .product-designer .menu{
                left: 0px !important;
            }
            <?php
        }else{
            ?>
            body {
                margin-right: 370px;
            }
            .product-designer .menu{
                right: 0px !important;
            }
            <?php
        }
        ?>
        .admin-bar .product-designer .menu{
            top: 32px;
        }
    </style>
    <?php

}

