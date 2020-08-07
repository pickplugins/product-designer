<?php

/*
* @Author 		ParaTheme
* Copyright: 	2015 ParaTheme
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 	


class class_product_designer_functions  {
	
	
    public function __construct(){

		
		//add_action('add_meta_boxes', array( $this, 'clipart_meta_boxes' ));
	
		
    }



    public function tour_guide(){

        $product_designer_settings = get_option('product_designer_settings');
        $menu_position = isset($product_designer_settings['menu_position']) ? $product_designer_settings['menu_position'] : '';

        $data = array(
            array(
                'title' => __('#1 Product Sides',''),
                'html' => __('Click here to load side and ready for edit.'),
                'focus' => '1',
                'position' => array(
                    'container' => '',
                    'x' => '-350',
                    'y' => '0',
                    'width' => '300',
                    'arrow' => 'rt',
                ),
                'buttons' => array(
                    'Next' => 1,
                ),
            ),
        );


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

