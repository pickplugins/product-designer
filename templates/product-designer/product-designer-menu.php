<?php

/*
* @Author 		pickplugins
* Copyright: 	2015 pickplugins
*/

if ( ! defined('ABSPATH')) exit;  // if direct access


    ?>
    <div class="menu">

        <div class="side item  pd-guide-1" title="Sides"><span class="icon"><i class="fa fa-cube" ></i></span>
            <div class="child">


                <ul class="side-list scrollbar">

					<?php

					if(!empty($_COOKIE['side_customized'])){
						$cook_data = $_COOKIE['side_customized'];
					}
					else{
						$cook_data = '';
					}

					//var_dump(stripslashes($cook_data));
					//var_dump(unserialize($cook_data));
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
								echo '<img class="" title="'.get_the_title().'" src="'.$thumb_url.'" />';

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