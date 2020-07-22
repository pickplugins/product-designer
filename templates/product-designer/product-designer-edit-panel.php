<?php

if ( ! defined('ABSPATH')) exit;  // if direct access

?>
<div class="editing scrollbar">


    <div class="editor-actions toolbar-section pd-guide-5">
        <div class="toolbar-title"><?php echo __('Editor Actions', 'product-designer'); ?></div>
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

        <div class=""></div>
        <div class="editor-preview pd-guide-6"><i class="fa fa-eye" aria-hidden="true"></i> <?php echo __('Preview', 'product-designer'); ?></div>
        <div class="editor-download pd-guide-7"><i class="fa fa-download" aria-hidden="true"></i> <?php echo __('Download', 'product-designer'); ?></div>
    </div>

    <div class="object-list toolbar-section pd-guide-8">
        <div class="toolbar-title"><?php echo __('Items', 'product-designer'); ?></div>
        <div class="list-item scrollbar"><?php echo __('Get list', 'product-designer'); ?></div>

    </div>

    <div class="edit-text toolbar-section">
        <div class="toolbar-title"><?php echo __('Text Actions', 'product-designer'); ?></div>
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



        <!--

							<span class="" aria-label="Align left" id="text-align-left"><i class="fa fa-align-left" ></i></span>
							<span class="" aria-label="Align center" id="text-align-center"><i class="fa fa-align-center" ></i></span>
							<span class="" aria-label="Akign right" id="text-align-right"><i class="fa fa-align-right" ></i></span>

		-->


    </div>

    <div class="edit-curvedText toolbar-section">
        <div class="toolbar-title"><?php echo __('Curved Text Actions', 'product-designer'); ?></div>

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









    <div class="edit-img toolbar-section">
        <div class="toolbar-title"><?php echo __('Images Actions', 'product-designer'); ?></div>
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

    <div class="edit-shape toolbar-section">
        <div class="toolbar-title"><?php echo __('Shapes Actions', 'product-designer'); ?></div>

        <div class="input-group">
            <div class="input-group-title"><?php echo __('Opacity:', 'product-designer'); ?></div>
            <input  class="" aria-label="Opacity" id="shape-opacity" type="range" min="0" max="1" step="0.1" value="1" />
        </div>
        <div class="input-group">
            <div class="input-group-title"><?php echo __('Color:', 'product-designer'); ?></div>
            <input  data-jscolor="" aria-label="<?php echo __('Color', 'product-designer'); ?>" id="shape-color" class="color " placeholder="<?php echo __('Color', 'product-designer'); ?>"  type="text" value="rgba(255,255,255,1)" />
        </div>

    </div>


    <div class="product-info toolbar-section pd-guide-9">
        <div class="toolbar-title"><?php echo __('Product info', 'product-designer'); ?></div>

        <form class="cart" enctype="multipart/form-data" method="post" action="#">
            <input type="hidden" value="<?php echo $product_id; ?>" name="add-to-cart">
            <input type="hidden" value="<?php echo $pd_template_id; ?>" name="pd_template_id">
            <div class="input-group">

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

                <div class="input-group-title"><?php echo __('You are editing:', 'product-designer'); ?></div><span><?php echo get_the_title($product_id); ?></span>
                <div class="input-group-title"><?php echo __('Base Price:', 'product-designer'); ?></div> <span><?php echo $product_price; ?></span>
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
