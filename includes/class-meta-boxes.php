<?php
if ( ! defined('ABSPATH')) exit;  // if direct access

class product_designer_meta_boxes{
	
	public function __construct(){


		// meta box for clipart
        add_action('add_meta_boxes', array($this, 'clipart'));
        add_action('save_post', array($this, 'clipart_save'));

        add_action('add_meta_boxes', array($this, 'shape'));
        add_action('save_post', array($this, 'shape_save'));

        //meta box for "pd_template"
        add_action('add_meta_boxes', array($this, 'pd_template'));
        add_action('save_post', array($this, 'pd_template_save'));

		}


	public function pd_template($post_type){

            add_meta_box('post-grid-layout',__('Template data', 'product-designer'), array($this, 'pd_template_display'), 'pd_template', 'normal', 'high');
	}

    public function clipart($post_type){

        add_meta_box('product-designer',__('Clipart Options', 'product-designer'), array($this, 'clipart_display'), 'clipart', 'normal', 'high');

    }


    public function shape($post_type){

        add_meta_box('product-designer',__('shape Options', 'product-designer'), array($this, 'shape_display'), 'shape', 'normal', 'high');

    }



	public function pd_template_display($post) {
 
        // Add an nonce field so we can check for it later.
        wp_nonce_field('clipart_nonce_check', 'clipart_nonce_check_value');

        $post_id = $post->ID;


        $settings_tabs_field = new settings_tabs_field();

        $clipart_settings_tab = array();

        $clipart_settings_tab[] = array(
            'id' => 'canvas',
            'title' => sprintf(__('%s Canvas','product-designer'), '<i class="fas fa-palette"></i>'),
            'priority' => 5,
            'active' => true,
        );

        $clipart_settings_tab[] = array(
            'id' => 'product_sides',
            'title' => sprintf(__('%s Product sides','product-designer'), '<i class="fas fa-cube"></i>'),
            'priority' => 10,
            'active' => false,
        );



        $clipart_settings_tab = apply_filters('product_designer_template_metabox_navs', $clipart_settings_tab);

        $tabs_sorted = array();
        foreach ($clipart_settings_tab as $page_key => $tab) $tabs_sorted[$page_key] = isset( $tab['priority'] ) ? $tab['priority'] : 0;
        array_multisort($tabs_sorted, SORT_ASC, $clipart_settings_tab);



        wp_enqueue_script('jquery');
        wp_enqueue_script('jquery-ui-sortable');
        wp_enqueue_script( 'jquery-ui-core' );
        wp_enqueue_script('jquery-ui-accordion');
        wp_enqueue_script('wp-color-picker');
        wp_enqueue_style('wp-color-picker');


        wp_enqueue_style( 'jquery-ui');
        wp_enqueue_style( 'font-awesome-5' );
        wp_enqueue_style( 'settings-tabs' );
        wp_enqueue_script( 'settings-tabs' );


		?>


        <div class="settings-tabs vertical">
            <ul class="tab-navs">
                <?php
                foreach ($clipart_settings_tab as $tab){
                    $id = $tab['id'];
                    $title = $tab['title'];
                    $active = $tab['active'];
                    $data_visible = isset($tab['data_visible']) ? $tab['data_visible'] : '';
                    $hidden = isset($tab['hidden']) ? $tab['hidden'] : false;
                    ?>
                    <li <?php if(!empty($data_visible)):  ?> data_visible="<?php echo $data_visible; ?>" <?php endif; ?> class="tab-nav <?php if($hidden) echo 'hidden';?> <?php if($active) echo 'active';?>" data-id="<?php echo $id; ?>"><?php echo $title; ?></li>
                    <?php
                }
                ?>
            </ul>
            <?php
            foreach ($clipart_settings_tab as $tab){
                $id = $tab['id'];
                $title = $tab['title'];
                $active = $tab['active'];
                ?>

                <div class="tab-content <?php if($active) echo 'active';?>" id="<?php echo $id; ?>">
                    <?php
                    do_action('product_designer_template_metabox_content_'.$id, $post_id);
                    ?>
                </div>
                <?php
            }
            ?>
        </div>
        <div class="clear clearfix"></div>

        <?php

   		}




	public function pd_template_save($post_id){

        /*
         * We need to verify this came from the our screen and with
         * proper authorization,
         * because save_post can be triggered at other times.
         */

        // Check if our nonce is set.
        if (!isset($_POST['clipart_nonce_check_value']))
            return $post_id;

        $nonce = sanitize_text_field($_POST['clipart_nonce_check_value']);

        // Verify that the nonce is valid.
        if (!wp_verify_nonce($nonce, 'clipart_nonce_check'))
            return $post_id;

        // If this is an autosave, our form has not been submitted,
        //     so we don't want to do anything.
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
            return $post_id;

        // Check the user's permissions.
        if ('page' == $_POST['post_type']) {

            if (!current_user_can('edit_page', $post_id))
                return $post_id;

        } else {

            if (!current_user_can('edit_post', $post_id))
                return $post_id;
        }

        /* OK, its safe for us to save the data now. */

        // Sanitize the user input.
        //$grid_item_layout = product_designer_recursive_sanitize_arr($_POST['grid_item_layout']);


        // Update the meta field.
        //update_post_meta($post_id, 'grid_item_layout', $grid_item_layout);

        do_action('product_designer_template_metabox_save', $post_id);



					
		}






    function clipart_display( $post ) {

        global $post;
        wp_nonce_field( 'meta_boxes_clipart_input', 'meta_boxes_clipart_input_nonce' );

        $post_id = $post->ID;
        $clipart_meta_options = get_post_meta($post_id, 'clipart_meta_options', true);


        $current_tab = isset($clipart_meta_options['current_tab']) ? $clipart_meta_options['current_tab'] : 'general';


        $settings_tabs = array();




        $settings_tabs[] = array(
            'id' => 'general',
            'title' => sprintf(__('%s General','product-designer'), '<i class="fas fa-cogs"></i>'),
            'priority' => 5,
            'active' => ($current_tab == 'general') ? true : false,
        );


        $settings_tabs = apply_filters('clipart_metabox_tabs', $settings_tabs);

        //var_dump($settings_tabs);


        $tabs_sorted = array();
        foreach ($settings_tabs as $page_key => $tab) $tabs_sorted[$page_key] = isset( $tab['priority'] ) ? $tab['priority'] : 0;
        array_multisort($tabs_sorted, SORT_ASC, $settings_tabs);



        wp_enqueue_script('jquery');
        wp_enqueue_script('jquery-ui-sortable');
        wp_enqueue_script( 'jquery-ui-core' );
        wp_enqueue_script('jquery-ui-accordion');
        wp_enqueue_script('wp-color-picker');
        wp_enqueue_style('wp-color-picker');


        wp_enqueue_style( 'jquery-ui');
        wp_enqueue_style( 'font-awesome-5' );
        wp_enqueue_style( 'settings-tabs' );
        wp_enqueue_script( 'settings-tabs' );









        ?>

        <div class="post-grid-meta-box">


            <div class="settings-tabs vertical">
                <input class="current_tab" type="hidden" name="clipart_meta_options[current_tab]" value="<?php echo $current_tab; ?>">

                <ul class="tab-navs">
                    <?php
                    foreach ($settings_tabs as $tab){
                        $id = $tab['id'];
                        $title = $tab['title'];
                        $active = $tab['active'];
                        $data_visible = isset($tab['data_visible']) ? $tab['data_visible'] : '';
                        $hidden = isset($tab['hidden']) ? $tab['hidden'] : false;
                        ?>
                        <li <?php if(!empty($data_visible)):  ?> data_visible="<?php echo $data_visible; ?>" <?php endif; ?> class="tab-nav <?php if($hidden) echo 'hidden';?> <?php if($active) echo 'active';?>" data-id="<?php echo $id; ?>"><?php echo $title; ?></li>
                        <?php
                    }
                    ?>
                </ul>
                <?php
                foreach ($settings_tabs as $tab){
                    $id = $tab['id'];
                    $title = $tab['title'];
                    $active = $tab['active'];


                    ?>

                    <div class="tab-content <?php if($active) echo 'active';?>" id="<?php echo $id; ?>">
                        <?php
                        do_action('clipart_metabox_tabs_content_'.$id, $tab, $post_id);
                        ?>
                    </div>
                    <?php
                }
                ?>
            </div>
            <div class="clear clearfix"></div>

        </div>










        <?php



    }


    function clipart_save( $post_id ) {

        /*
         * We need to verify this came from the our screen and with proper authorization,
         * because save_post can be triggered at other times.
         */

        // Check if our nonce is set.
        if ( ! isset( $_POST['meta_boxes_clipart_input_nonce'] ) )
            return $post_id;

        $nonce = sanitize_text_field($_POST['meta_boxes_clipart_input_nonce']);

        // Verify that the nonce is valid.
        if ( ! wp_verify_nonce( $nonce, 'meta_boxes_clipart_input' ) )
            return $post_id;

        // If this is an autosave, our form has not been submitted, so we don't want to do anything.
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
            return $post_id;



        /* OK, its safe for us to save the data now. */

        // Sanitize user input.
        //$clipart_collapsible = sanitize_text_field( $_POST['clipart_collapsible'] );



        do_action('product_designer_clipart_metabox_save', $post_id);



    }


    function shape_display( $post ) {

        global $post;
        wp_nonce_field( 'meta_boxes_shape_input', 'meta_boxes_shape_input_nonce' );

        $post_id = $post->ID;
        $shape_meta_options = get_post_meta($post_id, 'shape_meta_options', true);


        $current_tab = isset($shape_meta_options['current_tab']) ? $shape_meta_options['current_tab'] : 'general';


        $settings_tabs = array();




        $settings_tabs[] = array(
            'id' => 'general',
            'title' => sprintf(__('%s General','product-designer'), '<i class="fas fa-cogs"></i>'),
            'priority' => 5,
            'active' => ($current_tab == 'general') ? true : false,
        );


        $settings_tabs = apply_filters('shape_metabox_tabs', $settings_tabs);

        //var_dump($settings_tabs);


        $tabs_sorted = array();
        foreach ($settings_tabs as $page_key => $tab) $tabs_sorted[$page_key] = isset( $tab['priority'] ) ? $tab['priority'] : 0;
        array_multisort($tabs_sorted, SORT_ASC, $settings_tabs);



        wp_enqueue_script('jquery');
        wp_enqueue_script('jquery-ui-sortable');
        wp_enqueue_script( 'jquery-ui-core' );
        wp_enqueue_script('jquery-ui-accordion');
        wp_enqueue_script('wp-color-picker');
        wp_enqueue_style('wp-color-picker');


        wp_enqueue_style( 'jquery-ui');
        wp_enqueue_style( 'font-awesome-5' );
        wp_enqueue_style( 'settings-tabs' );
        wp_enqueue_script( 'settings-tabs' );









        ?>

        <div class="post-grid-meta-box">


            <div class="settings-tabs vertical">
                <input class="current_tab" type="hidden" name="shape_meta_options[current_tab]" value="<?php echo $current_tab; ?>">

                <ul class="tab-navs">
                    <?php
                    foreach ($settings_tabs as $tab){
                        $id = $tab['id'];
                        $title = $tab['title'];
                        $active = $tab['active'];
                        $data_visible = isset($tab['data_visible']) ? $tab['data_visible'] : '';
                        $hidden = isset($tab['hidden']) ? $tab['hidden'] : false;
                        ?>
                        <li <?php if(!empty($data_visible)):  ?> data_visible="<?php echo $data_visible; ?>" <?php endif; ?> class="tab-nav <?php if($hidden) echo 'hidden';?> <?php if($active) echo 'active';?>" data-id="<?php echo $id; ?>"><?php echo $title; ?></li>
                        <?php
                    }
                    ?>
                </ul>
                <?php
                foreach ($settings_tabs as $tab){
                    $id = $tab['id'];
                    $title = $tab['title'];
                    $active = $tab['active'];


                    ?>

                    <div class="tab-content <?php if($active) echo 'active';?>" id="<?php echo $id; ?>">
                        <?php
                        do_action('shape_metabox_tabs_content_'.$id, $tab, $post_id);
                        ?>
                    </div>
                    <?php
                }
                ?>
            </div>
            <div class="clear clearfix"></div>

        </div>










        <?php



    }


    function shape_save( $post_id ) {

        /*
         * We need to verify this came from the our screen and with proper authorization,
         * because save_post can be triggered at other times.
         */

        // Check if our nonce is set.
        if ( ! isset( $_POST['meta_boxes_shape_input_nonce'] ) )
            return $post_id;

        $nonce = sanitize_text_field($_POST['meta_boxes_shape_input_nonce']);

        // Verify that the nonce is valid.
        if ( ! wp_verify_nonce( $nonce, 'meta_boxes_shape_input' ) )
            return $post_id;

        // If this is an autosave, our form has not been submitted, so we don't want to do anything.
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
            return $post_id;



        /* OK, its safe for us to save the data now. */

        // Sanitize user input.
        //$shape_collapsible = sanitize_text_field( $_POST['shape_collapsible'] );



        do_action('product_designer_shape_metabox_save', $post_id);



    }



}


new product_designer_meta_boxes();