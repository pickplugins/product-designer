<?php

/*
* @Author 		pickplugins
* Copyright: 	2015 pickplugins
*/

if ( ! defined('ABSPATH')) exit;  // if direct access


?>

<div id="final" class="final">

    <div class="product-order">
        <p><?php echo get_the_title($product_id); ?></p>

		<?php



		$cook_data = isset($_COOKIE['side_customized']) ? sanitize_text_field($_COOKIE['side_customized']) : '';

		//$cook_data = (stripslashes($cook_data));
		$cook_data = unserialize(stripslashes($cook_data));
		//var_dump($cook_data);
		if(!empty($cook_data[$product_id])){
			$prduct_cook_data = $cook_data[$product_id];
		}


		$post_type = get_post_type($product_id);
		if($post_type=='product'){

			global $woocommerce;
			global $product;
			$product = new WC_Product( $product_id );

			$_product = wc_get_product( $product_id );

			$price = $_product->get_price_html();
			echo 'Price: '.$product->get_price_html();




			echo '<form class="cart" enctype="multipart/form-data" method="post" action="'.esc_url_raw($product_designer_page_url).'?product_id='.$product_id.'&final">
							<input class="input-text qty text" type="number" size="4" title="Qty" value="1" name="quantity" min="1" step="1">
							<input type="hidden" value="'.$product_id.'" name="add-to-cart">
							<input type="hidden" value='.serialize($prduct_cook_data).' name="tdesigner_custom_design" size="3">
		
							<input type="hidden" value="cart" name="custom_design_cart" size="3">';



			if ( $_product->is_type( 'variable' ) ) {

				/*

												$attributes = $_product->get_attributes();

												//echo '<pre>'.var_export($attributes, true).'</pre>';


												foreach ( $attributes as $attribute ) {

													$attribute_name = $attribute['name'];

													$terms = wc_get_product_terms( $_product->id, $attribute_name, array( 'fields' => 'all' ) );

													echo '<p class="variation">';
													echo $attribute_name;

													echo '<select name="">';
													foreach($terms as $term){

														$term_id = $term->term_id;
														$name = $term->name;

														echo '<option value="'.$term_id.'">'.$name.'</option>';

														}
													echo '</select>';
													echo '</p>';
													//echo '<pre>'.var_dump($terms, true).'</pre>';


												}

				*/


			}


			echo '<button class="single_add_to_cart_button button alt" type="submit">'.__('Add to cart', 'product-designer').'</button>';

			echo '</form>';



			if(isset($_POST['custom_design_cart']) )
			{
				echo '<a href="'.wc_get_cart_url().'"><strong>'.__('View Cart', 'product-designer').'</strong></a>';

				echo '<style type="text/css">';

				echo '#designer, .menu{display:none}';
				echo '#final{display:block}';

				echo '</style>';

			}

			//var_dump($product);










		}








        elseif($post_type=='download'){

			$edd_price = edd_price($product_id,false);
			echo '<p>Price: '.$edd_price.'</p>';

			echo do_shortcode('[purchase_link id="'.$product_id.'" text="'.__('Add to Cart', 'product-designer').'" style="button"]');

		}
		else{
			if(!empty($_POST)){


				$response = product_designer_create_order( $_POST );

				if(!empty($response)){

					echo __('Order submitted', 'product-designer');

				}

				echo '<style type="text/css">';

				echo '#designer, .menu{display:none}';
				echo '#final{display:block}';

				echo '</style>';



			}
			else{

				echo '<form class="cart" enctype="multipart/form-data" method="post" action="'.esc_url_raw($product_designer_page_url).'?product_id='.$product_id.'&final">
								<input class="input-text qty text" type="number" size="4" title="Qty" value="1" name="quantity" min="1" step="1">
								<input type="hidden" value='.$product_id.' name="product_id" size="3"><br/>								
								<input type="hidden" value='.serialize($prduct_cook_data).' name="tdesigner_custom_design" size="3"><br/>
								
								Name:<br/>
								<input type="text" value="" name="customer_name"><br/>							
								
								Address:<br/>
								<textarea name="address"></textarea><br/>
								<input type="submit" value="Submit" />
								</form>';


			}






		}








		?>


    </div>



    <ul class="final-list">

		<?php

        $cook_data = isset($_COOKIE['side_customized']) ? sanitize_text_field($_COOKIE['side_customized']) : '';

		//var_dump(stripslashes($cook_data));
		//var_dump(unserialize($cook_data));
		$cook_data = unserialize(stripslashes($cook_data));
		//var_dump($cook_data);
        $prduct_cook_data = isset($cook_data[$product_id]) ? $cook_data[$product_id] : array();

		if(!empty($side_data)){

			foreach($side_data as $id=>$side){

				$name = isset($side['name']) ? $side['name'] : '';
				$src = isset($side['src']) ? $side['src'] : '';

				if($current_side==$id){
					$active = 'active';

				}
				else{
					$active = '';
				}


				if(!empty($src)){
					echo '<li>';
					echo '<a title="'.__('Original design.', 'product-designer').'" class=" '.$active.'" href="'.esc_url_raw($page_url).'?product_id='.$product_id.'&side='.$id.'">'.$name.'<img src="'.$src.'" /></a>';
					echo '<i class="fa fa-hand-o-right" ></i>';

					if(!empty($prduct_cook_data[$id])){
						$attach_id = $prduct_cook_data[$id];
						//var_dump($customized_data);
						$attach_url = wp_get_attachment_url( $attach_id );
						echo ' <a class="" title="'.__('Your design.', 'product-designer').'" href="#">Your design<img src="'.esc_url_raw($attach_url).'" /></a>';
					}
					else{
						echo ' <a class="" title="'.__('Empty', 'product-designer').'" href="#">&nbsp;<img src="'.esc_url_raw(product_designer_plugin_url).'assets/front/images/placeholder.png" /></a>';
					}




					echo '</li>';
				}


			}

		}
		else{

			echo '<span>'.__('Not available.', 'product-designer').'</span>';

		}




		?>

    </ul>










</div>