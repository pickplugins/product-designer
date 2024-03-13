<?php

/*
* @Author 		PickPlugins
*/

if ( ! defined('ABSPATH')) exit;  // if direct access



add_action('product_designer_template_metabox_content_canvas', 'product_designer_template_metabox_content_canvas', 10);

function product_designer_template_metabox_content_canvas( $post_id){

    $settings_tabs_field = new settings_tabs_field();

    $canvas = get_post_meta($post_id, 'canvas', true);

    $canvas_width = !empty($canvas['width']) ? $canvas['width'] : '500';
    $canvas_height = !empty($canvas['height']) ? $canvas['height'] : '500';
    $output_file_format = !empty($canvas['output']['file_format']) ? $canvas['output']['file_format'] : 'jpeg';
    $enable_preview = !empty($canvas['preview']['enable']) ? $canvas['preview']['enable'] : 'yes';
    $preview_file_format = !empty($canvas['preview']['file_format']) ? $canvas['preview']['file_format'] : 'jpeg';
    $bg_color = !empty($canvas['bg_color']) ? $canvas['bg_color'] : '';
    $enable_tile_bg = !empty($canvas['enable_tile_bg']) ? $canvas['enable_tile_bg'] : '';
    $tile_bg_src = !empty($canvas['tile_bg_src']) ? $canvas['tile_bg_src'] : '';


    ?>
    <div class="section">
        <div class="section-title"><?php echo __('Canvas settings', 'product-designer'); ?></div>
        <p class="description section-description"><?php echo __('Choose options for canvas.', 'product-designer'); ?></p>

        <?php

        $args = array(
            'id'		=> 'width',
            'parent'		=> 'canvas',
            'title'		=> __('Canvas width','product-designer'),
            'details'	=> __('Set canvas width.','product-designer'),
            'type'		=> 'text',
            'value'		=> $canvas_width,
            'default'		=> '',
        );

        $settings_tabs_field->generate_field($args, $post_id);


        $args = array(
            'id'		=> 'height',
            'parent'		=> 'canvas',
            'title'		=> __('Canvas height','product-designer'),
            'details'	=> __('Set canvas height.','product-designer'),
            'type'		=> 'text',
            'value'		=> $canvas_height,
            'default'		=> '',
        );

        $settings_tabs_field->generate_field($args, $post_id);

        $args = array(
            'id'		=> 'bg_color',
            'parent'		=> 'canvas',
            'title'		=> __('Background color','product-designer'),
            'details'	=> __('Set canvas background color.','product-designer'),
            'type'		=> 'colorpicker',
            'value'		=> $bg_color,
            'default'		=> '',
        );

        $settings_tabs_field->generate_field($args, $post_id);


        $args = array(
            'id'		=> 'enable_tile_bg',
            'parent'		=> 'canvas',
            'title'		=> __('Enable tile background','product-designer'),
            'details'	=> __('Enable tile background for canvas container.','product-designer'),
            'type'		=> 'radio',
            'value'		=> $enable_tile_bg,
            'default'		=> 'no',
            'args'		=> array(
                'no'=>__('No','product-designer'),
                'yes'=>__('Yes','product-designer'),
            ),
        );

        $settings_tabs_field->generate_field($args, $post_id);

        $args = array(
            'id'		=> 'tile_bg_src',
            'parent'		=> 'canvas',
            'title'		=> __('Tile background source','product-designer'),
            'details'	=> __('Tile background image source for canvas container.','product-designer'),
            'type'		=> 'media_url',
            'value'		=> $tile_bg_src,
            'default'		=> product_designer_plugin_url.'assets/front/images/tile.png',

        );

        $settings_tabs_field->generate_field($args, $post_id);




        $args = array(
            'id'		=> 'file_format',
            'parent'		=> 'canvas[output]',
            'title'		=> __('Output file format','product-designer'),
            'details'	=> __('Choose output file format.','product-designer'),
            'type'		=> 'radio',
            'value'		=> $output_file_format,
            'default'		=> 'jpeg',
            'args'		=> array(
                'jpeg'=>__('JPEG','product-designer'),
                'png'=>__('PNG','product-designer'),
                'svg'=>__('SVG','product-designer'),

            ),
        );

        $settings_tabs_field->generate_field($args, $post_id);

        $args = array(
            'id'		=> 'enable',
            'parent'		=> 'canvas[preview]',
            'title'		=> __('Enable preview','product-designer'),
            'details'	=> __('Choose enable preview.','product-designer'),
            'type'		=> 'radio',
            'value'		=> $enable_preview,
            'default'		=> 'yes',
            'args'		=> array(
                'yes'=>__('Yes','product-designer'),
                'no'=>__('No','product-designer'),

            ),
        );

        $settings_tabs_field->generate_field($args, $post_id);


        $args = array(
            'id'		=> 'file_format',
            'parent'		=> 'canvas[preview]',
            'title'		=> __('Preview file format','post-grid'),
            'details'	=> __('Choose preview file format.','post-grid'),
            'type'		=> 'radio',
            'value'		=> $preview_file_format,
            'default'		=> 'jpeg',
            'args'		=> array(
                'jpeg'=>__('JPEG','post-grid'),
                'png'=>__('PNG','post-grid'),
                'svg'=>__('SVG','post-grid'),

            ),
        );

        $settings_tabs_field->generate_field($args, $post_id);


        ?>


    </div>



    <?php

}




add_action('product_designer_template_metabox_content_product_sides', 'product_designer_template_metabox_content_product_sides', 10);

function product_designer_template_metabox_content_product_sides( $post_id){

    $settings_tabs_field = new settings_tabs_field();


    $side_data = get_post_meta( $post_id, 'side_data', true );


    ?>
    <div class="section">
        <div class="section-title"><?php echo __('Product sides', 'post-grid'); ?></div>
        <p class="description section-description"><?php echo __('Choose options for product sides.', 'post-grid'); ?></p>

        <?php

        ob_start();

        ?>
        <div class="product-sides">
            <div class="side-list">

                <?php



                $previw_icon = product_designer_plugin_url.'assets/admin/images/add-img.png';
                $previw_background = product_designer_plugin_url.'assets/admin/images/add-img-bg.png';
                $previw_overlay = product_designer_plugin_url.'assets/admin/images/add-img-overlay.png';



                if(!empty($side_data)){

                    foreach($side_data as $id=>$side){

                        $name = isset( $side['name']) ? $side['name'] : '';
                        $icon = isset($side['icon']) ? $side['icon'] : '';
                        $background = isset($side['background'])? $side['background'] : '';
                        $inc_output_background = isset($side['inc_output_background']) ? $side['inc_output_background'] : '0';
                        $inc_preview_background = isset($side['inc_preview_background']) ? $side['inc_preview_background'] : '0';
                        $background_fit_canvas_size = isset($side['background_fit_canvas_size']) ? $side['background_fit_canvas_size'] : '0';
                        $overlay = isset($side['overlay']) ? $side['overlay'] : array();
                        $inc_output_overlay = isset($side['inc_output_overlay']) ? $side['inc_output_overlay'] : '0';
                        $inc_preview_overlay = isset($side['inc_preview_overlay']) ? $side['inc_preview_overlay'] : '0';
                        $overlay_fit_canvas_size = isset($side['overlay_fit_canvas_size']) ? $side['overlay_fit_canvas_size'] : '0';


                        ?>

                        <div class="side">
                            <div class="inline actions">
                                <span class="remove"><i class="fa fa-times"></i></span>
                                <span class="move"><i class="fa fa-bars"></i></span>
                            </div>


                            <div class="inline side-name">
                                <div class=""><?php echo __('Name', 'product-designer'); ?></div>
                                <input placeholder="<?php echo __('Name', 'product-designer'); ?>" type="text" name="side_data[<?php echo $id; ?>][name]" value="<?php echo $name; ?>" />
                            </div>
                            <div class="inline side-icon">
                                <div class=""><?php echo __('Icon', 'product-designer'); ?></div>
                                <input type="hidden" placeholder="" name="side_data[<?php echo $id; ?>][icon]" value="<?php echo $icon; ?>" />
                                <img class="upload_side preview"  src="<?php if(!empty($icon)) echo $icon; else echo $previw_icon; ?>">
                                <div data-preview="<?php echo $previw_icon; ?>" class="side-part-remove button"><?php echo __('Remove', 'product-designer'); ?></div>
                            </div>

                            <div class="inline side-bg-inc">
                                <div class=""><?php echo __('Background', 'product-designer'); ?></div>
                                <input type="hidden" placeholder="" name="side_data[<?php echo $id; ?>][background]" value="<?php echo $background; ?>" />
                                <img class="upload_side preview"  src="<?php if(!empty($background)) echo $background; else echo $previw_background; ?>">
                                <div data-preview="<?php echo $previw_background; ?>" class="side-part-remove button"><?php echo __('Remove', 'product-designer'); ?></div><br>
                                <label><input type="checkbox" value="1" <?php if($inc_output_background==1) echo 'checked'; ?> name="side_data[<?php echo $id; ?>][inc_output_background]"><?php echo __('Include background in output', 'product-designer'); ?></label><br>
                                <label><input type="checkbox" value="1" <?php if($inc_preview_background==1) echo 'checked'; ?> name="side_data[<?php echo $id; ?>][inc_preview_background]"><?php echo __('Include background in preview', 'product-designer'); ?></label><br>
                                <label><input type="checkbox" value="1" <?php if($background_fit_canvas_size==1) echo 'checked'; ?> name="side_data[<?php echo $id; ?>][background_fit_canvas_size]"><?php echo __('Fit with canvas size', 'product-designer'); ?></label>





                            </div>

                            <div class="inline side-bg-not-inc">
                                <div class=""><?php echo __('Overlay', 'product-designer'); ?></div>
                                <input type="hidden" placeholder="" name="side_data[<?php echo $id; ?>][overlay]" value="<?php echo $overlay; ?>" />
                                <img class="upload_side preview"  src="<?php if(!empty($overlay)) echo $overlay; else echo $previw_overlay; ?>">
                                <div data-preview="<?php echo $previw_overlay; ?>" class="side-part-remove button">Remove</div><br>
                                <label><input type="checkbox" value="1" <?php if($inc_output_overlay==1) echo 'checked'; ?> name="side_data[<?php echo $id; ?>][inc_output_overlay]"><?php echo __('Include Overlay in output', 'product-designer'); ?></label><br>
                                <label><input type="checkbox" value="1" <?php if($inc_preview_overlay==1) echo 'checked'; ?> name="side_data[<?php echo $id; ?>][inc_preview_overlay]"><?php echo __('Include Overlay in preview', 'product-designer'); ?></label><br>
                                <label><input type="checkbox" value="1" <?php if($overlay_fit_canvas_size==1) echo 'checked'; ?> name="side_data[<?php echo $id; ?>][overlay_fit_canvas_size]"><?php echo __('Fit with canvas size', 'product-designer'); ?></label>




                            </div>


                        </div>


                        <?php


                    }
                }
                else{

                    $id = time();
                    $name = '';
                    $icon = '';
                    $background = '';
                    $inc_output_background = 1;
                    $inc_preview_background = 1;
                    $background_fit_canvas_size = 1;
                    $overlay = '';
                    $inc_output_overlay = 1;
                    $inc_preview_overlay = 1;
                    $overlay_fit_canvas_size = 1;
                    ?>
                    <div class="side">
                        <div class="inline actions">
                            <div class=""><?php echo __('Actions', 'product-designer'); ?></div>
                            <span class="remove"><i class="fa fa-times"></i></span>
                            <span class="move"><i class="fa fa-bars"></i></span>
                        </div>


                        <div class="inline side-name">
                            <div class=""><?php echo __('Name', 'product-designer'); ?></div>
                            <input placeholder="<?php echo __('Name', 'product-designer'); ?>" type="text" name="side_data[<?php echo $id; ?>][name]" value="<?php echo $name; ?>" />
                        </div>
                        <div class="inline side-icon">
                            <div class=""><?php echo __('Icon', 'product-designer'); ?></div>
                            <input type="hidden" placeholder="" name="side_data[<?php echo $id; ?>][icon]" value="<?php echo $icon; ?>" />
                            <img class="upload_side preview"  src="<?php if(!empty($icon)) echo $icon; else echo $previw_icon; ?>">
                            <div data-preview="<?php echo $previw_icon; ?>" class="side-part-remove button"><?php echo __('Remove', 'product-designer'); ?></div>
                        </div>

                        <div class="inline side-bg-inc">
                            <div class=""><?php echo __('Background', 'product-designer'); ?></div>
                            <input type="hidden" placeholder="" name="side_data[<?php echo $id; ?>][background]" value="<?php echo $background; ?>" />
                            <img class="upload_side preview"  src="<?php if(!empty($background)) echo $background; else echo $previw_background; ?>">
                            <div data-preview="<?php echo $previw_background; ?>" class="side-part-remove button"><?php echo __('Remove', 'product-designer'); ?></div><br>
                            <label><input type="checkbox" value="1" <?php if($inc_output_background==1) echo 'checked'; ?> name="side_data[<?php echo $id; ?>][inc_output_background]"><?php echo __('Include background in output', 'product-designer'); ?></label><br>
                            <label><input type="checkbox" value="1" <?php if($inc_preview_background==1) echo 'checked'; ?> name="side_data[<?php echo $id; ?>][inc_preview_background]"><?php echo __('Include background in preview', 'product-designer'); ?></label><br>
                            <label><input type="checkbox" value="1" <?php if($background_fit_canvas_size==1) echo 'checked'; ?> name="side_data[<?php echo $id; ?>][background_fit_canvas_size]"><?php echo __('Fit with canvas size', 'product-designer'); ?></label>





                        </div>

                        <div class="inline side-bg-not-inc">
                            <div class="">Overlay</div>
                            <input type="hidden" placeholder="" name="side_data[<?php echo $id; ?>][overlay]" value="<?php echo $overlay; ?>" />
                            <img class="upload_side preview"  src="<?php if(!empty($overlay)) echo $overlay; else echo $previw_overlay; ?>">
                            <div data-preview="<?php echo $previw_overlay; ?>" class="side-part-remove button"><?php echo __('Remove', 'product-designer'); ?></div><br>
                            <label><input type="checkbox" value="1" <?php if($inc_output_overlay==1) echo 'checked'; ?> name="side_data[<?php echo $id; ?>][inc_output_overlay]">Include Overlay in output</label><br>
                            <label><input type="checkbox" value="1" <?php if($inc_preview_overlay==1) echo 'checked'; ?> name="side_data[<?php echo $id; ?>][inc_preview_overlay]">Include Overlay in preview</label><br>
                            <label><input type="checkbox" value="1" <?php if($overlay_fit_canvas_size==1) echo 'checked'; ?> name="side_data[<?php echo $id; ?>][overlay_fit_canvas_size]">Fit with canvas size</label>




                        </div>


                    </div>
                    <?php

                }


                ?>


            </div>


            <br />
            <input type="button" class="button add_side" value="<?php echo __('Add more', 'product-designer'); ?>" />


        </div>

        <script>
            jQuery(document).ready(function($)
            {

                $(document).on('click','.add_side',function(){

                    now = 'side_id_'+$.now();


                    html = '<div class="side">\n' +
                        '<div class="inline actions">\n' +
                        '<span class="remove"><i class="fa fa-times"></i></span>\n' +
                        '<span class="move ui-sortable-handle"><i class="fa fa-bars"></i></span>\n' +
                        '</div>\n' +
                        '<div class="inline side-name">\n' +
                        '<div class=""></div>\n' +
                        '<input placeholder="Name" name="side_data['+now+'][name]" value="" type="text">\n' +
                        '</div>\n' +
                        '<div class="inline side-icon">\n' +
                        '<div class="">Icon</div>\n' +
                        '<input placeholder="" name="side_data['+now+'][icon]" value="" type="hidden">\n' +
                        '<img class="upload_side preview" src="<?php echo $previw_icon; ?>">\n' +
                        '<div data-preview="" class="side-part-remove button">Remove</div>\n' +
                        '</div>\n' +
                        '<div class="inline side-bg-inc">\n' +
                        '<div class="">Background</div>\n' +
                        '<input placeholder="" name="side_data['+now+'][background]" value="" type="hidden">\n' +
                        '<img class="upload_side preview" src="<?php echo $previw_background; ?>">\n' +
                        '<div data-preview="" class="side-part-remove button">Remove</div><br>\n' +
                        '<label><input value="1" checked="" name="side_data['+now+'][inc_output_background]" type="checkbox">Include background in output</label><br>\n' +
                        '<label><input value="1" checked="" name="side_data['+now+'][inc_preview_background]" type="checkbox">Include background in preview</label><br>\n' +
                        '<label><input value="1" checked="" name="side_data['+now+'][background_fit_canvas_size]" type="checkbox">Fit with canvas size</label>\n' +
                        '</div>\n' +
                        '<div class="inline side-bg-not-inc">\n' +
                        '<div class="">Overlay</div>\n' +
                        '<input placeholder="" name="side_data['+now+'][overlay]" value="" type="hidden">\n' +
                        '<img class="upload_side preview" src="<?php echo $previw_overlay; ?>">\n' +
                        '<div data-preview="" class="side-part-remove button">Remove</div><br>\n' +
                        '<label><input value="1" checked="" name="side_data['+now+'][inc_output_overlay]" type="checkbox">Include Overlay in output</label><br>\n' +
                        '<label><input value="1" checked="" name="side_data['+now+'][inc_preview_overlay]" type="checkbox">Include Overlay in preview</label><br>\n' +
                        '<label><input value="1" checked="" name="side_data['+now+'][overlay_fit_canvas_size]" type="checkbox">Fit with canvas size</label>\n' +
                        '</div>\n' +
                        '</div>';









                    //html = '<div class="side"><span class="remove"><i class="fa fa-times"></i></span> <span class="move"><i class="fa fa-bars"></i></span> <input placeholder="<?php echo __('Name', 'product-designer'); ?>" type="text" name="side_data['+now+'][name]" value="" /> <input type="text" placeholder="http://" name="side_data['+now+'][src]" value="" /> <span class="button upload_side" ><i class="fa fa-crosshairs"></i> <?php echo __('Upload', 'product-designer'); ?></span></div>';
                    $('.side-list').append(html);

                    //alert(html);

                })




            })
        </script>
        <?php


        $html = ob_get_clean();

        $args = array(
            'id'		=> 'side_data',
            'parent'		=> 'canvas',
            'title'		=> __('Product sides','post-grid'),
            'details'	=> __('Set product sides.','post-grid'),
            'type'		=> 'custom_html',
            'html'		=> $html,
        );

        $settings_tabs_field->generate_field($args, $post_id);



        ?>


    </div>



    <?php

}





add_action('product_designer_template_metabox_save','product_designer_template_metabox_save');

function product_designer_template_metabox_save($job_id){

    $canvas = isset($_POST['canvas']) ? product_designer_recursive_sanitize_arr($_POST['canvas']) : '';
    update_post_meta($job_id, 'canvas', $canvas);

    $side_data= isset($_POST['side_data']) ? product_designer_recursive_sanitize_arr($_POST['side_data']) : '';
    update_post_meta($job_id, 'side_data', $side_data);

    $templates = isset($_POST['templates']) ? product_designer_recursive_sanitize_arr($_POST['templates']) : '';
    update_post_meta($job_id, 'templates', $templates);

}



