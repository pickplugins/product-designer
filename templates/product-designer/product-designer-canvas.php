<?php

/*
* @Author 		pickplugins
* Copyright: 	2015 pickplugins
*/

if ( ! defined('ABSPATH')) exit;  // if direct access

$product_designer_canvas_width = get_option( 'product_designer_canvas_width', '500' );
$product_designer_canvas_height = get_option( 'product_designer_canvas_height', '600' );

?>
<div id="designer" class="designer">
    <canvas id="c" width="<?php echo $product_designer_canvas_width; ?>" height="<?php echo $product_designer_canvas_height; ?>"></canvas>
</div>
