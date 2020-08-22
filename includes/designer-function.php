<?php
if ( ! defined('ABSPATH')) exit;  // if direct access




function product_designer_shape_upload(){

    check_ajax_referer('pd_shape_upload');

    // you can use WP's wp_handle_upload() function:
    $file = $_FILES['async-upload'];

    $status = wp_handle_upload($file, array('action' => 'product_designer_shape_upload'));

    $file_loc = $status['file'];
    $file_name = isset($status['name']) ? basename($status['name']) : '';
    $file_type = wp_check_filetype($file_name);

    $attachment = array(
        'post_mime_type' => $status['type'],
        'post_title' => preg_replace('/\.[^.]+$/', '', basename($file['name'])),
        'post_content' => '',
        'post_status' => 'inherit'
    );

    $attach_id = wp_insert_attachment($attachment, $file_loc);
    $attach_data = wp_generate_attachment_metadata($attach_id, $file_loc);
    wp_update_attachment_metadata($attach_id, $attach_data);
    //echo $attach_id;


    $user_id = get_current_user_id();

    $clipart_post = array(
        'post_title'    => __('User Uploaded Shape', 'product-designer'),
        'post_status'   => 'publish',
        'post_author'   => $user_id,
        'post_type'     =>'shape'
    );

    $product_designer_settings = get_option('product_designer_settings');
    $shape_price = isset($product_designer_settings['shape_price']) ? $product_designer_settings['shape_price'] :'';


    $clipart_ID = wp_insert_post( $clipart_post );
    update_post_meta( $clipart_ID, 'shape_thumb_id', $attach_id );

    update_post_meta( $clipart_ID, 'shape_price', $shape_price );





    $attach_title = get_the_title($attach_id);

    $html['attach_url'] = wp_get_attachment_url($attach_id);
    $html['attach_id'] = $attach_id;
    $html['attach_title'] = get_the_title($attach_id);

    $response = array(
        'status'=>'ok',
        'html'=>$html,


    );

    echo json_encode($response);

    exit;
}

add_action('wp_ajax_product_designer_shape_upload', 'product_designer_shape_upload');
add_action('wp_ajax_nopriv_product_designer_shape_upload', 'product_designer_shape_upload');




function product_designer_clipart_upload(){

    check_ajax_referer('pd_clipart_upload');

    // you can use WP's wp_handle_upload() function:
    $file = $_FILES['async-upload'];

    $status = wp_handle_upload($file, array('action' => 'product_designer_clipart_upload'));

    $file_loc = $status['file'];
    $file_name = isset($status['name']) ? basename($status['name']) : '';
    $file_type = wp_check_filetype($file_name);

    $attachment = array(
        'post_mime_type' => $status['type'],
        'post_title' => preg_replace('/\.[^.]+$/', '', basename($file['name'])),
        'post_content' => '',
        'post_status' => 'inherit'
    );

    $attach_id = wp_insert_attachment($attachment, $file_loc);
    $attach_data = wp_generate_attachment_metadata($attach_id, $file_loc);
    wp_update_attachment_metadata($attach_id, $attach_data);
    //echo $attach_id;


    $user_id = get_current_user_id();

    $clipart_post = array(
        'post_title'    => __('Custom clipart', 'product-designer'),
        'post_status'   => 'publish',
        'post_author'   => $user_id,
        'post_type'     =>'clipart'
    );

    $product_designer_settings = get_option('product_designer_settings');
    $clipart_price = isset($product_designer_settings['clipart_price']) ? $product_designer_settings['clipart_price'] :'';


    $clipart_ID = wp_insert_post( $clipart_post );
    update_post_meta( $clipart_ID, 'clipart_thumb_id', $attach_id );

    update_post_meta( $clipart_ID, 'clipart_price', $clipart_price );





    $attach_title = get_the_title($attach_id);

    $html['attach_url'] = wp_get_attachment_url($attach_id);
    $html['attach_id'] = $attach_id;
    $html['attach_title'] = get_the_title($attach_id);

    $response = array(
        'status'=>'ok',
        'html'=>$html,


    );

    echo json_encode($response);

    exit;
}

add_action('wp_ajax_product_designer_clipart_upload', 'product_designer_clipart_upload');
add_action('wp_ajax_nopriv_product_designer_clipart_upload', 'product_designer_clipart_upload');






function product_designer_fonts(){
	
	$fonts = array();
	
	$fonts[] = array('name'=>'Bungee');
	$fonts[] = array('name'=>'Bungee Inline');
	$fonts[] = array('name'=>'Sumana');
	$fonts[] = array('name'=>'Montserrat');
	$fonts[] = array('name'=>'Indie Flower');
	$fonts[] = array('name'=>'Muli');
	$fonts[] = array('name'=>'Tillana');
	$fonts[] = array('name'=>'Lobster');
	$fonts[] = array('name'=>'Delius Unicase');
	$fonts[] = array('name'=>'Gloria Hallelujah');	
	$fonts[] = array('name'=>'Anton');	
	$fonts[] = array('name'=>'Pacifico');		
	$fonts[] = array('name'=>'Abril Fatface');	
	$fonts[] = array('name'=>'Ranga');	
	$fonts[] = array('name'=>'Dancing Script');	
	$fonts[] = array('name'=>'Shadows Into Light');		
	$fonts[] = array('name'=>'Amatic SC');	
	$fonts[] = array('name'=>'Poiret One');	
	$fonts[] = array('name'=>'Rock Salt');		
	$fonts[] = array('name'=>'Covered By Your Grace');	
	$fonts[] = array('name'=>'Tangerine');		
	$fonts[] = array('name'=>'Freckle Face');		
	$fonts[] = array('name'=>'Nothing You Could Do');	
	$fonts[] = array('name'=>'Ravi Prakash');		
	$fonts[] = array('name'=>'Prata');		
	$fonts[] = array('name'=>'Nixie One');			
	$fonts[] = array('name'=>'Press Start 2P');			
	$fonts[] = array('name'=>'Sigmar One');			
	$fonts[] = array('name'=>'Reenie Beanie');		
	$fonts[] = array('name'=>'Crafty Girls');		
	$fonts[] = array('name'=>'Cabin Sketch');		
	$fonts[] = array('name'=>'Bungee Shade');			
	$fonts[] = array('name'=>'Aclonica');		
	$fonts[] = array('name'=>'Ewert');		
	$fonts[] = array('name'=>'Monoton');	
	$fonts[] = array('name'=>'Fredericka the Great');	
	$fonts[] = array('name'=>'Holtwood One SC');	
	
	$fonts[] = array('name'=>'Rammetto One');	
	$fonts[] = array('name'=>'Bowlby One SC');		
	$fonts[] = array('name'=>'Coiny');		
	$fonts[] = array('name'=>'Bungee Outline');		
	$fonts[] = array('name'=>'Kumar One Outline');		
	
	$fonts[] = array('name'=>'Shojumaru');		
	$fonts[] = array('name'=>'Raleway Dots');	
	$fonts[] = array('name'=>'Frijole');		
	$fonts[] = array('name'=>'Bonbon');	
	$fonts[] = array('name'=>'Megrim');		
	$fonts[] = array('name'=>'Codystar');		
	$fonts[] = array('name'=>'Rye');		
	$fonts[] = array('name'=>'Nosifer');				
	
	//$fonts[] = array('name'=>'myFirstFont', 'src'=>'http://www.w3schools.com/cssref/sansation_light.woff');
	
	$fonts = apply_filters('product_designer_fonts', $fonts);
	return $fonts;
	
	}




	
	function product_designer_page_list_ids(){

			$wp_query = new WP_Query(
				array (
					'post_type' => 'page',
					'posts_per_page' => -1,
					) );
					
			$pages_ids = array();
					
			if ( $wp_query->have_posts() ) :
			
	
			while ( $wp_query->have_posts() ) : $wp_query->the_post();
			
			$pages_ids[get_the_ID()] = get_the_title();
			
			
			endwhile;
			wp_reset_query();
			endif;
			
			
			return $pages_ids;
		
		}
	
	
	
	
	
	
function product_designer_create_order( $post_data ) {
	
	$userid = get_current_user_id();
	
	$response =array();
	
	$tdesigner_custom_design = sanitize_text_field($post_data['tdesigner_custom_design']);
	$quantity = sanitize_text_field($post_data['quantity']);
	$address = sanitize_text_field($post_data['address']);	
	$customer_name = sanitize_text_field($post_data['customer_name']);	
	$product_id = sanitize_text_field($post_data['product_id']);	
	
	$post_order = array(
	  'post_title'    => 'Order - '.date('d-m-y'),
	  'post_status'   => 'publish',
	  'post_type'   => 'pd_order',
	  'post_author'   => $userid,
	);
	
	$order_ID = wp_insert_post($post_order);
	
	update_post_meta( $order_ID, 'tdesigner_custom_design', $tdesigner_custom_design );	
	update_post_meta( $order_ID, 'address', $address );
	update_post_meta( $order_ID, 'customer_name', $customer_name );
	update_post_meta( $order_ID, 'quantity', $quantity );
	update_post_meta( $order_ID, 'product_id', $product_id );

	$response['order_created'] = 'yes';
	
	return $response;
	
	}	
	
	
	

	
// add_filter( 'the_content', 'product_designer_edit_link' );	
	
	
	
	
	
	
	
	
	
	
	
function product_designer_ajax_create_template(){

	$form_data = array();

	$json = isset($_POST['json']) ? sanitize_text_field($_POST['json']) : '';

	parse_str($_POST['form_data'], $form_data);
	$template_id = isset($form_data['template_id']) ? sanitize_text_field($form_data['template_id']) : '';
	$side_id = isset($form_data['side_id']) ? sanitize_text_field($form_data['side_id']) : '';
	$template_id = time();
	$template_name = isset($form_data['template_name']) ? sanitize_text_field($form_data['template_name']) : '';



	
	$templates = get_post_meta($template_id, 'pre_templates', true);

    $templates = !empty($templates) ? $templates : array();
	
	if(!empty($templates)){
		
		$templates[$side_id][$template_id]['name'] = $template_name;
		$templates[$side_id][$template_id]['content'] = $json;
		

	}else{
		
		$templates[$side_id][$template_id]['name'] = $template_name;
		$templates[$side_id][$template_id]['content'] = $json;
		

	}
	
	update_post_meta( $product_id, 'pre_templates', $templates );
	//update_post_meta($product_id, 'templates', $templates);

	$response['template_id'] = $template_id;
	$response['side_id'] = $side_id;

	$response['mgs'] = $form_data;


	//echo $templates;
	//echo ($templates);
	echo json_encode( $response );

	die();
	}
	
add_action('wp_ajax_product_designer_ajax_create_template', 'product_designer_ajax_create_template');
add_action('wp_ajax_nopriv_product_designer_ajax_create_template', 'product_designer_ajax_create_template');





function product_designer_ajax_update_template(){
	
	$json = isset( $_POST['json']) ?  sanitize_text_field($_POST['json']) : '';
	$current_side = isset($_POST['current_side']) ? sanitize_text_field($_POST['current_side']) : '';
	$t_id = isset($_POST['t_id']) ? sanitize_text_field($_POST['t_id']) : '';
	$product_id = isset($_POST['product_id']) ? sanitize_text_field($_POST['product_id']) : '';
	
	
	$templates = get_post_meta($product_id, 'templates', true);
	
	if(!empty($templates)){
		
		$templates[$current_side][$t_id]['name'] = $t_id;
		$templates[$current_side][$t_id]['content'] = $json;	
		
		}
	else{
		
		$templates[$current_side][time()]['name'] = time();
		$templates[$current_side][time()]['content'] = $json;		
		
		}
	
	update_post_meta( $product_id, 'templates', $templates );
	//update_post_meta($product_id, 'templates', $templates);
	
	//echo $templates;
	echo ($templates);
	
	die();
	}
	
add_action('wp_ajax_product_designer_ajax_update_template', 'product_designer_ajax_update_template');
add_action('wp_ajax_nopriv_product_designer_ajax_update_template', 'product_designer_ajax_update_template');	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
function product_designer_ajax_load_pre_template(){
	
	$pre_template_id = isset($_POST['pre_template_id']) ? sanitize_text_field($_POST['pre_template_id']) : '';
	$pd_template_id = isset($_POST['pd_template_id']) ? sanitize_text_field($_POST['pd_template_id']) : '';
	$response = array();
	
	
	$pre_templates = get_post_meta($pd_template_id, 'pre_templates', true);

	if(isset($pre_templates[$pre_template_id])):
		$response = $pre_templates[$pre_template_id];



	else:
		$response = array();

	endif;


	echo json_encode( $response );


	die();
	}
	
add_action('wp_ajax_product_designer_ajax_load_pre_template', 'product_designer_ajax_load_pre_template');
add_action('wp_ajax_nopriv_product_designer_ajax_load_pre_template', 'product_designer_ajax_load_pre_template');
	
	
	
	
	
	
	
	
	
	
	
	
function product_designer_ajax_base64_uplaod(){
	
	$base_64 = isset($_POST['base_64']) ? sanitize_text_field($_POST['base_64']) : '';
	$current_side = isset($_POST['current_side']) ? (string) sanitize_text_field($_POST['current_side']) : '';
	$product_id = isset($_POST['product_id']) ? (string) sanitize_text_field($_POST['product_id']) : '';


	$title = "Tattoo : ";



	$upload_dir       = wp_upload_dir();

	// @new
	$upload_path      = str_replace( '/', DIRECTORY_SEPARATOR, $upload_dir['path'] ) . DIRECTORY_SEPARATOR;

	//$img = $_POST['imageData'];
	$img = str_replace('data:image/png;base64,', '', $base_64);
	$img = str_replace(' ', '+', $img);

	$decoded          = base64_decode($img);

	$filename         = 'attachment.png';

	$hashed_filename  = time() . '_' . $filename;

	// @new
	$image_upload     = file_put_contents( $upload_path . $hashed_filename, $decoded );

	//HANDLE UPLOADED FILE
	if( !function_exists( 'wp_handle_sideload' ) ) {

	  require_once( ABSPATH . 'wp-admin/includes/file.php' );

	}

	// Without that I'm getting a debug error!?
	if( !function_exists( 'wp_get_current_user' ) ) {

	  require_once( ABSPATH . 'wp-includes/pluggable.php' );

	}

	// @new
	$file             = array();
	$file['error']    = '';
	$file['tmp_name'] = $upload_path . $hashed_filename;
	$file['name']     = $hashed_filename;
	$file['type']     = 'image/png';
	$file['size']     = filesize( $upload_path . $hashed_filename );

	// upload file to server
	// @new use $file instead of $image_upload
	$file_return      = wp_handle_sideload( $file, array( 'test_form' => false ) );

	$filename = $file_return['file'];
	$attachment = array(
	 'post_mime_type' => $file_return['type'],
	 'post_title' => preg_replace('/\.[^.]+$/', '', basename($filename)),
	 'post_content' => '',
	 'post_status' => 'inherit',
	 'guid' => esc_url_raw($wp_upload_dir['url']) . '/' . basename($filename)
	 );
		
	$attach_id = wp_insert_attachment( $attachment, $filename );
	$attach_url = wp_get_attachment_url( $attach_id );
	
	$attach_data = wp_generate_attachment_metadata($attach_id, $attach_url);
	wp_update_attachment_metadata($attach_id, $attach_data);
	
	$response = array();
	$response['attach_id'] = $attach_id;
	$response['attachment_url'] = esc_url_raw($attach_url);
	
	//echo json_encode($response);
	
	$cookie_name = "side_customized";
	
	$cook_data = isset($_COOKIE[$cookie_name]) ? sanitize_text_field($_COOKIE[$cookie_name]) : '';
	$cook_data = unserialize(stripslashes($cook_data));	
	//$cook_data = array();
	$cook_data[$product_id][$current_side] = $attach_id;
	
	
	//$cook_data = serialize($cook_data);

	
	
	$cookie_value = serialize($cook_data);
	setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/");
	
	
	
	//$attach_data = wp_generate_attachment_metadata($attach_id, $attach_url);
	//wp_update_attachment_metadata($attach_id, $attach_data);
	
	//echo $response;
	//echo json_encode($response);
	//var_dump($attach_id);
	
	die();
	
	
	
	}
	
add_action('wp_ajax_product_designer_ajax_base64_uplaod', 'product_designer_ajax_base64_uplaod');
add_action('wp_ajax_nopriv_product_designer_ajax_base64_uplaod', 'product_designer_ajax_base64_uplaod');






function product_designer_ajax_temp_save_side_output(){



	$product_id = isset($_POST['product_id']) ? sanitize_text_field($_POST['product_id']) : '';


	$session_id = session_id();

		$upload_dir       = wp_upload_dir();

		// @new
		$upload_path      = str_replace( '/', DIRECTORY_SEPARATOR, $upload_dir['path'] ) . DIRECTORY_SEPARATOR;

		$img = isset($_POST['base_64']) ?  sanitize_text_field($_POST['base_64']) : '';
		$img = str_replace('data:image/png;base64,', '', $img);
		$img = str_replace(' ', '+', $img);

		$decoded          = base64_decode($img) ;

		$filename         = 'product-designer.png';

		$hashed_filename  = md5( $filename . microtime() ) . '_' . $filename;

		// @new
		$image_upload     = file_put_contents( $upload_path . $hashed_filename, $decoded );

		//HANDLE UPLOADED FILE
		if( !function_exists( 'wp_handle_sideload' ) ) {

			require_once( ABSPATH . 'wp-admin/includes/file.php' );

		}

		// Without that I'm getting a debug error!?
		if( !function_exists( 'wp_get_current_user' ) ) {

			require_once( ABSPATH . 'wp-includes/pluggable.php' );

		}

		// @new
		$file             = array();
		$file['error']    = '';
		$file['tmp_name'] = $upload_path . $hashed_filename;
		$file['name']     = $hashed_filename;
		$file['type']     = 'image/png';
		$file['size']     = filesize( $upload_path . $hashed_filename );

		// upload file to server
		// @new use $file instead of $image_upload
		$file_return      = wp_handle_sideload( $file, array( 'test_form' => false ) );

		$filename = $file_return['file'];
		$attachment = array(
			'post_mime_type' => $file_return['type'],
			'post_title' => preg_replace('/\.[^.]+$/', '', basename($filename)),
			'post_content' => '',
			'post_status' => 'inherit',
			'guid' => esc_url_raw($upload_dir['url']) . '/' . basename($filename)
		);

		$attach_id = wp_insert_attachment( $attachment, $filename, 289 );
		require_once(ABSPATH . 'wp-admin/includes/image.php');
		$attach_data = wp_generate_attachment_metadata( $attach_id, $filename );
		wp_update_attachment_metadata( $attach_id, $attach_data );
		$attach_url = wp_get_attachment_url($attach_id);

		$jsonReturn = array(
			'attach_id'  =>  $attach_id,
			'attach_url'  =>  $attach_url,
		);



	echo json_encode($jsonReturn);








	die();



}

add_action('wp_ajax_product_designer_ajax_temp_save_side_output', 'product_designer_ajax_temp_save_side_output');
add_action('wp_ajax_nopriv_product_designer_ajax_temp_save_side_output', 'product_designer_ajax_temp_save_side_output');



function product_designer_ajax_delete_attach_id(){



	$attach_id = isset($_POST['attach_id']) ? sanitize_text_field($_POST['attach_id']) : '';

	if ( false === wp_delete_attachment( $attach_id ) ) {

		$status = 'failed';
	}
	else{
		$status = 'success';
	}


	$jsonReturn = array(
		'status'  =>  $status,

	);

	echo json_encode($jsonReturn);

	die();
}

add_action('wp_ajax_product_designer_ajax_delete_attach_id', 'product_designer_ajax_delete_attach_id');
add_action('wp_ajax_nopriv_product_designer_ajax_delete_attach_id', 'product_designer_ajax_delete_attach_id');






function product_designer_ajax_paged_shape_list(){


    $product_designer_settings = get_option('product_designer_settings');
    $posts_per_page = isset($product_designer_settings['posts_per_page']) ? $product_designer_settings['posts_per_page'] : '';


    $response = array();
    $clip_list_html = '';
    $paginatioon_html = '';

    $cat_id = isset($_POST['cat']) ? sanitize_text_field($_POST['cat']) : '';
    $paged = isset($_POST['paged']) ? sanitize_text_field($_POST['paged']) : '';

    if($cat_id=='all'){
        $tax_query = array();
    }else{
        $tax_query = array(
            array(
                'taxonomy' => 'shape_cat',
                'field' => 'id',
                'terms' => $cat_id,
            )
        );
    }



    $args = array(
        'post_type'=>'shape',
        'posts_per_page'=> $posts_per_page,
        'tax_query' => $tax_query,
        'paged' => $paged,
    );


    $shape_wp_query = new WP_Query($args);

    if ( $shape_wp_query->have_posts() ) :
        while ( $shape_wp_query->have_posts() ) : $shape_wp_query->the_post();


            $shape_thumb_id = get_post_meta(get_the_ID(),'shape_thumb_id', true);
            $shape_price = get_post_meta(get_the_ID(),'shape_price', true);

            $shape_url = wp_get_attachment_image_src($shape_thumb_id, 'full' );
            $shape_url = isset($shape_url['0']) ? $shape_url['0']  : '';

            $thumb = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), 'full' );
            $thumb_url = isset($thumb['0']) ? $thumb['0']  : '';


            $shape_url = !empty($shape_url) ? $shape_url : $thumb_url;


            if(!empty($shape_url))
                $clip_list_html .= '<img data-price="'.$shape_price.'"  title="'.get_the_title().'" src="'.esc_url_raw($shape_url).'" />';




        endwhile;


        $big = 999999999; // need an unlikely integer
        $paginatioon_html .= paginate_links( array(
            'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
            'format' => '?paged=%#%',
            'current' => max( 1, $paged ),
            'prev_text'          => '',
            'next_text'          => '',
            'total' => $shape_wp_query->max_num_pages,
        ) );

        //$response['paginatioon'].= '1 > 2 > 3';

        wp_reset_query();
    endif;


    $response['shape_list'] = $clip_list_html;
    $response['paginatioon'] = $paginatioon_html;

    echo json_encode($response);

    die();

}
add_action('wp_ajax_product_designer_ajax_paged_shape_list', 'product_designer_ajax_paged_shape_list');
add_action('wp_ajax_nopriv_product_designer_ajax_paged_shape_list', 'product_designer_ajax_paged_shape_list');








function product_designer_ajax_paged_clipart_list(){


    $product_designer_settings = get_option('product_designer_settings');
    $posts_per_page = isset($product_designer_settings['posts_per_page']) ? $product_designer_settings['posts_per_page'] : '';


    $response = array();
    $clip_list_html = '';
    $paginatioon_html = '';

    $cat_id = isset($_POST['cat']) ? sanitize_text_field($_POST['cat']) : '';
    $paged = isset($_POST['paged']) ? sanitize_text_field($_POST['paged']) : '';

    if($cat_id=='all'){
        $tax_query = array();
    }else{
        $tax_query = array(
            array(
               'taxonomy' => 'clipart_cat',
               'field' => 'id',
               'terms' => $cat_id,
            )
        );
    }



    $args = array(
        'post_type'=>'clipart',
        'posts_per_page'=> $posts_per_page,
        'tax_query' => $tax_query,
        'paged' => $paged,
    );


    $clipart_wp_query = new WP_Query($args);

    if ( $clipart_wp_query->have_posts() ) :
    while ( $clipart_wp_query->have_posts() ) : $clipart_wp_query->the_post();


        $clipart_thumb_id = get_post_meta(get_the_ID(),'clipart_thumb_id', true);
        $clipart_price = get_post_meta(get_the_ID(),'clipart_price', true);

        $clipart_url = wp_get_attachment_image_src($clipart_thumb_id, 'full' );
        $clipart_url = isset($clipart_url['0']) ? $clipart_url['0']  : '';

        $thumb = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), 'full' );
        $thumb_url = isset($thumb['0']) ? $thumb['0']  : '';


        $clipart_url = !empty($clipart_url) ? $clipart_url : $thumb_url;


        if(!empty($clipart_url))
            $clip_list_html .= '<img data-price="'.$clipart_price.'"  title="'.get_the_title().'" src="'.esc_url_raw($clipart_url).'" />';




    endwhile;


    $big = 999999999; // need an unlikely integer
        $paginatioon_html .= paginate_links( array(
        'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
        'format' => '?paged=%#%',
        'current' => max( 1, $paged ),
        'prev_text'          => '',
        'next_text'          => '',
        'total' => $clipart_wp_query->max_num_pages,
        ) );

    //$response['paginatioon'].= '1 > 2 > 3';

    wp_reset_query();
    endif;


    $response['clip_list'] = $clip_list_html;
    $response['paginatioon'] = $paginatioon_html;

    echo json_encode($response);

    die();

}
add_action('wp_ajax_product_designer_ajax_paged_clipart_list', 'product_designer_ajax_paged_clipart_list');
add_action('wp_ajax_nopriv_product_designer_ajax_paged_clipart_list', 'product_designer_ajax_paged_clipart_list');	
	
	
	
	
	
	
function product_designer_ajax_get_clipart_list(){
	

    $product_designer_settings = get_option('product_designer_settings');
    $posts_per_page = isset($product_designer_settings['posts_per_page']) ? $product_designer_settings['posts_per_page'] : '';



    $response = array();
    $clip_list_html = '';
    $paginatioon_html = '';

    $cat_id = isset($_POST['cat']) ? sanitize_text_field($_POST['cat']) : '';

    if($cat_id=='all'){
        $tax_query = array();

    }else{
        $tax_query = array(
            array(
               'taxonomy' => 'clipart_cat',
               'field' => 'id',
               'terms' => $cat_id,
            )
        );
    }

		

    $args = array(
        'post_type'=>'clipart',
        'posts_per_page'=>$posts_per_page,
        'tax_query' => $tax_query,

        );


    $clipart_wp_query = new WP_Query($args);

    if ( $clipart_wp_query->have_posts() ) :
    while ( $clipart_wp_query->have_posts() ) : $clipart_wp_query->the_post();

        $clipart_thumb_id = get_post_meta(get_the_ID(),'clipart_thumb_id', true);
        $clipart_price = get_post_meta(get_the_ID(),'clipart_price', true);

        $clipart_url = wp_get_attachment_image_src($clipart_thumb_id, 'full' );
        $clipart_url = isset($clipart_url['0']) ? $clipart_url['0']  : '';

        $thumb = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), 'full' );
        $thumb_url = isset($thumb['0']) ? $thumb['0']  : '';


        $clipart_url = !empty($clipart_url) ? $clipart_url : $thumb_url;


    if(!empty($clipart_url))
        $clip_list_html.= '<img data-price="'.$clipart_price.'"  title="'.get_the_title().'" src="'.esc_url_raw($clipart_url).'" />';

    endwhile;


    $paged = 1;
    $big = 999999999; // need an unlikely integer
        $paginatioon_html.= paginate_links( array(
        'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
        'format' => '?paged=%#%',
        'current' => max( 1, $paged ),
        'prev_text'          => '',
        'next_text'          => '',
        'total' => $clipart_wp_query->max_num_pages,
        ) );

    //$response['paginatioon'].= '1 > 2 > 3';

    wp_reset_query();
    endif;


    $response['clip_list'] = $clip_list_html;
    $response['paginatioon'] = $paginatioon_html;

		echo json_encode($response);
		
		die();
	
	}	
add_action('wp_ajax_product_designer_ajax_get_clipart_list', 'product_designer_ajax_get_clipart_list');
add_action('wp_ajax_nopriv_product_designer_ajax_get_clipart_list', 'product_designer_ajax_get_clipart_list');




function product_designer_ajax_get_shape_list(){



    $product_designer_settings = get_option('product_designer_settings');
    $posts_per_page = isset($product_designer_settings['posts_per_page']) ? $product_designer_settings['posts_per_page'] : '';



    $response = array();
    $clip_list_html = '';
    $paginatioon_html = '';

    $cat_id = isset($_POST['cat']) ? sanitize_text_field($_POST['cat']) : '';

    if($cat_id=='all'){
        $tax_query = array();

    }else{
        $tax_query = array(
            array(
                'taxonomy' => 'shape_cat',
                'field' => 'id',
                'terms' => $cat_id,
            )
        );
    }



    $args = array(
        'post_type'=>'shape',
        'posts_per_page'=>$posts_per_page,
        'tax_query' => $tax_query,

    );


    $shape_wp_query = new WP_Query($args);

    if ( $shape_wp_query->have_posts() ) :
        while ( $shape_wp_query->have_posts() ) : $shape_wp_query->the_post();

            $shape_thumb_id = get_post_meta(get_the_ID(),'shape_thumb_id', true);
            $shape_price = get_post_meta(get_the_ID(),'shape_price', true);

            $shape_url = wp_get_attachment_image_src($shape_thumb_id, 'full' );
            $shape_url = isset($shape_url['0']) ? $shape_url['0']  : '';

            $thumb = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), 'full' );
            $thumb_url = isset($thumb['0']) ? $thumb['0']  : '';


            $shape_url = !empty($shape_url) ? $shape_url : $thumb_url;


            if(!empty($shape_url))
                $clip_list_html.= '<img data-price="'.$shape_price.'"  title="'.get_the_title().'" src="'.esc_url_raw($shape_url).'" />';

        endwhile;


        $paged = 1;
        $big = 999999999; // need an unlikely integer
        $paginatioon_html.= paginate_links( array(
            'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
            'format' => '?paged=%#%',
            'current' => max( 1, $paged ),
            'prev_text'          => '',
            'next_text'          => '',
            'total' => $shape_wp_query->max_num_pages,
        ) );

        //$response['paginatioon'].= '1 > 2 > 3';

        wp_reset_query();
    endif;


    $response['shape_list'] = $clip_list_html;
    $response['paginatioon'] = $paginatioon_html;

    echo json_encode($response);

    die();

}
add_action('wp_ajax_product_designer_ajax_get_shape_list', 'product_designer_ajax_get_shape_list');
add_action('wp_ajax_nopriv_product_designer_ajax_get_shape_list', 'product_designer_ajax_get_shape_list');
