<?php	


if ( ! defined('ABSPATH')) exit; // if direct access 



if(empty($_POST['product_designer_hidden']))
	{
		$product_designer_page_id = get_option( 'product_designer_page_id' );		
		$product_designer_posts_per_page = get_option( 'product_designer_posts_per_page', 10 );



		
		
	}
else
	{

        $nonce = sanitize_text_field($_POST['_wpnonce']);

        if(wp_verify_nonce( $nonce, 'product_designer_nonce' ) && $_POST['product_designer_hidden'] == 'Y') {
			//Form data sent
			
			$product_designer_page_id = sanitize_text_field($_POST['product_designer_page_id']);
			update_option('product_designer_page_id', $product_designer_page_id);			
			
			$product_designer_posts_per_page = sanitize_text_field($_POST['product_designer_posts_per_page']);
			update_option('product_designer_posts_per_page', $product_designer_posts_per_page);


			?>
			<div class="updated"><p><strong><?php _e('Changes Saved.',  'product-designer' ); ?></strong></p></div>
	
			<?php
			} 
	}






?>

<div class="wrap">
	<?php echo "<h2>".sprintf(__('%s Settings',  'product-designer'), product_designer_plugin_name)."</h2>";
	

	//var_dump($product_designer_posttype);
	?>
    <br />
		<form  method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
	<input type="hidden" name="product_designer_hidden" value="Y">
        <?php settings_fields( 'product_designer_plugin_options' );
				do_settings_sections( 'product_designer_plugin_options' );
			
		?>

    <div class="para-settings">
        <ul class="tab-nav"> 
            <li nav="1" class="nav1 active"><?php echo __('Options', 'product-designer'); ?></li>
            <li nav="2" class="nav2"><?php echo __('Help', 'product-designer'); ?></li>
                       
            
        </ul> <!-- tab-nav end -->  
        
		<ul class="box">
            <li style="display: block;" class="box1 tab-box active">
            
            
				<div class="option-box">
                    <p class="option-title"><?php echo __('Designer page id', 'product-designer'); ?></p>
                    <p class="option-info"><?php echo __('Please use following shortcode to display desiner <code>[product_designer]</code>', 'product-designer'); ?></p>
                	
                    <select name="product_designer_page_id">
                    
                    <?php
                    $product_designer_page_list_ids = product_designer_page_list_ids();
					
					foreach($product_designer_page_list_ids as $id=>$title){
						
						if($product_designer_page_id == $id){
							echo '<option selected value="'.$id.'" >'.$title.'</option>';
							}
						else{
							echo '<option value="'.$id.'" >'.$title.'</option>';
							}
						
						
						}
					
					
					?>
                    
                    </select>
                    
                    
                </div>            
            
				<div class="option-box">
                    <p class="option-title"><?php echo __('Number of items on list', 'product-designer'); ?></p>
                    <p class="option-info"></p>
                	<input size="15" type="text" name="product_designer_posts_per_page" value="<?php if(!empty($product_designer_posts_per_page)) echo $product_designer_posts_per_page; else echo 10; ?>" />
                </div>
            






                
                
            
            </li>
            <li style="display: none;" class="box2 tab-box">



                <div class="option-box">
                    <p class="option-title"><?php _e('Watch video tutorial','product-designer'); ?></p>
                    <p class="option-info"></p>

                    <div class="tutorials expandable">
			            <?php
			            $class_product_designer_functions = new class_product_designer_functions();
			            $tutorials =  $class_product_designer_functions->tutorials();

			            foreach($tutorials as $tutorial){

				            echo '<div class="items">';
				            echo '<div class="header "><i class="fa fa-play"></i>&nbsp;&nbsp;'.$tutorial['title'].'</div>';
				            echo '<div class="options"><iframe width="640" height="480" src="//www.youtube.com/embed/'.$tutorial['video_id'].'" frameborder="0" allowfullscreen></iframe></div>';

				            echo '</div>';

			            }

			            ?>

                    </div>

                </div>


                <div class="option-box">
                    <p class="option-title"><?php _e('FAQ', 'product-designer'); ?></p>
                    <p class="option-info"></p>

                    <div class="faq">
			            <?php
			            $class_product_designer_functions = new class_product_designer_functions();
			            $faq =  $class_product_designer_functions->faq();

			            echo '<ul>';
			            foreach($faq as $faq_data){
				            echo '<li>';
				            $title = $faq_data['title'];
				            $items = $faq_data['items'];

				            echo '<span class="group-title">'.$title.'</span>';

				            echo '<ul>';
				            foreach($items as $item){

					            echo '<li class="item">';
					            echo '<a href="'.$item['answer_url'].'"><i class="fa fa-question-circle-o" aria-hidden="true"></i> '.$item['question'].'</a>';


					            echo '</li>';

				            }
				            echo '</ul>';

				            echo '</li>';
			            }

			            echo '</ul>';
			            ?>

                    </div>

                </div>

            </li>
            
            
                    
        
        
    
    </div>
            <p class="submit">
                <?php wp_nonce_field( 'product_designer_nonce' ); ?>
                <input class="button button-primary" type="submit" name="Submit" value="<?php _e('Save Changes', 'product-designer' ); ?>" />
            </p>
		</form>
        
</div> <!-- wrap end -->