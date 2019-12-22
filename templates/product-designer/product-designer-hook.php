<?php

/*
* @Author 		pickplugins
* Copyright: 	2015 pickplugins
*/

if ( ! defined('ABSPATH')) exit;  // if direct access

//add_action('product_designer', 'product_designer_menu');
//add_action('product_designer', 'product_designer_edit_panel');
//add_action('product_designer', 'product_designer_canvas');

//add_action('product_designer', 'product_designer_final');
//add_action('product_designer', 'product_designer_css');
//add_action('product_designer', 'product_designer_js');


	
function product_designer_menu(){

	include product_designer_plugin_dir.'/templates/product-designer/product-designer-menu.php';

}

function product_designer_edit_panel(){

	include product_designer_plugin_dir.'/templates/product-designer/product-designer-edit-panel.php';

}


function product_designer_canvas(){

	include product_designer_plugin_dir.'/templates/product-designer/product-designer-canvas.php';

}

function product_designer_final(){

	include product_designer_plugin_dir.'/templates/product-designer/product-designer-final.php';

}

function product_designer_css(){

	include product_designer_plugin_dir.'/templates/product-designer/product-designer-css.php';

}

function product_designer_js(){

	include product_designer_plugin_dir.'/templates/product-designer/product-designer-js.php';

}














