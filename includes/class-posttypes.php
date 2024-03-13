<?php



if ( ! defined('ABSPATH')) exit;  // if direct access 	


class class_product_designer_posttypes  {
	
	
    public function __construct(){

        add_filter( 'display_post_states', array( $this, '_post_states' ), 10, 2 );

	    add_action('init', array( $this, 'posttype_pd_template' ));
        //add_action('init', array( $this, 'posttype_pd_pre_template' ));

		add_action('init', array( $this, 'posttype_clipart' ));
		add_action( 'init', array( $this, 'clipart_taxonomies' ), 0 );

        add_action('init', array( $this, 'posttype_shape' ));
        add_action( 'init', array( $this, 'shape_taxonomies' ), 0 );


		//add_action('init', array( $this, 'posttype_pd_order' ), 100);
		
    }

    public function _post_states( $post_states, $post ){

        if($post->post_type != 'product') return $post_states;


        $is_customizable = product_designer_is_customizable($post->ID );

        //var_dump($is_customizable);

        if (   $is_customizable ) {

            $post_states['pd_is_customizable'] = __( '<span title="Customizable Product" class="dashicons dashicons-admin-appearance"></span>', 'wishlist' );
        }

        return $post_states;
    }


	public function posttype_pd_template(){

		$labels = array(
			'name' => _x('Product Designer', 'product-designer'),
			'singular_name' => _x('Template', 'product-designer'),
			'add_new' => _x('Add Template', 'product-designer'),
			'add_new_item' => __('Add Template', 'product-designer'),
			'edit_item' => __('Edit Template', 'product-designer'),
			'new_item' => __('New Template', 'product-designer'),
			'view_item' => __('View Template', 'product-designer'),
			'search_items' => __('Search Template', 'product-designer'),
			'not_found' =>  __('Nothing found', 'product-designer'),
			'not_found_in_trash' => __('Nothing found in Trash', 'product-designer'),
			'parent_item_colon' => ''
		);

		$args = array(
			'labels' => $labels,
			'public' => true,
			'publicly_queryable' => true,
			'show_ui' => true,
			'query_var' => true,
			'menu_icon' => 'dashicons-nametag',
			'rewrite' => true,
			'capability_type' => 'post',
			'hierarchical' => false,
            'show_in_nav_menus' => true,

            'menu_position' => null,
			'supports' => array('title'),
			//'show_in_menu' 	=> 'admin.php?page=product_designer',

		);

		register_post_type( 'pd_template' , $args );


	}




    public function posttype_pd_pre_template(){

        $labels = array(
            'name' => _x('Saved Templates', 'product-designer'),
            'singular_name' => _x('Saved Template', 'product-designer'),
            'add_new' => _x('Add Template', 'product-designer'),
            'add_new_item' => __('Add Template', 'product-designer'),
            'edit_item' => __('Edit Template', 'product-designer'),
            'new_item' => __('New Template', 'product-designer'),
            'view_item' => __('View Template', 'product-designer'),
            'search_items' => __('Search Template', 'product-designer'),
            'not_found' =>  __('Nothing found', 'product-designer'),
            'not_found_in_trash' => __('Nothing found in Trash', 'product-designer'),
            'parent_item_colon' => ''
        );

        $args = array(
            'labels' => $labels,
            'public' => true,
            'publicly_queryable' => true,
            'show_ui' => true,
            'query_var' => true,
            'menu_icon' => 'dashicons-nametag',
            'rewrite' => true,
            'capability_type' => 'post',
            'hierarchical' => false,
            'menu_position' => null,
            'supports' => array('title'),
            //'show_in_menu' 	=> 'pd_template',
            //'show_in_menu' 	=> 'product_designer',
            'show_in_menu' 	=> 'edit.php?post_type=pd_template',



        );

        register_post_type( 'pd_pre_template' , $args );


    }









    public function posttype_clipart(){

        $labels = array(
            'name' => _x('Clip Art', 'product-designer'),
            'singular_name' => _x('Clip Art', 'product-designer'),
            'add_new' => _x('Add Clip Art', 'product-designer'),
            'add_new_item' => __('Add Clip Art', 'product-designer'),
            'edit_item' => __('Edit Clip Art', 'product-designer'),
            'new_item' => __('New Clip Art', 'product-designer'),
            'view_item' => __('View Clip Art', 'product-designer'),
            'search_items' => __('Search Clip Art', 'product-designer'),
            'not_found' =>  __('Nothing found', 'product-designer'),
            'not_found_in_trash' => __('Nothing found in Trash', 'product-designer'),
            'parent_item_colon' => ''
    );

        $args = array(
                'labels' => $labels,
                'public' => true,
                'publicly_queryable' => true,
                'show_ui' => true,
                'query_var' => true,
                'menu_icon' => 'dashicons-nametag',
                'rewrite' => true,
                'capability_type' => 'post',
                'hierarchical' => false,
                'menu_position' => null,
                'supports' => array('title'),
            'show_in_menu' 	=> 'edit.php?post_type=pd_template',


        );
 
        register_post_type( 'clipart' , $args );
			
			
			}




	
	    public function clipart_taxonomies(){
			
			
				register_taxonomy('clipart_cat', 'clipart', array(
						// Hierarchical taxonomy (like categories)
						'hierarchical' => true,
						'show_admin_column' => true,
						// This array of options controls the labels displayed in the WordPress Admin UI
						'labels' => array(
								'name' => _x( 'Clip Art Categories', 'product-designer' ),
								'singular_name' => _x( 'Clip Art Categories', 'product-designer' ),
								'search_items' =>  __( 'Search Clip Art Categories', 'product-designer' ),
								'all_items' => __( 'All Clip Art Categories', 'product-designer' ),
								'parent_item' => __( 'Parent Clip Art Categories', 'product-designer' ),
								'parent_item_colon' => __( 'Parent Clip Art Categories:', 'product-designer' ),
								'edit_item' => __( 'Edit Clip Art Categories', 'product-designer' ),
								'update_item' => __( 'Update Clip Art Categories', 'product-designer' ),
								'add_new_item' => __( 'Add Clip Art Categories', 'product-designer' ),
								'new_item_name' => __( 'New Clip Art Categories Name', 'product-designer' ),
								'menu_name' => __( 'Clip Art Categories', 'product-designer' ),
								
						),
						// Control the slugs used for this taxonomy
						'rewrite' => array(
								'slug' => 'clipart_cat', // This controls the base slug that will display before each term
								'with_front' => false, // Don't display the category base before "/locations/"
								'hierarchical' => true // This will allow URL's like "/locations/boston/cambridge/"
						),
				));
			
			
			}









    public function posttype_shape(){

        $labels = array(
            'name' => _x('Shape', 'product-designer'),
            'singular_name' => _x('Shape', 'product-designer'),
            'add_new' => _x('Add Shape', 'product-designer'),
            'add_new_item' => __('Add Shape', 'product-designer'),
            'edit_item' => __('Edit Shape', 'product-designer'),
            'new_item' => __('New Shape', 'product-designer'),
            'view_item' => __('View Shape', 'product-designer'),
            'search_items' => __('Search Shape', 'product-designer'),
            'not_found' =>  __('Nothing found', 'product-designer'),
            'not_found_in_trash' => __('Nothing found in Trash', 'product-designer'),
            'parent_item_colon' => ''
        );

        $args = array(
            'labels' => $labels,
            'public' => true,
            'publicly_queryable' => true,
            'show_ui' => true,
            'query_var' => true,
            'menu_icon' => 'dashicons-nametag',
            'rewrite' => true,
            'capability_type' => 'post',
            'hierarchical' => false,
            'menu_position' => null,
            'supports' => array('title'),
            'show_in_menu' 	=> 'edit.php?post_type=pd_template',


        );

        register_post_type( 'shape' , $args );


    }





    public function shape_taxonomies(){


        register_taxonomy('shape_cat', 'shape', array(
            // Hierarchical taxonomy (like categories)
            'hierarchical' => true,
            'show_admin_column' => true,
            // This array of options controls the labels displayed in the WordPress Admin UI
            'labels' => array(
                'name' => _x( 'Shape Categories', 'product-designer' ),
                'singular_name' => _x( 'Shape Categories', 'product-designer' ),
                'search_items' =>  __( 'Search Shape Categories', 'product-designer' ),
                'all_items' => __( 'All Shape Categories', 'product-designer' ),
                'parent_item' => __( 'Parent Shape Categories', 'product-designer' ),
                'parent_item_colon' => __( 'Parent Shape Categories:', 'product-designer' ),
                'edit_item' => __( 'Edit Shape Categories', 'product-designer' ),
                'update_item' => __( 'Update Shape Categories', 'product-designer' ),
                'add_new_item' => __( 'Add Shape Categories', 'product-designer' ),
                'new_item_name' => __( 'New Shape Categories Name', 'product-designer' ),
                'menu_name' => __( 'Shape Categories' ),

            ),
            // Control the slugs used for this taxonomy
            'rewrite' => array(
                'slug' => 'shape_cat', // This controls the base slug that will display before each term
                'with_front' => false, // Don't display the category base before "/locations/"
                'hierarchical' => true // This will allow URL's like "/locations/boston/cambridge/"
            ),
        ));


    }

















    public function posttype_pd_order(){
			
	        $labels = array(
                'name' => _x('Order', 'product-designer'),
                'singular_name' => _x('Order', 'product-designer'),
                'add_new' => _x('Add Order', 'product-designer'),
                'add_new_item' => __('Add Order', 'product-designer'),
                'edit_item' => __('Edit Order', 'product-designer'),
                'new_item' => __('New Order', 'product-designer'),
                'view_item' => __('View Order', 'product-designer'),
                'search_items' => __('Search Order', 'product-designer'),
                'not_found' =>  __('Nothing found', 'product-designer'),
                'not_found_in_trash' => __('Nothing found in Trash', 'product-designer'),
                'parent_item_colon' => ''
        );

        $args = array(
                'labels' => $labels,
                'public' => true,
                'publicly_queryable' => true,
                'show_ui' => true,
                'query_var' => true,
                'menu_icon' => 'dashicons-nametag',
                'rewrite' => true,
                'capability_type' => 'post',
                'hierarchical' => false,
                'menu_position' => null,
				'show_in_menu' 	=> 'product_designer',	
                'supports' => array('title','thumbnail','custom-fields'),
				

          );
 
        register_post_type( 'pd_order' , $args );
			
			
			}
}


new class_product_designer_posttypes();

