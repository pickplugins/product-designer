<?php



if ( ! defined('ABSPATH')) exit;  // if direct access



add_filter( 'woocommerce_available_variation', 'product_designer_variation_customize_link', 10, 3 );
function product_designer_variation_customize_link( $data, $product, $variation ) {


    $product_designer_settings = get_option('product_designer_settings');
    $designer_page_id = isset($product_designer_settings['designer_page_id']) ? $product_designer_settings['designer_page_id'] : '';


    $product_designer_page_url = get_permalink($designer_page_id);

    $product_id = $product->get_id();
    $variation_id = $variation->get_id();

    $pd_template_id = get_post_meta($variation_id, 'pd_template_id', true);

    //var_dump($pd_template_id);



    //$price  = wc_get_price_to_display( $variation );
    //$suffix = sprintf( __("Ou simplement en 4 x %s sans frais"), wc_price($price / 4) );
    //http://localhost/wp/product-designer/?product_id=1346&variation_id=1369

    if(($pd_template_id != 'none')){
        $data['price_html'] .= '<div class="product-designer-editor-link"><a rel="noindex nofollow" href="'.$product_designer_page_url.'?product_id='.$product_id.'&variation_id='.$variation_id.'" class="4xcb"><i class="fa fa-crop" ></i> Customize</a></div>';

    }


    return $data;
}







add_filter( 'jetpack_lazy_images_blacklisted_classes', 'product_designer_exclude_jetpack_lazy', 999, 1 );

function product_designer_exclude_jetpack_lazy( $classes ) {
    $classes[] = 'customClipart';
    return $classes;
}


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

			if(is_numeric($pd_template_id))
				$all_variation[$variation_id] = $pd_template_id;
		}

		if(!empty($all_variation)):
            $is_customizable = true;
        endif;
    else:
	    $pd_template_id = get_post_meta($post_id, 'pd_template_id', true);

		//var_dump($pd_template_id);

	    if(is_numeric($pd_template_id)):
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
                'label'   => __( 'Choose Product designer template', 'product-designer' ),
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
	$pd_template = isset( $_POST['pd_template_id'] ) ? sanitize_text_field($_POST['pd_template_id']) : '';
	update_post_meta( $post_id, 'pd_template_id', $pd_template );
}






add_action( 'woocommerce_after_add_to_cart_form', 'product_designer_after_add_to_cart_button', 90 );
add_action( 'woocommerce_after_shop_loop_item', 'product_designer_woocommerce_after_shop_loop_item',90 );


function product_designer_after_add_to_cart_button() {
	global $product;

    $product_designer_settings = get_option('product_designer_settings');
    $designer_page_id = isset($product_designer_settings['designer_page_id']) ? $product_designer_settings['designer_page_id'] : '';
    $customize_button_text = isset($product_designer_settings['customize_button']['text']) ? $product_designer_settings['customize_button']['text'] : __('Customize', 'product-designer');
    $customize_button_bg_color = isset($product_designer_settings['customize_button']['bg_color']) ? $product_designer_settings['customize_button']['bg_color'] : '';


    $product_designer_page_url = get_permalink($designer_page_id);
	$is_customizable = product_designer_is_customizable($product->get_id());
    wp_enqueue_style('font-awesome-4');



	if($is_customizable ){

		$product = wc_get_product($product->get_id());
		$is_variable = $product->is_type('variable');

		if($is_variable):

			?>

			<?php

        else:
	        ?>
            <div class="product-designer-editor-link" style="background-color: <?php echo $customize_button_bg_color; ?>">
<!--                <a target="_blank"  class="" href="--><?php //echo esc_url_raw($product_designer_page_url); ?><!--?product_id=--><?php //echo get_the_ID(); ?><!--&pd_enable"><i class="fa fa-crop" ></i> --><?php //echo $customize_button_text; ?><!--</a>-->
                <a rel="noindex nofollow" target="_blank"  class="" href="<?php echo esc_url_raw(get_permalink($product->get_id())); ?>?pd_enable"><i class="fa fa-crop" ></i> <?php echo $customize_button_text; ?></a>

            </div>
	        <?php

        endif;


        ?>

        <?php


	}

    wp_enqueue_style('customize-link');


}


add_action('woocommerce_after_single_product', 'product_designer_wc_designer');

function product_designer_wc_designer(){


    if(isset($_GET['pd_enable'])){

        $product_id = get_the_id();
        echo do_shortcode('[product_designer product_id="'.$product_id.'"]');

    }




    //echo 'Hello';



}









function product_designer_woocommerce_after_shop_loop_item() {

	global $product;

    $product_designer_settings = get_option('product_designer_settings');
    $designer_page_id = isset($product_designer_settings['designer_page_id']) ? $product_designer_settings['designer_page_id'] : '';
    $customize_button_text = isset($product_designer_settings['customize_button']['text']) ? $product_designer_settings['customize_button']['text'] : __('Customize', 'product-designer');
    $customize_button_bg_color = isset($product_designer_settings['customize_button']['bg_color']) ? $product_designer_settings['customize_button']['bg_color'] : '';



	$product_designer_page_url = get_permalink($designer_page_id);
	$is_customizable = product_designer_is_customizable($product->get_id());

	if(is_shop() && $is_customizable){


		$product = wc_get_product($product->get_id());
		$is_variable = $product->is_type('variable');

		if($is_variable):

			?>

			<?php

		else:
			?>
            <div class="product-designer-editor-link" style="background-color: <?php echo $customize_button_bg_color; ?>">
<!--                <a rel="noindex nofollow" target="_blank"  class="" href="--><?php //echo esc_url_raw($product_designer_page_url); ?><!--?product_id=--><?php //echo get_the_ID(); ?><!--"><i class="fa fa-crop" ></i> --><?php //echo $customize_button_text; ?><!--</a>-->
                <a rel="noindex nofollow" target="_blank"  class="" href="<?php echo esc_url_raw(get_permalink($product->get_id())); ?>?pd_enable"><i class="fa fa-crop" ></i> <?php echo $customize_button_text; ?></a>

            </div>
			<?php

		endif;

	}
    wp_enqueue_style('font-awesome-4');

    wp_enqueue_style('customize-link');

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
			'label'       => __( 'Choose Product designer template', 'woocommerce' ),
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
	$select = isset($_POST['pd_template_id'][ $post_id ]) ? sanitize_text_field($_POST['pd_template_id'][ $post_id ]) : '';
	if( ! empty( $select ) ) {
		update_post_meta( $post_id, 'pd_template_id', esc_attr( $select ) );
	}

}










add_filter( 'woocommerce_cart_item_thumbnail',  'product_designer_woocommerce_cart_item_thumbnail' , 10, 3 );
function product_designer_woocommerce_cart_item_thumbnail( $item_thumbnail, $values, $cart_item_key ) {

    //woocommerce_new_order_item( $cart_item_key, 'product_designer_side_attach_ids_hello', 'Hello' );


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




//cart_item_data

add_filter( 'woocommerce_add_cart_item_data', 'product_designer_add_cart_item_data', 10, 2 );
function product_designer_add_cart_item_data( $cart_item_meta, $product_id ) {
	global $woocommerce;

	//var_dump($cart_item_meta);

	if ( !empty( $_POST['product_designer_side_attach_ids'] )){

		$cart_item_meta['product_designer_side_attach_ids'] = product_designer_recursive_sanitize_arr($_POST['product_designer_side_attach_ids']);
	}



	if ( !empty( $_POST['product_designer_side_ids_json'] )){

		$cart_item_meta['product_designer_side_ids_json'] = product_designer_recursive_sanitize_arr($_POST['product_designer_side_ids_json']);
	}


	return $cart_item_meta;
}




add_action( 'woocommerce_checkout_create_order_line_item', 'custom_checkout_create_order_line_item', 20, 4 );
function custom_checkout_create_order_line_item( $item, $cart_item_key, $values, $order ) {
    // Get a product custom field value

    // Get cart item custom data and update order item meta
    if( isset( $values['product_designer_side_attach_ids'] ) ) {
        $item->update_meta_data( 'product_designer_side_attach_ids', $values['product_designer_side_attach_ids'] );
    }


    if( isset( $values['product_designer_side_ids_json'] ) ) {
        $item->update_meta_data( 'product_designer_side_ids_json', $values['product_designer_side_ids_json'] );
    }

}



add_action('woocommerce_before_cart_item_quantity_zero','wdm_remove_user_custom_data_options_from_cart',1,1);
if(!function_exists('wdm_remove_user_custom_data_options_from_cart'))
{
    function wdm_remove_user_custom_data_options_from_cart($cart_item_key)
    {
        global $woocommerce;
        // Get cart
        $cart = $woocommerce->cart->get_cart();
        // For each item in cart, if item is upsell of deleted product, delete it
        foreach( $cart as $key => $values)
        {
            if ( $values['product_designer_side_attach_ids'] == $cart_item_key )
                unset( $woocommerce->cart->cart_contents[ $key ] );

            if ( $values['product_designer_side_ids_json'] == $cart_item_key )
                unset( $woocommerce->cart->cart_contents[ $key ] );



        }
    }






}












function product_designer_ajax_add_to_cart(){

	$response 	= array();
	$product_id = isset( $_POST['product_id'] ) ? sanitize_text_field($_POST['product_id']) : 0;
	$variation_id = isset( $_POST['variation_id'] ) ? sanitize_text_field($_POST['variation_id']) : 0;

	parse_str($_POST['values'], $form_data);

    $form_data = product_designer_recursive_sanitize_arr($form_data);


    $pd_template_id = isset( $form_data['pd_template_id'] ) ? sanitize_text_field($form_data['pd_template_id']) : 0;
	$quantity = isset( $form_data['quantity'] ) ? sanitize_text_field($form_data['quantity']) : 0;
    $assets_price = isset( $form_data['assets_price'] ) ? sanitize_text_field($form_data['assets_price']) : 0;



	$product_designer_side_attach_ids = isset( $form_data['product_designer_side_attach_ids'] ) ? product_designer_recursive_sanitize_arr($form_data['product_designer_side_attach_ids']) : array();
	$product_designer_side_ids_json = isset( $form_data['product_designer_side_ids_json'] ) ? product_designer_recursive_sanitize_arr($form_data['product_designer_side_ids_json']) : array();

	$cart_item_data['product_designer_side_attach_ids'] = $product_designer_side_attach_ids;
	$cart_item_data['product_designer_side_ids_json'] = $product_designer_side_ids_json;
	$cart_item_data['pd_template_id'] = $pd_template_id;
	$cart_item_data['clipart_price'] = $assets_price;


	//WC()->cart->add_to_cart( $product_id );

	WC()->cart->add_to_cart($product_id, $quantity, $variation_id, '', $cart_item_data );




	$cart_url = wc_get_cart_url();
	$response['form_data'] = $form_data;
	$response['msg'] = 'Custom design successfully added to <a href="'.esc_url_raw($cart_url).'"><strong>Cart</strong></a>';
    $response['assets_price'] = $assets_price;
    $response['side_ids_json'] = $product_designer_side_ids_json;




	echo json_encode($response);
	die();
}
add_action('wp_ajax_product_designer_ajax_add_to_cart', 'product_designer_ajax_add_to_cart');
add_action('wp_ajax_nopriv_product_designer_ajax_add_to_cart', 'product_designer_ajax_add_to_cart');















function product_designer_ajax_save_as_template(){

	$response 	= array();

	parse_str($_POST['values'], $form_data);

    $form_data = product_designer_recursive_sanitize_arr($form_data);


    $pd_template_id = isset( $form_data['pd_template_id'] ) ? sanitize_text_field($form_data['pd_template_id']) : 0;


	$product_designer_side_attach_ids = isset( $form_data['product_designer_side_attach_ids'] ) ? product_designer_recursive_sanitize_arr($form_data['product_designer_side_attach_ids']) : array();
	$product_designer_side_ids_json = isset( $form_data['product_designer_side_ids_json'] ) ? product_designer_recursive_sanitize_arr($form_data['product_designer_side_ids_json']) : array();

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

