<?php

/*
* @Author 		ParaTheme
* Copyright: 	2015 ParaTheme
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 	


class class_product_designer_functions{
	
	
    public function __construct(){

		
		//add_action('add_meta_boxes', array( $this, 'clipart_meta_boxes' ));
	
		
    }



    public function tour_guide_steps(){

        $product_designer_settings = get_option('product_designer_settings');
        $menu_position = isset($product_designer_settings['menu_position']) ? $product_designer_settings['menu_position'] : 'left';

        //var_dump($menu_position);

        $data = array(
            array(
                'title' => __('#1 Product Sides',''),
                'html' => __('Click here to load side and ready for edit.'),
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
                'title' => __('#2 Clipart & Assets',''),
                'html' => __('You can add some clipart here also you can upload your own.'),
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
                'title' => __('#3 Text',''),
                'html' => __('You can add text from here, there also curved text available.'),
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
                'title' => __('#4 Shapes',''),
                'html' => __('Some exclusive shapes here, you can add them to your design.'),
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
                'title' => __('5 Editor actions',''),
                'html' => __('Choose actions button to customize your design.'),
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
                'title' => __('#6 Preview',''),
                'html' => __('Click preview button to see current canvas preview.'),
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
                'title' => __('#7 Download',''),
                'html' => __('Click download your customized design.'),
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
                'title' => __('#8 Item list',''),
                'html' => __('Click to see object added on canvas for current view.'),
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
                'title' => __('#9 Product info & Cart',''),
                'html' => __('After finishing the design you will see the preview and add them to cart and proceed to submit order.'),
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
                'title' => __('#10 Keyboard Shortcuts',''),
                'html' => __('Use keyboard shortcuts to speed up your work.'),
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


	public function tutorials(){

		$tutorials[] = array(
							'title'=>__('How to Install?', 'product-designer'),
							'video_id'=>'DNG07bincDk',
							'source'=>'youtube',
							);
							
		$tutorials[] = array(
							'title'=>__('How to Configure?', 'product-designer'),
							'video_id'=>'T_ppBuGcxnQ',
							'source'=>'youtube',
							);							
							
		$tutorials[] = array(
							'title'=>__('Tour Guide', 'product-designer'),
							'video_id'=>'qK2MyS10uFI',
							'source'=>'youtube',
							);

		$tutorials[] = array(
			'title'=>__('How to add Cliparts, QR code, Barcode on design?', 'product-designer'),
			'video_id'=>'U7_UDxjo6bk',
			'source'=>'youtube',
		);

		$tutorials[] = array(
			'title'=>__('How to add Text & Curve Text on Design?', 'product-designer'),
			'video_id'=>'c_bOmHD8--w',
			'source'=>'youtube',
		);



		$tutorials = apply_filters('product_designer_filters_tutorials', $tutorials);		

		return $tutorials;

		}	
	
	
	public function faq(){



		$faq['core'] = array(
							'title'=>__('Core', 'product-designer'),
							'items'=>array(



											array(
												'question'=>__('How to display Product Designer Editor?', 'product-designer'),
												'answer_url'=>'https://www.pickplugins.com/documentation/product-designer/faq/how-to-display-product-designer-editor/',

												),




											),

								
							);

					
		
		
		$faq = apply_filters('product_designer_filters_faq', $faq);		

		return $faq;

		}		
	
	

}


new class_product_designer_functions();

