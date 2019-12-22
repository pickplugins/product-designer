<?php

/*
* @Author 		pickplugins
* Copyright: 	2015 pickplugins
*/

if ( ! defined('ABSPATH')) exit;  // if direct access








$wc_currency_symbol = get_woocommerce_currency_symbol();

$canvas_settings['width'] = isset($canvas_settings['width']) ? $canvas_settings['width'] : '500';
$canvas_settings['height'] = isset($canvas_settings['height']) ? $canvas_settings['height'] : '500';

$product_data = wc_get_product($product_id);
$product_type = $product_data->get_type();



$product_designer_editor['product_type']  = $product_type;

if($product_type == 'variable'){

	$variation_id = isset($_GET['variation_id']) ? $_GET['variation_id']: '';

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

$product_designer_editor['width']  = $canvas_settings['width'];
$product_designer_editor['height']  = $canvas_settings['height'];


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






   // console.log(current_side_id);
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








</script>