<?php

/*
* @Author 		pickplugins
* Copyright: 	2015 pickplugins
*/

if ( ! defined('ABSPATH')) exit;  // if direct access





function product_designer_is_customizable($post_id) {

	$product = wc_get_product($post_id);
	$is_variable = $product->is_type('variable');
	$is_customizable = false;

	if($is_variable):

		$available_variations = $product->get_available_variations();
		$all_variation = array();

		foreach ( $available_variations as $variation ){

			$variation_id = $variation['variation_id'];
			$pd_template_id = get_post_meta($variation_id, 'pd_template_id', true);

			if($pd_template_id != 'none')
				$all_variation[$variation_id] = $pd_template_id;
		}

		if(!empty($all_variation)):
            $is_customizable = true;
        endif;
    else:
	    $pd_template_id = get_post_meta($post_id, 'pd_template_id', true);

	    if(!empty($pd_template_id)):
		    $is_customizable = true;
	    endif;
    endif;

	return $is_customizable;
}






function product_designer_get_pd_templates(){

	$args = array(

		'post_type' => 'pd_template',
		'post_status' => 'publish',

		'posts_per_page' => -1,

	);

	$wp_query = new WP_Query( $args );


	$pd_templates['none'] = 'None';

	if($wp_query->have_posts()): while($wp_query->have_posts()): $wp_query->the_post();

		$pd_templates[get_the_id()] = get_the_title();

	endwhile;
		wp_reset_postdata();
	endif;

	return $pd_templates;

}










add_filter( 'woocommerce_product_data_tabs', 'woocommerce_product_data_tab_product_designer', 10 );

function woocommerce_product_data_tab_product_designer( $product_data_tabs ) {
	$product_data_tabs['product-designer'] = array(
		'label' => __( 'Product Designer', 'product-designer' ),
		'target' => 'product-designer',
	);
	return $product_data_tabs;
}


add_action( 'woocommerce_product_data_panels', 'woocommerce_product_data_tab_product_designer_fields' );

function woocommerce_product_data_tab_product_designer_fields() {
	global $woocommerce, $post;

	$pd_template_id = get_post_meta( $post->ID, 'pd_template_id', true );
	$product = wc_get_product($post->ID);
	$is_variable = $product->is_type('variable');

	if($is_variable):

        ?>
        <div id="product-designer" class="panel woocommerce_options_panel">
            <p class="form-field pd_template_id_field ">
                Please check variations tabs for choosing product designer templates.
            </p>
        </div>
        <?php
    else:
        ?>

        <div id="product-designer" class="panel woocommerce_options_panel">
        <?php
        $pd_templates = product_designer_get_pd_templates();
        woocommerce_wp_select( array(
                'id'      => 'pd_template_id',
                'label'   => __( 'Choose template', 'product-designer' ),
                'options' =>  $pd_templates, //this is where I am having trouble
                'value'   => $pd_template_id,
            )
        );
        ?>
        </div>
	    <?php

    endif;
	?>

<?php


}


add_action( 'woocommerce_process_product_meta', 'woocommerce_product_data_tab_product_designer_save' );
function woocommerce_product_data_tab_product_designer_save( $post_id ){
	// This is the case to save custom field data of checkbox. You have to do it as per your custom fields
	$pd_template = isset( $_POST['pd_template_id'] ) ? $_POST['pd_template_id'] : '';
	update_post_meta( $post_id, 'pd_template_id', $pd_template );
}






add_action( 'woocommerce_after_add_to_cart_button', 'product_designer_after_add_to_cart_button', 90 );
add_action( 'woocommerce_after_shop_loop_item', 'product_designer_woocommerce_after_shop_loop_item',90 );


function product_designer_after_add_to_cart_button() {
	global $product;
	$product_designer_page_id = get_option( 'product_designer_page_id' );
	$product_designer_page_url = get_permalink($product_designer_page_id);
	$is_customizable = product_designer_is_customizable($product->get_id());

	if($is_customizable ){

		$product = wc_get_product($product->get_id());
		$is_variable = $product->is_type('variable');

		if($is_variable):

			?>
            <div class="product-designer-editor-link has-child">

	            <?php

	            $available_variations = $product->get_available_variations();
	            $all_variation = array();

	            ?>

                <div class="">Customize</div>
                <div class="variation-link">
	                <?php

	                if(!empty($available_variations))
		                foreach ( $available_variations as $variation ){

			                //var_dump($variation);

			                $variation_id = $variation['variation_id'];
			                $variation_data = wc_get_product($variation_id);



			                $pd_template_id = get_post_meta($variation_id, 'pd_template_id', true);

			               // echo var_export($pd_template_id);


			                if($pd_template_id != 'none'):
				                ?>
                                <a target="_blank" class="" href="<?php echo $product_designer_page_url; ?>?product_id=<?php echo get_the_ID(); ?>&variation_id=<?php echo $variation_id; ?>"><i class="fa fa-crop" ></i> <?php echo $variation_data->get_formatted_name(); ?></a>
				                <?php
                            endif;


		                }

	                ?>
                </div>
            </div>
			<?php

        else:
	        ?>
            <div class="product-designer-editor-link">
                <a target="_blank" class="" href="<?php echo $product_designer_page_url; ?>?product_id=<?php echo get_the_ID(); ?>"><i class="fa fa-crop" ></i> <?php echo __('Customize', 'product-designer'); ?></a>

            </div>
	        <?php

        endif;



	}
}

function product_designer_woocommerce_after_shop_loop_item() {

	global $product;
	$product_designer_page_id = get_option( 'product_designer_page_id' );
	$product_designer_page_url = get_permalink($product_designer_page_id);
	$is_customizable = product_designer_is_customizable($product->get_id());

	if(is_shop() && $is_customizable){


		$product = wc_get_product($product->get_id());
		$is_variable = $product->is_type('variable');

		if($is_variable):

			?>
            <div class="product-designer-editor-link has-child">

				<?php

				$available_variations = $product->get_available_variations();
				$all_variation = array();

				?>

                <div class="">Customize</div>
                <div class="variation-link">
					<?php

					if(!empty($available_variations))
						foreach ( $available_variations as $variation ){

							//var_dump($variation);

							$variation_id = $variation['variation_id'];
							$variation_data = wc_get_product($variation_id);



							$pd_template_id = get_post_meta($variation_id, 'pd_template_id', true);

							if($pd_template_id != 'none'):
								?>
                                <a target="_blank" class="" href="<?php echo $product_designer_page_url; ?>?product_id=<?php echo get_the_ID(); ?>&variation_id=<?php echo $variation_id; ?>"><i class="fa fa-magic" aria-hidden="true"></i> <?php echo $variation_data->get_formatted_name(); ?></a>
								<?php
                            endif;


						}

					?>
                </div>
            </div>
			<?php

		else:
			?>
            <div class="product-designer-editor-link">
                <a target="_blank" class="" href="<?php echo $product_designer_page_url; ?>?product_id=<?php echo get_the_ID(); ?>"><i class="fa fa-crop" ></i> <?php echo __('Customize', 'product-designer'); ?></a>

            </div>
			<?php

		endif;









//		?>
<!--        <div class="product-designer-editor-link">-->
<!--            <a class="button" href="--><?php //echo $product_designer_page_url; ?><!--?product_id=--><?php //echo get_the_ID(); ?><!--"><i class="fa fa-crop" ></i> --><?php //echo __('Customize', 'product-designer'); ?><!--</a>-->
<!---->
<!--        </div>-->
<!--		--><?php
	}
}




// Add Variation Settings
add_action( 'woocommerce_product_after_variable_attributes', 'product_designer_variation_settings_fields', 10, 3 );
// Save Variation Settings
add_action( 'woocommerce_save_product_variation', 'save_product_designer_variation_settings_fields', 10, 2 );
/**
 * Create new fields for variations
 *
 */
function product_designer_variation_settings_fields( $loop, $variation_data, $variation ) {
	$pd_templates = product_designer_get_pd_templates();
	// Select
	woocommerce_wp_select(
		array(
			'id'          => 'pd_template_id[' . $variation->ID . ']',
			'label'       => __( 'Choose template', 'woocommerce' ),
			//'description' => __( 'Choose a value.', 'woocommerce' ),
			'value'       => get_post_meta( $variation->ID, 'pd_template_id', true ),
			'options' => $pd_templates
		)
	);


}
/**
 * Save new fields for variations
 *
 */
function save_product_designer_variation_settings_fields( $post_id ) {
	// Text Field


	// Select
	$select = $_POST['pd_template_id'][ $post_id ];
	if( ! empty( $select ) ) {
		update_post_meta( $post_id, 'pd_template_id', esc_attr( $select ) );
	}

}













//cart_item_data

add_filter( 'woocommerce_add_cart_item_data', 'product_designer_add_cart_item_data', 10, 2 );
function product_designer_add_cart_item_data( $cart_item_meta, $product_id ) {
	global $woocommerce;

	//var_dump($cart_item_meta);

	if ( !empty( $_POST['product_designer_side_attach_ids'] )){

		$cart_item_meta['product_designer_side_attach_ids'] = $_POST['product_designer_side_attach_ids'];
	}



	if ( !empty( $_POST['product_designer_side_ids_json'] )){

		$cart_item_meta['product_designer_side_ids_json'] = $_POST['product_designer_side_ids_json'];
	}





	return $cart_item_meta;
}

//add_filter( 'woocommerce_get_cart_item_from_session', 'product_designer_get_cart_item_from_session' , 10, 2 );
function product_designer_get_cart_item_from_session( $cart_item, $values ) {

	if ( (!empty( $values['product_designer_side_attach_ids'] ) )) {

		$cart_item['product_designer_side_attach_ids'] = $values['product_designer_side_attach_ids'];

	}

	if ( (!empty( $values['product_designer_side_ids_json'] ) )) {

		$cart_item['product_designer_side_ids_json'] = $values['product_designer_side_ids_json'];

	}




	return $cart_item;
}





//add_filter( 'woocommerce_get_item_data',  'product_designer_get_item_data' , 10, 2 );
function product_designer_get_item_data( $item_data, $cart_item ) {

	// at cart page, checkout page
	if ( !empty( $cart_item['product_designer_side_attach_ids'] )){

		$item_data[] = array(
			'name'    => __( 'Custom design', 'product-designer' ),
			'value'   => $cart_item['product_designer_side_attach_ids'],
			'display' => 'Display Custom Design'
		);
	}


	if ( !empty( $cart_item['product_designer_side_ids_json'] )){

		$item_data[] = array(
			'name'    => __( 'Custom design', 'product-designer' ),
			'value'   => $cart_item['product_designer_side_ids_json'],
			'display' => 'Display Custom Design'
		);
	}


	return $item_data;
}


//add_action( 'woocommerce_before_calculate_totals', 'add_custom_price' , 1, 1);

function add_custom_price( $cart_object ) {


    //var_dump($cart_object);

    $i = 1;
	foreach ( $cart_object->cart_contents as $key => $value ) {

	    //var_dump($i);

	    $clip_art_price = isset($value['clip_art_price']) ? $value['clip_art_price'] : 0;

	    if($clip_art_price != 0){
		    $price = $value['data']->get_price() + $clip_art_price;
        }


	    //var_dump($clip_art_price);


		$value['data']->set_price( $price );

	    $i++;
	}

}


add_filter( 'woocommerce_cart_item_thumbnail',  'product_designer_woocommerce_cart_item_thumbnail' , 10, 3 );
function product_designer_woocommerce_cart_item_thumbnail( $item_thumbnail, $values, $cart_item_key ) {

	//woocommerce_add_order_item_meta( $cart_item_key, 'product_designer_side_attach_ids_hello', 'Hello' );


	$item_thumbnail = $item_thumbnail;




	?>
<!--    <pre>-->
<!--        --><?php
//        //echo var_export($cart_item_key, true);
//        //echo var_export($values, true);
//        //echo var_export($values['product_designer_side_attach_ids'], true);
//        //echo var_export($values['product_designer_side_ids_json'], true);
//        ?>
<!--    </pre>-->
    <?php





        if ( !empty( $values['product_designer_side_attach_ids'] )){


	        ob_start();
	        ?>

            <div class="cart-sides">
                <div class="">Customized:</div>
		        <?php


	        $product_designer_side_attach_ids = $values['product_designer_side_attach_ids'];


	        foreach ($product_designer_side_attach_ids as $side_id=>$attach_id){
	            ?>
                <div style="display: inline" title="<?php echo $side_id; ?>" class="side side-">
                    <img  width="50" src="<?php echo wp_get_attachment_url($attach_id); ?>">
                </div>
                <?php

	        }


	        ?>

            </div>
	        <?php

	        $item_thumbnail .= ob_get_clean();

        }










	return $item_thumbnail;
}











add_action( 'woocommerce_add_order_item_meta',  'product_designer_add_order_item_meta' , 10, 2 );
function product_designer_add_order_item_meta( $item_id, $cart_item ) {

	if (  (!empty( $cart_item['product_designer_side_attach_ids'] ))){

		woocommerce_add_order_item_meta( $item_id, 'product_designer_side_attach_ids', $cart_item['product_designer_side_attach_ids'] );

	}

	if (  (!empty( $cart_item['product_designer_side_ids_json'] ))){

		woocommerce_add_order_item_meta( $item_id, 'product_designer_side_ids_json', $cart_item['product_designer_side_ids_json'] );

	}



}





function product_designer_ajax_add_to_cart(){

	$response 	= array();
	$product_id = isset( $_POST['product_id'] ) ? sanitize_text_field($_POST['product_id']) : 0;
	$variation_id = isset( $_POST['variation_id'] ) ? $_POST['variation_id'] : 0;

	parse_str($_POST['values'], $form_data);
	$pd_template_id = isset( $form_data['pd_template_id'] ) ? sanitize_text_field($form_data['pd_template_id']) : 0;
	$quantity = isset( $form_data['quantity'] ) ? sanitize_text_field($form_data['quantity']) : 0;

	$product_designer_side_attach_ids = isset( $form_data['product_designer_side_attach_ids'] ) ? $form_data['product_designer_side_attach_ids'] : array();
	$product_designer_side_ids_json = isset( $form_data['product_designer_side_ids_json'] ) ? $form_data['product_designer_side_ids_json'] : array();

	$cart_item_data['product_designer_side_attach_ids'] = $product_designer_side_attach_ids;
	$cart_item_data['product_designer_side_ids_json'] = $product_designer_side_ids_json;
	$cart_item_data['pd_template_id'] = $pd_template_id;

	$cart_item_data['clip_art_price'] = 12;


	//WC()->cart->add_to_cart( $product_id );


	WC()->cart->add_to_cart($product_id, $quantity, $variation_id, '', $cart_item_data );



	$cart_url = WC()->cart->get_cart_url();
	$response['form_data'] = $form_data;
	$response['msg'] = 'Custom design successfully added to <a href="'.$cart_url.'">Cart</a>';




	echo json_encode($response);
	die();
}
add_action('wp_ajax_product_designer_ajax_add_to_cart', 'product_designer_ajax_add_to_cart');
add_action('wp_ajax_nopriv_product_designer_ajax_add_to_cart', 'product_designer_ajax_add_to_cart');






function product_designer_ajax_save_as_template(){

	$response 	= array();

	parse_str($_POST['values'], $form_data);
	$pd_template_id = isset( $form_data['pd_template_id'] ) ? sanitize_text_field($form_data['pd_template_id']) : 0;


	$product_designer_side_attach_ids = isset( $form_data['product_designer_side_attach_ids'] ) ? $form_data['product_designer_side_attach_ids'] : array();
	$product_designer_side_ids_json = isset( $form_data['product_designer_side_ids_json'] ) ? $form_data['product_designer_side_ids_json'] : array();

	$cart_item_data['product_designer_side_attach_ids'] = $product_designer_side_attach_ids;
	$cart_item_data['product_designer_side_ids_json'] = $product_designer_side_ids_json;
	$cart_item_data['pd_template_id'] = $pd_template_id;


	//WC()->cart->add_to_cart( $product_id );



	$response['form_data'] = $product_designer_side_attach_ids;
	$response['msg'] = 'Saved as template done!';


	$pre_templates = get_post_meta($pd_template_id, 'pre_templates', true);

	if(empty($pre_templates))
		$pre_templates = array();



	$unique_id = time();

	$pre_templates[$unique_id]['side_json_data'] = $product_designer_side_ids_json;
	$pre_templates[$unique_id]['side_attach_ids'] = $product_designer_side_attach_ids;
	$pre_templates[$unique_id]['title'] = '#'.$unique_id;

	update_post_meta($pd_template_id, 'pre_templates', $pre_templates);



	echo json_encode($response);
	die();
}
add_action('wp_ajax_product_designer_ajax_save_as_template', 'product_designer_ajax_save_as_template');
add_action('wp_ajax_nopriv_product_designer_ajax_save_as_template', 'product_designer_ajax_save_as_template');



function product_designer_ajax_remove_pre_template(){
	$response 	= array();
	$pd_template_id = isset( $_POST['pd_template_id'] ) ? sanitize_text_field($_POST['pd_template_id']) : 0;
	$pre_template_id = isset( $_POST['pre_template_id'] ) ? sanitize_text_field($_POST['pre_template_id']) : 0;

	$pre_templates = get_post_meta($pd_template_id, 'pre_templates', true);

	$response['pre_templates'] = $pre_templates;




	if(isset($pre_templates[$pre_template_id])):

        unset($pre_templates[$pre_template_id]);
		$response['status'] = 'deleted';

		update_post_meta($pd_template_id,'pre_templates', $pre_templates);



    else:
	    $response['status'] = 'not_deleted';
    endif;


	echo json_encode($response);
	die();
}
add_action('wp_ajax_product_designer_ajax_remove_pre_template', 'product_designer_ajax_remove_pre_template');
//add_action('wp_ajax_nopriv_product_designer_ajax_remove_pre_template', 'product_designer_ajax_remove_pre_template');
