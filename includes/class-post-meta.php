<?php



if ( ! defined('ABSPATH')) exit;  // if direct access 	


class class_product_designer_post_meta  {
	
	
    public function __construct(){

		
		add_action('add_meta_boxes', array( $this, 'product_designer_meta_boxes' ));
	   // add_action( 'save_post', array( $this, 'product_designer_pd_template_meta_save' ) );
//		add_action( 'save_post', array( $this, 'product_designer_clipart_meta_save' ) );
	    add_action( 'save_post', array( $this, 'product_designer_save_postdata' ) );
	    //add_action( 'save_post', array( $this, 'product_meta_save_postdata' ) );

		
    }


	public function product_designer_meta_boxes(){

		//add_meta_box('product_designer_pd_template_meta_box', __( 'Template Options', 'product-designer' ), array( $this, 'product_designer_pd_template_meta' ), 'pd_template' );
//		add_meta_box('product_designer_clipart_meta_box', __( 'Clip Art Options', 'product-designer' ), array( $this, 'product_designer_clipart_meta' ), 'clipart' );
		add_meta_box('product_designer_wc_order_meta_box', __( 'Product Designer data', 'product-designer' ), array( $this, 'product_designer_wc_order_meta' ), 'shop_order' );
		//add_meta_box( 'product_designer_add_images', __( 'Product Designer Options', 'product-designer' ), array( $this, 'product_designer_inner_custom_box' ), 'pd_template' );
		//add_meta_box( 'product_designer', __( 'Product Designer', 'product-designer' ), array( $this, 'product_designer_product_metabox' ), 'product' );



    }


	function product_designer_product_metabox( $post ) {


		wp_nonce_field( 'product_designer_clipart_meta', 'clipart_meta_nonce' );

		$pd_template_id = get_post_meta( $post->ID, 'pd_template_id', true );


		?>
        <div class="">
            <p>
                Price:<br>
                <input type="text" placeholder="2" name="pd_template_id" value="<?php echo $pd_template_id; ?>" />
            </p>
        </div>
		<?php

	}




	function product_designer_pd_template_meta( $post ) {


		wp_nonce_field( 'product_designer_clipart_meta', 'clipart_meta_nonce' );

		$clipart_price = get_post_meta( $post->ID, 'clipart_price', true );


		?>
        <div class="">
            <p>
                Price:<br>
                <input type="text" placeholder="2" name="clipart_price" value="<?php echo $clipart_price; ?>" />
            </p>
        </div>
		<?php

	}



	
function product_designer_clipart_meta( $post ) {


		wp_nonce_field( 'product_designer_clipart_meta', 'clipart_meta_nonce' );
		
		$clipart_price = get_post_meta( $post->ID, 'clipart_price', true );
		
		
		?>
        <div class="">
            <p>
            Price:<br>
            <input type="text" placeholder="2" name="clipart_price" value="<?php echo $clipart_price; ?>" />
            </p>
        </div>
        <?php
		
	}




	function product_designer_pd_template_meta_save( $post_id ) {



		if ( ! isset( $_POST['clipart_meta_nonce'] ) )
			return $post_id;

		$nonce = isset($_POST['clipart_meta_nonce']) ? sanitize_text_field($_POST['clipart_meta_nonce']) : '';

		if ( ! wp_verify_nonce( $nonce, 'product_designer_clipart_meta' ) )
			return $post_id;


		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
			return $post_id;


		if ( 'page' == $_POST['post_type'] ) {

			if ( ! current_user_can( 'edit_page', $post_id ) )
				return $post_id;

		} else {

			if ( ! current_user_can( 'edit_post', $post_id ) )
				return $post_id;
		}

		$clipart_price = isset($_POST['clipart_price']) ? sanitize_text_field($_POST['clipart_price']) : '';
		update_post_meta( $post_id, 'clipart_price', $clipart_price );

	}




	function product_meta_save_postdata( $post_id ) {



		if ( ! isset( $_POST['clipart_meta_nonce'] ) )
			return $post_id;

		$nonce = isset($_POST['clipart_meta_nonce']) ? sanitize_text_field($_POST['clipart_meta_nonce']) : '';

		if ( ! wp_verify_nonce( $nonce, 'product_designer_clipart_meta' ) )
			return $post_id;


		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
			return $post_id;


		if ( 'page' == $_POST['post_type'] ) {

			if ( ! current_user_can( 'edit_page', $post_id ) )
				return $post_id;

		} else {

			if ( ! current_user_can( 'edit_post', $post_id ) )
				return $post_id;
		}

		$pd_template_id = isset($_POST['pd_template_id']) ? sanitize_text_field($_POST['pd_template_id']) : '';
		update_post_meta( $post_id, 'pd_template_id', $pd_template_id );

	}














	function product_designer_clipart_meta_save( $post_id ) {



		if ( ! isset( $_POST['clipart_meta_nonce'] ) )
			return $post_id;

		$nonce = isset($_POST['clipart_meta_nonce']) ? sanitize_text_field($_POST['clipart_meta_nonce']) : '';

		if ( ! wp_verify_nonce( $nonce, 'product_designer_clipart_meta' ) )
			return $post_id;


		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
			return $post_id;


		if ( 'page' == $_POST['post_type'] ) {

			if ( ! current_user_can( 'edit_page', $post_id ) )
				return $post_id;

		} else {

			if ( ! current_user_can( 'edit_post', $post_id ) )
				return $post_id;
		}

		$clipart_price =  sanitize_text_field($_POST['clipart_price']);
		update_post_meta( $post_id, 'clipart_price', $clipart_price );

	}























	
	
function product_designer_wc_order_meta( $post ) {


		wp_nonce_field( 'product_designer_wc_order_meta', 'product_designer_wc_order_meta_nonce' );
		
		$tdesigner_custom_design = get_post_meta( $post->ID, 'tdesigner_custom_design', true );
		
		$order = wc_get_order( $post->ID );
		$order_items = $order->get_items();







		?>
        <table class="product-designer settings-tabs order-items widefat">

            <thead>
                <tr>
                    <td><?php echo __('Sides', 'product-designer'); ?></td>
                    <td style="text-align: center;"><?php echo __('Preview', 'product-designer'); ?></td>
                    <td><?php echo __('Objects', 'product-designer'); ?></td>
                </tr>
            </thead>

            <?php

            if(!empty($order_items))
            foreach ($order_items as $order_item_id => $order_item) {


                //echo '<pre>'.var_export($order_item, true).'</pre>';


	            $product_id = $order_item['product_id'];
	            $product_title = get_the_title($product_id);
	            $pd_template_id = get_post_meta( $product_id, 'pd_template_id', true );
	            $side_data = get_post_meta( $pd_template_id, 'side_data', true );






                $item_meta = wc_get_order_item_meta($order_item_id, 'product_designer_side_attach_ids');
                $side_ids_json = wc_get_order_item_meta($order_item_id, 'product_designer_side_ids_json');


                //$item_meta = unserialize($item_meta);
	            $custom_design = wc_get_order_item_meta($order_item_id, 'custom_design');



	            //echo '<pre>'.var_export($side_ids_json, true).'</pre>';


                ?>


                <tr class="item alternate">
                    <td width="100" class="name" colspan="3">
	                   <?php echo __('Product title:', 'product-designer'); ?> <strong><?php echo $product_title; ?></strong>

                    </td>


                </tr>
	            <?php




	            if(!empty($item_meta))
	            foreach($item_meta as $side_id=> $attach_id){

		            $attach_url = wp_get_attachment_url( $attach_id );
                    $side_objects = isset($side_ids_json[$side_id]) ? $side_ids_json[$side_id] : array();





                    ?>
                    <tr class="item">
                        <td width="100" class="name">
                            <?php
                            if(!empty($side_data[$side_id]['name']))
                            echo $side_data[$side_id]['name'];
                            ?>

                        </td>
                        <td class="">
                            <div class="pd-preview-src" style="text-align: center;">
                                <img  style="width: 100px" src="<?php echo esc_url_raw($attach_url); ?>" />

                            </div>
                            <div data-src="<?php echo esc_url_raw($attach_url); ?>" class="button download-btn">Download</div>
                        </td>
                        <td class="">

                            <div class="expandable">
                                <?php

                                $objects = !empty($side_objects) ? json_decode($side_objects)->objects : array();




                                if(!empty($objects))
                                    foreach($objects as $key=> $object){

                                        $object_type = isset($object->type) ? $object->type : '';
                                        $object_price = isset($object->price) ? $object->price : '';

                                        //echo '<pre>'.var_export($object, true).'</pre>';

                                        ?>
                                        <div class="item template <?php echo $key; ?>">
                                            <div class="header">
                                                <span title="<?php echo __('Click to expand', 'job-board-manager'); ?>" class="expand ">
                                                    <i class="fa fa-expand"></i>
                                                    <i class="fa fa-compress"></i>
                                                </span>

                                                <span class="expand"><?php echo $object_type; ?></span>



                                            </div>
                                            <div class="options">



                                                <?php

                                                $args['object'] = $object;
                                                $args['key'] = $key;


                                                do_action('product_designer_wc_order_object_data', $args);

                                                ?>

                                                <?php if(!empty($object_price)):?>
                                                <div class="setting-field">
                                                    <div class="field-lable"><?php echo __('Price', 'job-board-manager'); ?></div>
                                                    <div class="field-input">


                                                         <?php echo $object_price; ?>


                                                    </div>
                                                </div>
                                                <?php endif;




                                                if($object_type == 'image'){
                                                    $object_attachment_id = isset($object->attachment_id) ? $object->attachment_id : '';
                                                    $object_src = isset($object->src) ? $object->src : '';

                                                    ?>


                                                    <div class="setting-field">
                                                        <div class="field-lable"><?php echo __('Image Source', 'job-board-manager'); ?></div>
                                                        <div class="field-input">


                                                            <img width="30" height="30" src="<?php echo $object_src;
                                                            ?>">
                                                            <div data-src="<?php echo esc_url_raw($object_src); ?>" class="button download-btn">Download</div>

                                                        </div>
                                                    </div>

                                                    <?php
                                                }

                                                if($object_type == 'path-group'){
                                                    $object_attachment_id = isset($object->attachment_id) ? $object->attachment_id : '';
                                                    $shape_thumb_id = get_post_meta($object_attachment_id, 'shape_thumb_id', true);
                                                    $object_attachment_url = wp_get_attachment_url( $shape_thumb_id );

                                                    //var_dump($object_attachment_url);



                                                    ?>
                                                    <div class="setting-field">
                                                        <div class="field-lable"><?php echo __('Image Source', 'job-board-manager'); ?></div>
                                                        <div class="field-input">

                                                            <img width="30" height="30" src="<?php echo
                                                            $object_attachment_url; ?>">
                                                            <div data-src="<?php echo esc_url_raw($object_attachment_url); ?>" class="button download-btn">Download</div>

                                                        </div>
                                                    </div>


                                                    <?php
                                                }



                                                if($object_type == 'text'){
                                                    $object_text = isset($object->text) ? $object->text : '';
                                                    $object_fontFamily = isset($object->fontFamily) ? $object->fontFamily : '';
                                                    $object_fontSize = isset($object->fontSize) ? $object->fontSize : '';



                                                    ?>
                                                        <?php if(!empty($object_fontFamily)):?>


                                                            <div class="setting-field">
                                                                <div class="field-lable"><?php echo __('Font Family', 'job-board-manager'); ?></div>
                                                                <div class="field-input">

                                                                    <?php echo $object_fontFamily; ?>

                                                                </div>
                                                            </div>
                                                        <?php endif; ?>

                                                        <?php if(!empty($object_fontSize)):?>

                                                            <div class="setting-field">
                                                                <div class="field-lable"><?php echo __('Font Size', 'job-board-manager'); ?></div>
                                                                <div class="field-input">

                                                                    <?php echo $object_fontSize; ?>

                                                                </div>
                                                            </div>

                                                        <?php endif; ?>



                                                        <div class="setting-field">
                                                            <div class="field-lable"><?php echo __('Content', 'job-board-manager'); ?></div>
                                                            <div class="field-input">

                                                                <textarea><?php echo $object_text; ?></textarea>

                                                            </div>
                                                        </div>

                                                    <?php
                                                }




                                                ?>





                                            </div>

                                        </div>
                                        <?php

                                    }


                                ?>


                            </div>

                        </td>
                    </tr>
                    <?php
	            }
            }

            ?>

        </table>


    <script type="text/javascript">
        jQuery(document).ready(function ($){

            $('.download-btn').click(function(e){

                e.preventDefault;
                img_url = $(this).attr('data-src');
                window.open(img_url);
            });
        })
    </script>


    <style type="text/css">
        .pd-preview-src{
            background-image: url("<?php echo product_designer_plugin_url; ?>assets/front/images/tile.png");
            padding: 20px 0;
        }
    </style>



        <?php


	}




	function product_designer_inner_custom_box( $post ) {


		wp_nonce_field( 'product_designer_inner_custom_box', 'product_designer_inner_custom_box_nonce' );

		$canvas = get_post_meta( $post->ID, 'canvas', true );
		$side_data = get_post_meta( $post->ID, 'side_data', true );
		$pre_templates = get_post_meta( $post->ID, 'pre_templates', true );

		$output_file_format  = isset($canvas['output']['file_format']) ? $canvas['output']['file_format'] : 'png';
		$preview_file_format  = isset($canvas['preview']['file_format']) ? $canvas['preview']['file_format'] : 'png';


        if(empty($canvas)):
	        $canvas = array();
	        $canvas['width'] = '500';
	        $canvas['height'] = '500';
	        $canvas['output']['file_format'] = 'png';

        endif;



        //var_dump($pre_templates);

        wp_enqueue_style('font-awesome-5');

		?>

        <style type="text/css">
            .tshirt-hint{
                font-size:12px;
                color:#696969;
                margin-top:10px;
                display:block;}
        </style>



        <div class="option-box">
            <p class="option-title"><?php echo __('Canvas', 'product-designer'); ?></p>

            <p>
                <span><?php echo __('Canvas width', 'product-designer'); ?></span>
                <input type="text" name="canvas[width]" placeholder="500" value="<?php echo isset($canvas['width']) ? $canvas['width'] : '';  ?>">
            </p>
            <p>
                <span><?php echo __('Canvas height', 'product-designer'); ?></span>
                <input type="text" name="canvas[height]" placeholder="500" value="<?php echo isset($canvas['height']) ? $canvas['height'] : '';  ?>">
            </p>


        </div>

        <div class="option-box">
            <p class="option-title"><?php echo __('Output file format', 'product-designer'); ?></p>

            <label>
                <input type="radio" name="canvas[output][file_format]" value="jpeg" <?php echo checked($output_file_format,'jpeg'); ?> >JPEG
            </label>
            <label>
                <input type="radio" name="canvas[output][file_format]" value="png" <?php echo checked($output_file_format,'png'); ?> >PNG
            </label>
            <label>
                <input type="radio" name="canvas[output][file_format]" value="svg" <?php echo checked($output_file_format,'svg'); ?> >SVG
            </label>


            <p class="option-title"><?php echo __('Preview file format', 'product-designer'); ?></p>

            <label>
                <input type="radio" name="canvas[preview][file_format]" value="jpeg" <?php echo checked($preview_file_format,'jpeg'); ?> >JPEG
            </label>
            <label>
                <input type="radio" name="canvas[preview][file_format]" value="png" <?php echo checked($preview_file_format,'png'); ?> >PNG
            </label>
            <label>
                <input type="radio" name="canvas[preview][file_format]" value="svg" <?php echo checked($preview_file_format,'svg'); ?> >SVG
            </label>



        </div>

        <?php

        //echo '<pre>'.var_export($side_data, true).'</pre>';

        ?>

            <div class="option-box">
                <p class="option-title"><?php echo __('Item sides', 'product-designer'); ?></p>
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
            </div>





            <div class="option-box">
                <p class="option-title"><?php echo __('Pre Templates', 'product-designer'); ?></p>
            </div>

            <div class="templates">


                <div class="templates-list">

					<?php

                    //delete_post_meta(get_the_id(), 'pre_templates');

					//echo '<pre>'.var_export($pre_templates, true).'</pre>';


					if(!empty($pre_templates)){

						foreach($pre_templates as $index=>$template_data){

							$template_name = isset($template_data['title']) ? $template_data['title'] : '';
							$template_side_json_data = isset($template_data['side_json_data']) ? $template_data['side_json_data'] : '';
							$template_side_attach_ids = isset($template_data['side_attach_ids']) ? $template_data['side_attach_ids'] : '';

							?>
                            <div class="template">

                                <div>
                                <span class="remove remove-pre-template" pre_template_id="<?php echo $index; ?>" pd_template_id="<?php echo get_the_id(); ?>"><i class="fa fa-times"></i></span>
                                <span class="move"><i class="fa fa-bars"></i></span>
                                <?php echo $template_name; ?>
                            <?php

                            foreach ($template_side_json_data as $side_index=>$side_json){
                                ?>
                                    <img width="150" src="<?php echo wp_get_attachment_url($template_side_attach_ids[$side_index]); ?>" >

                                <?php

                            }


                            ?>
                                </div>
                            </div>
                            <?php

							//}
						}
					}





					?>



                </div>

            </div>








		<?php


	}



	function product_designer_save_postdata( $post_id ) {



		if ( ! isset( $_POST['product_designer_inner_custom_box_nonce'] ) )
			return $post_id;

		$nonce = isset($_POST['product_designer_inner_custom_box_nonce']) ? sanitize_text_field($_POST['product_designer_inner_custom_box_nonce']) : '';

		if ( ! wp_verify_nonce( $nonce, 'product_designer_inner_custom_box' ) )
			return $post_id;


		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
			return $post_id;


		if ( 'page' == $_POST['post_type'] ) {

			if ( ! current_user_can( 'edit_page', $post_id ) )
				return $post_id;

		} else {

			if ( ! current_user_can( 'edit_post', $post_id ) )
				return $post_id;
		}



		if(!empty($_POST['canvas'])){
			$canvas = isset($_POST['canvas']) ? product_designer_recursive_sanitize_arr($_POST['canvas']) : '';
		}
		else{
			$canvas = array();
		}
		if(!empty($_POST['side_data'])){
			$side_data = isset($_POST['side_data']) ? product_designer_recursive_sanitize_arr($_POST['side_data']) : '';
		}
		else{
			$side_data = array();
		}

		if(!empty($_POST['templates'])){
			$templates = isset($_POST['templates']) ? product_designer_recursive_sanitize_arr($_POST['templates']) : '';
		}
		else{
			$templates = array();
		}




		$canvas = product_designer_recursive_sanitize_arr( $canvas );
		$side_data = product_designer_recursive_sanitize_arr( $side_data );
		$templates = product_designer_recursive_sanitize_arr( $templates );


		update_post_meta( $post_id, 'canvas', $canvas );
		update_post_meta( $post_id, 'side_data', $side_data );
		update_post_meta( $post_id, 'templates', $templates );



	}
	
	

	
	

	

}


new class_product_designer_post_meta();

