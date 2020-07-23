<?php
if ( ! defined('ABSPATH')) exit;  // if direct access






add_action('product_designer_editor', 'product_designer_notice', 0);

function product_designer_notice(){

    ?>
    <div class="product-designer-notice">
        <div class="notices">
        </div>
    </div>

    <?php

}





add_action('product_designer_editor', 'product_designer_wrap_start', 5);

function product_designer_wrap_start(){

    ?>
    <div class="product-designer">

    <?php

}





















add_action('product_designer_editor', 'product_designer_editor', 10);

function product_designer_editor(){


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





    endif;

}

add_action('product_designer_editor', 'product_designer_menu', 15);

function product_designer_menu(){

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


   ?>

    <div class="menu">

        <div class="side item  pd-guide-1" title="Sides"><span class="icon"><i class="fa fa-cube" ></i></span>
            <div class="child">


                <ul class="side-list scrollbar">

                    <?php

                    $cook_data = isset($_COOKIE['side_customized']) ? sanitize_text_field($_COOKIE['side_customized']) : '';

                    $cook_data = unserialize(stripslashes($cook_data));
                    //var_dump($cook_data);
                    if(!empty($cook_data[$product_id])){
                        $prduct_cook_data = $cook_data[$product_id];
                    }
                    else{
                        $prduct_cook_data = array();
                    }

                    if(!empty($side_data)){

                        foreach($side_data as $id=>$side){

                            $name = isset($side['name']) ? $side['name'] : '';
                            $icon = isset($side['icon']) ? $side['icon'] : '';
                            $background = isset($side['background']) ? $side['background'] : '';
                            $inc_background = isset($side['inc_background']) ? $side['inc_background'] : '';
                            $overlay = isset($side['overlay']) ? $side['overlay'] : '';
                            $inc_overlay = isset($side['inc_overlay']) ? $side['inc_overlay'] : '';


                            if(!empty($icon)){

                                ?>
                                <li side_id="<?php echo $id; ?>" >
                                    <img src="<?php echo $icon; ?>" />
                                    <span class="name"><?php echo $name; ?></span>
                                </li>
                                <?php

                            }


                        }

                    }
                    else{

                        echo '<span>'.__('Not available.', "product-designer").'</span>';
                    }

                    ?>

                </ul>



            </div>

        </div>
        <div class="clipart item pd-guide-2" title="<?php echo __('Clip Art', "product-designer"); ?>"><span class="icon"><i class="fa fa-file-image-o" ></i></span>
            <div class="child">

                <select title="<?php echo __('Categories', "product-designer"); ?>" id="clipart-cat">

                    <?php

                    $args=array(
                        'orderby' => 'name',
                        'order' => 'ASC',
                        'taxonomy' => 'clipart_cat',
                    );



                    echo '<option value="all">'.__('All', "product-designer").'</option>';

                    $categories = get_categories($args);

                    foreach($categories as $category){

                        echo '<option value='.$category->cat_ID.'>'.$category->cat_name.'</option>';

                    }


                    //echo '<span class="sticker-cat-loading">Loading...</span>';

                    ?>






                </select>




                <div class="clipart-list scrollbar">

                    <?php
                    $product_designer_posts_per_page = get_option('product_designer_posts_per_page', 10);


                    $args = array(
                        'post_type'=>'clipart',
                        'posts_per_page'=> $product_designer_posts_per_page,
                    );


                    $wp_query = new WP_Query($args);

                    if ( $wp_query->have_posts() ) :
                        while ( $wp_query->have_posts() ) : $wp_query->the_post();
                            $thumb = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), 'full' );
                            $thumb_url = $thumb['0'];

                            if(!empty($thumb_url))
                                echo '<img class="" title="'.get_the_title().'" src="'.esc_url_raw($thumb_url).'" />';

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
                        'total' => $wp_query->max_num_pages
                    ) );

                    ?>



                </div>

            </div>
        </div>

        <div class="text item  pd-guide-3" title="<?php echo __('Text Art', 'product-designer'); ?>">
            <span class="icon"><i class="fa fa-file-word-o" ></i></span>
            <div class="child">
                <textarea class="input-text"></textarea><br>
                <input type="button" class="button add-text" value="<?php echo __('Add Text', "product-designer"); ?>">

            </div>

        </div>

        <div class="shapes item  pd-guide-4" title="<?php echo __('Shapes', "product-designer"); ?>"><span class="icon"><i class="fa fa-map-o" ></i></span>

            <div class="child">
                <div class="shape-list scrollbar">

                    <span class=" add-shape" shape-type="rectangle" title="<?php echo __('Rectangle', "product-designer"); ?>" ><i class="pickicon-square" ></i></span>
                    <span class=" add-shape" shape-type="circle" title="<?php echo __('Circle', "product-designer"); ?>"><i class="pickicon-circle" ></i></span>
                    <span class=" add-shape" shape-type="triangle" title="<?php echo __('Triangle', "product-designer"); ?>" ><i class="pickicon-triangle" ></i></span>
                    <span class=" add-shape" shape-type="heart" title="<?php echo __('Heart', "product-designer"); ?>" ><i class="pickicon-heart" ></i></span>
                    <span class=" add-shape" shape-type="polygon-5" title="<?php echo __('Polygon', "product-designer"); ?>" ><i class="pickicon-polygon-5" ></i></span>
                    <span class=" add-shape" shape-type="polygon-6" title="<?php echo __('Polygon', "product-designer"); ?>" ><i class="pickicon-polygon-6" ></i></span>
                    <span class=" add-shape" shape-type="polygon-7" title="<?php echo __('Polygon', "product-designer"); ?>" ><i class="pickicon-polygon-7" ></i></span>
                    <span class=" add-shape" shape-type="polygon-8" title="<?php echo __('Polygon', "product-designer"); ?>" ><i class="pickicon-polygon-8" ></i></span>
                    <span class=" add-shape" shape-type="polygon-9" title="<?php echo __('Polygon', "product-designer"); ?>" ><i class="pickicon-polygon-9" ></i></span>
                    <span class=" add-shape" shape-type="polygon-10" title="<?php echo __('Polygon', "product-designer"); ?>" ><i class="pickicon-polygon-10" ></i></span>
                    <span class=" add-shape" shape-type="star-5" title="<?php echo __('Star', "product-designer"); ?>" ><i class="pickicon-star-5" ></i></span>
                    <span class=" add-shape" shape-type="star-6" title="<?php echo __('Star', "product-designer"); ?>"><i class="pickicon-star-6" ></i></span>
                    <span class=" add-shape" shape-type="star-7" title="<?php echo __('Star', "product-designer"); ?>" ><i class="pickicon-star-7" ></i></span>
                    <span class=" add-shape" shape-type="star-8" title="<?php echo __('Star', "product-designer"); ?>" ><i class="pickicon-star-8" ></i></span>

                </div>

            </div>

        </div>

    </div>
    <?php

}

add_action('product_designer_editor', 'product_designer_edit_panel', 20);

function product_designer_edit_panel(){
    $product_id = isset($_GET['product_id']) ? sanitize_text_field($_GET['product_id']) : '';



    $product_data = wc_get_product($product_id);
    $is_variable = $product_data->is_type('variable');


    if($is_variable):

        $variation_id = isset($_GET['variation_id']) ? sanitize_text_field($_GET['variation_id']): '';
        $pd_template_id = get_post_meta( $variation_id, 'pd_template_id', true );


        if(empty($variation_id)):
            $product_designer_error['variation_id_missing'] = 'Variation id is missing';
        endif;



    else:

        $pd_template_id = get_post_meta( $product_id, 'pd_template_id', true );

    endif;

    ?>

    <div class="editing scrollbar">


        <div class="editor-actions toolbar-section pd-guide-5">
            <div class="toolbar-title"><?php echo __('Editor Actions', 'product-designer'); ?></div>
            <div class="toolbar-section-inner">
                <span class="pack-button hint--top" id="editor-show-grid" aria-label="<?php echo __('Show grid', 'product-designer'); ?>"><i class="cpd-icon-grid" ></i></span>
                <span class="pack-button hint--top" id="editor-clear" aria-label="<?php echo __('Clear All', 'product-designer'); ?>"><i class="cpd-icon-remove" ></i></span>
                <span class="pack-button hint--top" id="editor-delete-item" aria-label="<?php echo __('Delete', 'product-designer'); ?>"><i class="fa fa-trash" aria-hidden="true"></i></span>
                <span class="pack-button hint--top" id="editor-clone-item" aria-label="<?php echo __('Clone', 'product-designer'); ?>"><i class="fa fa-clone" aria-hidden="true"></i></span>
                <span class="pack-button hint--top" id="editor-DrawingMode" aria-label="<?php echo __('Drawing Mode', 'product-designer'); ?>"><i class="fa fa-pencil" aria-hidden="true"></i></span>
                <span class="pack-button hint--top" id="editor-zoomin" aria-label="<?php echo __('Zoom in', 'product-designer'); ?>"><i class="fa fa-search-plus"></i></span>
                <span class="pack-button hint--top" id="editor-zoomout" aria-label="<?php echo __('Zoom Out', 'product-designer'); ?>"><i class="fa fa-search-minus"></i></span>
                <span class="pack-button hint--top" id="editor-pan" aria-label="<?php echo __('Panning', 'product-designer'); ?>"><i class="fa fa-hand-paper-o" aria-hidden="true"></i></span>
                <span class="pack-button hint--top" id="editor-item-bringForward" aria-label="<?php echo __('Bring Forward', 'product-designer'); ?>"><i class="cpd-icon-move-up" ></i></span>
                <span class="pack-button hint--top" id="editor-item-sendBackwards" aria-label="<?php echo __('Send Backwards', 'product-designer'); ?>"><i class="cpd-icon-move-down" ></i></span>
                <span class="pack-button hint--top" id="editor-flip-v" aria-label="<?php echo __('Flip vertical', 'product-designer'); ?>" ><i class="cpd-icon-flip-vertical" ></i></span>
                <span class="pack-button hint--top" id="editor-flip-h" aria-label="<?php echo __('Flip horizontal', 'product-designer'); ?>" ><i class="cpd-icon-flip-horizontal" ></i></span>
                <span class="pack-button hint--top" id="editor-center-h" aria-label="<?php echo __('Center horizontally', 'product-designer'); ?>" ><i class="cpd-icon-align-horizontal-middle"></i></span>
                <span class="pack-button hint--top" id="editor-center-v" aria-label="<?php echo __('Center vertically', 'product-designer'); ?>" ><i class="cpd-icon-align-vertical-middle"></i></span>
                <span class="pack-button hint--top" id="editor-lockMovementX" aria-label="<?php echo __('Lock X movement', 'product-designer'); ?>" ><i class="fa fa-arrows-v" aria-hidden="true"></i></span>
                <span class="pack-button hint--top" id="editor-lockMovementY" aria-label="<?php echo __('Lock Y movement', 'product-designer'); ?>" ><i class="fa fa-arrows-h" aria-hidden="true"></i></span>
                <span class="pack-button hint--top" id="editor-lockRotation" aria-label="<?php echo __('Lock rotation', 'product-designer'); ?>" ><i class="fa fa-undo" aria-hidden="true"></i></span>
                <span class="pack-button hint--top" id="editor-lockScalingX" aria-label="<?php echo __('Lock X Scaling', 'product-designer'); ?>" ><i class="fa fa-expand" aria-hidden="true"></i></span>
                <span class="pack-button hint--top" id="editor-lockScalingY" aria-label="<?php echo __('Lock Y Scaling', 'product-designer'); ?>" ><i class="fa fa-expand" aria-hidden="true"></i></span>
                <span class="pack-button hint--top" aria-label="<?php echo __('Undo', 'product-designer'); ?>" id="editor-undo"><i class="cpd-icon-undo"></i></span>
                <span class="pack-button hint--top" aria-label="<?php echo __('Redo', 'product-designer'); ?>" id="editor-redo"><i class="cpd-icon-redo"></i></span>

            </div>





        </div>

        <div class="editor-actions toolbar-section">
            <div class="toolbar-section-inner">
                <div class="editor-preview pd-guide-6"><i class="fa fa-eye" aria-hidden="true"></i> <?php echo __('Preview', 'product-designer'); ?></div>
                <div class="editor-download pd-guide-7"><i class="fa fa-download" aria-hidden="true"></i> <?php echo __('Download', 'product-designer'); ?></div>
            </div>
        </div>



        <div class="object-list toolbar-section pd-guide-8">
            <div class="toolbar-title"><?php echo __('Items', 'product-designer'); ?></div>
            <div class="list-item scrollbar"><?php echo __('Get list', 'product-designer'); ?></div>

        </div>

        <div class="edit-text toolbar-section">
            <div class="toolbar-title"><?php echo __('Text Actions', 'product-designer'); ?></div>
            <div class="toolbar-section-inner">
                <textarea style="width: 90%" class="" id="text-content" aria-label="<?php echo __('Text Content', 'product-designer'); ?>"></textarea>

                <span class="pack-button hint--top" aria-label="<?php echo __('Bold text', 'product-designer'); ?>" id="text-bold"><i class="cpd-icon-format-bold" ></i></span>
                <span class="pack-button hint--top" aria-label="<?php echo __('Italic text', 'product-designer'); ?>" id="text-italic"><i class="cpd-icon-format-italic" ></i></span>
                <span class="pack-button hint--top" aria-label="<?php echo __('Underline text', 'product-designer'); ?>" id="text-underline"><i class="cpd-icon-format-underline" ></i></span>
                <span class="pack-button hint--top" aria-label="<?php echo __('Strikethrough text', 'product-designer'); ?>" id="text-strikethrough"><i class="fa fa-strikethrough" ></i></span>

                <div class="input-group">
                    <div class="input-group-title"><?php echo __('Fonts Size:', 'product-designer'); ?></div>
                    <input class="" id="font-size" size="3" aria-label="Fonts Size" type="number" value="16" >px
                </div>


                <div class="input-group">
                    <div class="input-group-title"><?php echo __('Text Color:', 'product-designer'); ?></div>
                    <input data-jscolor="" class="color  tool-button" id="font-color" aria-label="Text Color" placeholder="rgba(255,255,255,1)" type="text" value="rgba(255,255,255,1)">
                </div>

                <div class="input-group">
                    <div class="input-group-title"><?php echo __('Background Color:', 'product-designer'); ?></div>
                    <input data-jscolor="" class="color  tool-button" id="font-bg-color" aria-label="Background Color" placeholder="rgba(255,255,255,1)" type="text" value="rgba(255,255,255,1)">
                </div>


                <div class="input-group">
                    <div class="input-group-title"><?php echo __('Outline Color:', 'product-designer'); ?></div>
                    <input data-jscolor="" class="color  tool-button" id="stroke-color" aria-label="Outline Color" placeholder="rgba(255,255,255,1)" type="text" value="rgba(255,255,255,1)">
                </div>


                <div class="input-group">
                    <div class="input-group-title"><?php echo __('Text Outline:', 'product-designer'); ?></div>
                    <input class="" id="stroke-size" aria-label="Text Outline" type="number" placeholder="2" value="2">
                </div>
                <div class="input-group">
                    <div class="input-group-title"><?php echo __('Opacity:', 'product-designer'); ?></div>
                    <input  class=" tool-button" aria-label="Opacity" id="font-opacity" type="range" min="0" max="1" step="0.1" value="1" />
                </div>

                <div class="input-group">
                    <div class="input-group-title"><?php echo __('Font family:', 'product-designer'); ?></div>
                    <?php
                    $Tdesigner_google_fonts = Tdesigner_google_fonts();
                    ?>
                    <select class=" font-family" aria-label="<?php echo __('Font family', 'product-designer'); ?>" id="font-family">
                        <?php
                        foreach($Tdesigner_google_fonts as $font){
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



            <!--

                                <span class="" aria-label="Align left" id="text-align-left"><i class="fa fa-align-left" ></i></span>
                                <span class="" aria-label="Align center" id="text-align-center"><i class="fa fa-align-center" ></i></span>
                                <span class="" aria-label="Akign right" id="text-align-right"><i class="fa fa-align-right" ></i></span>

            -->


        </div>

        <div class="edit-curvedText toolbar-section">
            <div class="toolbar-title"><?php echo __('Curved Text Actions', 'product-designer'); ?></div>
            <div class="toolbar-section-inner">
                <textarea class="" id="curvedText-content" style="width: 90%" aria-label="<?php echo __('Text Content', 'product-designer'); ?>" rows="1"></textarea>
                <span class="pack-button hint--top" id="curvedText-bold" aria-label="<?php echo __('Bold text', 'product-designer'); ?>" ><i class="fa fa-bold" ></i></span>
                <span class="pack-button hint--top" id="curvedText-italic" aria-label="<?php echo __('Italic text', 'product-designer'); ?>" ><i class="fa fa-italic" ></i></span>
                <span class="pack-button hint--top" id="curvedText-underline" aria-label="<?php echo __('Underline text', 'product-designer'); ?>" ><i class="fa fa-underline" ></i></span>
                <span class="pack-button hint--top" id="curvedText-strikethrough" aria-label="<?php echo __('Strikethrough text', 'product-designer'); ?>" ><i class="fa fa-strikethrough" ></i></span>




                <div class="input-group">
                    <div class="input-group-title"><?php echo __('Font size:', 'product-designer'); ?></div>
                    <input class=" " aria-label="<?php echo __('Fonts', 'product-designer'); ?>" id="curvedText-font-size" type="number" value="16" />
                </div>

                <div class="input-group">
                    <div class="input-group-title"><?php echo __('Radius:', 'product-designer'); ?></div>
                    <input class="" aria-label="<?php echo __('Radius', 'product-designer'); ?>"  id="curvedText-radius" type="number" value="100" />
                </div>

                <div class="input-group">
                    <div class="input-group-title"><?php echo __('Spacing:', 'product-designer'); ?></div>
                    <input class="" aria-label="<?php echo __('Spacing', 'product-designer'); ?>"  id="curvedText-spacing" type="number" value="10" />
                </div>

                <div class="input-group">
                    <div class="input-group-title"><?php echo __('Color:', 'product-designer'); ?></div>
                    <input data-jscolor="" class="color " aria-label="Color" id="curvedText-font-color"  placeholder="<?php echo __('Color', 'product-designer'); ?>"  type="text" value="rgba(255,255,255,1)" />
                </div>
                <div class="input-group">
                    <div class="input-group-title"><?php echo __('Opacity:', 'product-designer'); ?></div>
                    <input  class="" aria-label="Opacity" id="curvedText-font-opacity" type="range" min="0" max="1" step="0.1" value="1" />
                </div>

                <div class="input-group">
                    <div class="input-group-title"><?php echo __('Font family:', 'product-designer'); ?></div>
                    <?php
                    $Tdesigner_google_fonts = Tdesigner_google_fonts();
                    ?>
                    <select class=" font-family" aria-label="<?php echo __('Font family', 'product-designer'); ?>" id="curvedText-font-family">
                        <?php
                        foreach($Tdesigner_google_fonts as $font){
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










        </div>









        <div class="edit-img toolbar-section">
            <div class="toolbar-title"><?php echo __('Images Actions', 'product-designer'); ?></div>
            <div class="toolbar-section-inner">
                <div class="input-group">
                    <div class="input-group-title"><?php echo __('Opacity:', 'product-designer'); ?></div>
                    <input  class="" aria-label="Opacity" id="img-opacity" type="range" min="0" max="1" step="0.1" value="1" />
                </div>

                <div class="input-group">
                    <div class="input-group-title"><?php echo __('Filters:', 'product-designer'); ?></div>
                    <label><input class="" aria-label="<?php echo __('Grayscale', 'product-designer'); ?>"  id="img-filter-grayscale" type="checkbox" value="1" /><?php echo __('Grayscale', 'product-designer'); ?></label>
                </div>

                <div class="input-group">
                    <div class="input-group-title"></div>
                    <label><input class="" aria-label="<?php echo __('Invert', 'product-designer'); ?>"  id="img-filter-invert" type="checkbox" value="1" /><?php echo __('Invert', 'product-designer'); ?></label>
                </div>

                <div class="input-group">
                    <div class="input-group-title"></div>
                    <label><input class="" aria-label="<?php echo __('Sepia', 'product-designer'); ?>"  id="img-filter-sepia" type="checkbox" value="1" /><?php echo __('Sepia', 'product-designer'); ?></label>
                </div>
                <div class="input-group">
                    <div class="input-group-title"></div>
                    <label><input class="" aria-label="<?php echo __('Noise', 'product-designer'); ?>"  id="img-filter-noise" type="checkbox" value="1" /><?php echo __('Noise', 'product-designer'); ?></label>
                </div>

                <div class="input-group">
                    <div class="input-group-title"></div>
                    <label><input class="" aria-label="<?php echo __('Pixelate', 'product-designer'); ?>"  id="img-filter-pixelate" type="checkbox" value="1" /><?php echo __('Pixelate', 'product-designer'); ?></label>
                </div>
            </div>








        </div>

        <div class="edit-shape toolbar-section">
            <div class="toolbar-title"><?php echo __('Shapes Actions', 'product-designer'); ?></div>
            <div class="toolbar-section-inner">
                <div class="input-group">
                    <div class="input-group-title"><?php echo __('Opacity:', 'product-designer'); ?></div>
                    <input  class="" aria-label="Opacity" id="shape-opacity" type="range" min="0" max="1" step="0.1" value="1" />
                </div>
                <div class="input-group">
                    <div class="input-group-title"><?php echo __('Color:', 'product-designer'); ?></div>
                    <input  data-jscolor="" aria-label="<?php echo __('Color', 'product-designer'); ?>" id="shape-color" class="color " placeholder="<?php echo __('Color', 'product-designer'); ?>"  type="text" value="rgba(255,255,255,1)" />
                </div>
            </div>


        </div>


        <div class="product-info toolbar-section pd-guide-9">
            <div class="toolbar-title"><?php echo __('Product info', 'product-designer'); ?></div>
            <div class="toolbar-section-inner">
                <form class="cart" enctype="multipart/form-data" method="post" action="#">
                    <input type="hidden" value="<?php echo $product_id; ?>" name="add-to-cart">
                    <input type="hidden" value="<?php echo $pd_template_id; ?>" name="pd_template_id">


                        <?php
                        $product_data = wc_get_product($product_id);
                        $is_variable = $product_data->is_type('variable');
                        $product_price = '';

                        //var_dump(product_designer_is_customizable($product_id));

                        if($is_variable){

                            $variation_id = isset($_GET['variation_id']) ? sanitize_text_field($_GET['variation_id']) : '';
                            $variation_data= new WC_Product_Variation( $variation_id );

                            $sale_price = $variation_data->get_sale_price();
                            $regular_price = $variation_data->get_regular_price();

                            $currency_symbol = get_woocommerce_currency_symbol();

                            if(empty($sale_price)){

                            }
                            else{
                                $product_price = '<strike>'.$currency_symbol.$regular_price.'</strike> - '.$currency_symbol.$sale_price;
                            }

                            ?>
                            <input type="hidden"  name="variation_id" value="<?php echo $variation_id; ?>">
                            <?php

                        }
                        else{
                            $product_price = $product_data->get_price_html();
                        }


                        ?>
                        <div class="input-group">
                            <div class="input-group-title"><?php echo __('You are editing:', 'product-designer'); ?></div><span><?php echo get_the_title($product_id); ?></span>
                        </div>
                        <div class="input-group">
                            <div class="input-group-title"><?php echo __('Base Price:', 'product-designer'); ?></div> <span><?php echo $product_price; ?></span>
                        </div>
                        <div class="input-group">
                            <div class="input-group-title"><?php echo __('Quantity:', 'product-designer'); ?></div> <span><input class="input-text quantity text" type="number" size="4" aria-label="<?php echo __('Quantity', 'product-designer'); ?>" value="1" name="quantity" min="1" step="1"></span>

                        </div>
                   


                    <div class="input-group product">

                        <button class="generate-side-output"><?php echo __('Generate', 'product-designer'); ?> </button>
                        <div class="output-side-items">

                        </div>
                        <br>
                        <div class="output-side-items-attach-ids">

                        </div>

                        <div class="output-side-items-json">

                        </div>


                        <br>

                        <button class="pd-addtocart button alt addtocart" type="submit" name="addtocart" value="addtocart"><?php echo __('Add to cart', 'product-designer'); ?></button>


                    </div>
                </form>
            </div>


        </div>









    </div>

    <?php
}



add_action('product_designer_editor', 'product_designer_canvas', 25);

function product_designer_canvas(){
    $product_designer_canvas_width = get_option( 'product_designer_canvas_width', '500' );
    $product_designer_canvas_height = get_option( 'product_designer_canvas_height', '600' );

    ?>
    <div id="designer" class="designer">
        <canvas id="c" width="<?php echo $product_designer_canvas_width; ?>" height="<?php echo $product_designer_canvas_height; ?>"></canvas>
    </div>
    <?php
}





add_action('product_designer_editor', 'product_designer_scripts', 30);

function product_designer_scripts(){

    $product_id = isset($_GET['product_id']) ? sanitize_text_field($_GET['product_id']) : '';
    $session_id = session_id();
    $Tdesigner_google_fonts = Tdesigner_google_fonts();


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




    $wc_currency_symbol = get_woocommerce_currency_symbol();

    $canvas_settings['width'] = isset($canvas_settings['width']) ? $canvas_settings['width'] : '500';
    $canvas_settings['height'] = isset($canvas_settings['height']) ? $canvas_settings['height'] : '500';

    $product_data = wc_get_product($product_id);
    $product_type = $product_data->get_type();



    $product_designer_editor['product_type']  = $product_type;

    if($product_type == 'variable'){

        $variation_id = isset($_GET['variation_id']) ? sanitize_text_field($_GET['variation_id']) : '';

        $product_designer_editor['variation_id']  = $variation_id;


        $variation_data = new WC_Product_Variation( $variation_id );

        $sale_price = $variation_data->get_sale_price();
        $regular_price = $variation_data->get_regular_price();

        if(!empty($sale_price)){
            $product_base_price = $sale_price;
            $product_display_price = '<strike>'.$wc_currency_symbol.$regular_price.'</strike> - '.$wc_currency_symbol.$sale_price;;
        }
        else{
            $product_base_price = $regular_price;
            $product_display_price = $wc_currency_symbol.$regular_price;;
        }

        $product_designer_editor['product_base_price']  = $product_base_price;
        $product_designer_editor['product_display_price']  = $product_display_price;


    }
    elseif ($product_type == 'simple'){



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

        $product_designer_editor['product_base_price']  = $product_base_price;
        $product_designer_editor['product_display_price']  = $product_display_price;

    }






    $product_designer_editor['product_id']  = $product_id;


    $product_designer_editor['product_title']  = get_the_title($product_id);
    $product_designer_editor['wc_currency_symbol']  = $wc_currency_symbol;

    $product_designer_editor['session_id']  = $session_id;

    $product_designer_editor['width']  = isset($canvas_settings['width']) ? $canvas_settings['width'] : '';
    $product_designer_editor['height']  = isset($canvas_settings['height']) ? $canvas_settings['height'] : '';


    $product_designer_editor['output_file_format']  = isset($canvas_settings['output']['file_format']) ? $canvas_settings['output']['file_format'] : 'png';
    $product_designer_editor['preview_file_format']  = isset($canvas_settings['preview']['file_format']) ? $canvas_settings['preview']['file_format'] : 'png';


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

    $product_designer_editor['tour_guide']  = array(

        'tour_hide'=>false,
        'tour_complete'=>false,
        'enable'=> true,

    );



    $product_designer_editor['cart_attach_ids']  = array();


    ?>

    <script>
        //jQuery(document).ready(function($){

            var product_designer_editor = <?php echo json_encode($product_designer_editor); ?>;

            //console.log(product_designer_editor);

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
            canvas.setHeight(<?php echo $canvas_settings['height']; ?>);
            canvas.setWidth(<?php echo $canvas_settings['width']; ?>);

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
        foreach($Tdesigner_google_fonts as $font){


            $Fontname = $font['name'];
            $name = str_replace(' ','+',$Fontname);

            if(!empty($font['src'])){
                $src = isset($font['src']) ? esc_url_raw($font['src']) : '';
                ?>
        @font-face {
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




        if(!empty($side_data))
        foreach($side_data as $id=>$side){
            $src = isset($side['src']) ? $side['src'] : '';

            if($current_side==$id){

                ?>

        .canvas-container{

        }


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

function product_designer_welcome_tour(){

    ?>
    <div class="welcome-tour">
        <div class="inner-content">
            <h2 class="headeline"><?php echo __('Welcome to the Product Designer', "product-designer"); ?></h2>
            <p class="details"><?php echo __('Please see the welcome guide to see how the editor work and get stunning product design.', "product-designer"); ?></p>
            <button class="start-tour"><?php echo __('Start Tour', "product-designer"); ?></button>
            <button class="end-tour"><?php echo __('End Tour', "product-designer"); ?></button>
        </div>
    </div>
    <?php

}



add_action('product_designer_editor', 'product_designer_preview', 45);

function product_designer_preview(){

    ?>
    <div class="preview">
        <div class="preview-img">
            <span class="preview-close"><i class="fa fa-times" aria-hidden="true"></i></span>
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


add_action('product_designer_editor', 'product_designer_wrap_end', 99);

function product_designer_wrap_end(){

    ?>

    </div>
    <?php

}

