<?php

/*
* @Author 		pickplugins
* Copyright: 	2015 pickplugins
*/

if ( ! defined('ABSPATH')) exit;  // if direct access


?>

<style>
    <?php
	foreach($Tdesigner_google_fonts as $font){


		$Fontname = $font['name'];
		$name = str_replace(' ','+',$Fontname);

		if(!empty($font['src'])){
			$src = $font['src'];
			?>
    @font-face {
        font-family: <?php echo $Fontname; ?>;
        src: url("<?php echo $src; ?>");
    }

    <?php


	}
else{
	?>
    @import url('https://fonts.googleapis.com/css?family=<?php echo $name; ?>');

    <?php
	}


}




    if(!empty($side_data))
    foreach($side_data as $id=>$side){
        $src = isset($side['src']) ? $side['src'] : '';

        if($current_side==$id){

            ?>

            .canvas-container{
                /*background:rgba(0, 0, 0, 0) url("<?php echo $src; ?>") no-repeat scroll 0 0;*/
            }


            <?php

        }

    }












?>
</style>