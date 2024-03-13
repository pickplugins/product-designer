<?php



if ( ! defined('ABSPATH')) exit;  // if direct access 	


class class_product_designer_functions{
	
	
    public function __construct(){

		
		//add_action('add_meta_boxes', array( $this, 'clipart_meta_boxes' ));
	
		
    }

    public function is_pro_active(){

        if ( is_plugin_active( 'product-designer-pro/product-designer-pro.php' ) ) {
            return true;
        }else{
            return false;
        }
    }

    public function is_license_active(){

        if ( is_plugin_active( 'product-designer-pro/product-designer-pro.php' ) ) {
            $product_designer_settings = get_option('product_designer_settings');
            $license_status = isset($product_designer_settings['license_status']) ? $product_designer_settings['license_status'] : '';


            if($license_status =='active') return true;
            else return false;
        }else{
            return false;
        }

    }


    public function tour_guide_steps(){

        $product_designer_settings = get_option('product_designer_settings');
        $menu_position = isset($product_designer_settings['menu_position']) ? $product_designer_settings['menu_position'] : 'left';

        //var_dump($menu_position);

        $data = array(
            array(
                'title' => __('#1 Product Sides','product-designer'),
                'html' => __('Click here to load side and ready for edit.', 'product-designer'),
                'focus' => 1,
                'priority' => 5,
                'position' => array(
                    'container' => '.pd-guide-1',
                    'x' => ($menu_position == 'left') ? 340 : -350,
                    'y' => 0,
                    'width' => 300,
                    'arrow' => ($menu_position == 'left') ? 'lt' : 'rt',
                ),
                'buttons' => array(
                    'Next' => 1,
                ),
            ),
            array(
                'title' => __('#2 Clipart & Assets','product-designer'),
                'html' => __('You can add some clipart here also you can upload your own.', 'product-designer'),
                'focus' => 1,
                'priority' => 10,
                'position' => array(
                    'container' => '.pd-guide-2',
                    'x' => ($menu_position == 'left') ? 340 : -350,
                    'y' => 0,
                    'width' => 300,
                    'arrow' => ($menu_position == 'left') ? 'lt' : 'rt',
                ),
                'buttons' => array(
                    'Prev' => -1,
                    'Next' => 1,
                ),
            ),
            array(
                'title' => __('#3 Text','product-designer'),
                'html' => __('You can add text from here, there also curved text available.', 'product-designer'),
                'focus' => 1,
                'priority' => 15,
                'position' => array(
                    'container' => '.pd-guide-3',
                    'x' => ($menu_position == 'left') ? 340 : -350,
                    'y' => 0,
                    'width' => 300,
                    'arrow' => ($menu_position == 'left') ? 'lt' : 'rt',
                ),
                'buttons' => array(
                    'Prev' => -1,
                    'Next' => 1,
                ),
            ),
            array(
                'title' => __('#4 Shapes','product-designer'),
                'html' => __('Some exclusive shapes here, you can add them to your design.', 'product-designer'),
                'focus' => 1,
                'priority' => 20,
                'position' => array(
                    'container' => '.pd-guide-4',
                    'x' => ($menu_position == 'left') ? 340 : -350,
                    'y' => 0,
                    'width' => 300,
                    'arrow' => ($menu_position == 'left') ? 'lt' : 'rt',
                ),
                'buttons' => array(
                    'Prev' => -1,
                    'Next' => 1,
                ),
            ),
            array(
                'title' => __('5 Editor actions','product-designer'),
                'html' => __('Choose actions button to customize your design.','product-designer'),
                'focus' => 1,
                'priority' => 25,
                'position' => array(
                    'container' => '.pd-guide-5',
                    'x' => ($menu_position == 'left') ? 340 : -350,
                    'y' => 0,
                    'width' => 300,
                    'arrow' => ($menu_position == 'left') ? 'lt' : 'rt',
                ),
                'buttons' => array(
                    'Prev' => -1,
                    'Next' => 1,
                ),
            ),
            array(
                'title' => __('#6 Preview','product-designer'),
                'html' => __('Click preview button to see current canvas preview.', 'product-designer'),
                'focus' => 1,
                'priority' => 30,
                'position' => array(
                    'container' => '.pd-guide-6',
                    'x' => ($menu_position == 'left') ? 160 : -350,
                    'y' => 0,
                    'width' => 300,
                    'arrow' => ($menu_position == 'left') ? 'lt' : 'rt',
                ),
                'buttons' => array(
                    'Prev' => -1,
                    'Next' => 1,
                ),
            ),
            array(
                'title' => __('#7 Download','product-designer'),
                'html' => __('Click download your customized design.', 'product-designer'),
                'focus' => 1,
                'priority' => 35,
                'position' => array(
                    'container' => '.pd-guide-7',
                    'x' => ($menu_position == 'left') ? 160 : -350,
                    'y' => 0,
                    'width' => 300,
                    'arrow' => ($menu_position == 'left') ? 'lt' : 'rt',
                ),
                'buttons' => array(
                    'Prev' => -1,
                    'Next' => 1,
                ),
            ),
            array(
                'title' => __('#8 Item list','product-designer'),
                'html' => __('Click to see object added on canvas for current view.', 'product-designer'),
                'focus' => 1,
                'priority' => 40,
                'position' => array(
                    'container' => '.pd-guide-8',
                    'x' => ($menu_position == 'left') ? 340 : -350,
                    'y' => 0,
                    'width' => 300,
                    'arrow' => ($menu_position == 'left') ? 'lt' : 'rt',
                ),
                'buttons' => array(
                    'Prev' => -1,
                    'Next' => 1,
                ),
            ),
            array(
                'title' => __('#9 Product info & Cart','product-designer'),
                'html' => __('After finishing the design you will see the preview and add them to cart and proceed to submit order.', 'product-designer'),
                'focus' => 1,
                'priority' => 45,
                'position' => array(
                    'container' => '.pd-guide-9',
                    'x' => ($menu_position == 'left') ? 340 : -350,
                    'y' => 0,
                    'width' => 300,
                    'arrow' => ($menu_position == 'left') ? 'lt' : 'rt',
                ),
                'buttons' => array(
                    'Prev' => -1,
                    'Next' => 1,
                ),
            ),
            array(
                'title' => __('#10 Keyboard Shortcuts','product-designer'),
                'html' => __('Use keyboard shortcuts to speed up your work.', 'product-designer'),
                'focus' => 1,
                'priority' => 50,
                'position' => array(
                    'container' => '.pd-guide-10',
                    'x' => ($menu_position == 'left') ? 340 : -350,
                    'y' => 0,
                    'width' => 300,
                    'arrow' => ($menu_position == 'left') ? 'lt' : 'rt',
                ),
                'buttons' => array(
                    'Prev' => -1,
                    'Next' => 1,
                    'Done' => 2,
                ),
            ),



        );


        $data = apply_filters('product_designer_tour_guide_steps', $data);

        $data_sorted = array();

        if(!empty($data))
        foreach ($data as $page_key => $tab){
            $data_sorted[$page_key] = isset( $tab['priority'] ) ? $tab['priority'] : 0;
        }


        array_multisort($data_sorted, SORT_ASC, $data);

        //var_dump($data_sorted);

        return $data;

    }


	

}


new class_product_designer_functions();

