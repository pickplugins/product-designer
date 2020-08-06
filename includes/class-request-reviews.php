<?php
if ( ! defined('ABSPATH')) exit; // if direct access 

class pickplugins_request_reviews{

    public $option_name = '';
    public $review_url = '';

    public function __construct($args){

        $this->option_name = isset($args) ? $args['option_name'] : '';
        $this->review_url = isset($args) ? $args['review_url'] : '';

        add_action('admin_notices', array( $this, 'request_reviews' ));
        add_action('admin_notices', array( $this, 'request_reviews_action' ));

    }

    public function request_reviews(){

        if(!current_user_can('manage_options')) return;

        $option = get_option($this->option_name);
        $request_reviews = isset($option['request_reviews']) ? $option['request_reviews'] : '';
        $admin_url = get_admin_url();
        $mark_as_done = wp_nonce_url($admin_url.'?review_status=done', $this->option_name.'_request_reviews', '_wpnonce');
        $remind_later = wp_nonce_url($admin_url.'?review_status=remind_later', $this->option_name.'_request_reviews', '_wpnonce');
        $remind_date = isset($option['remind_date']) ? $option['remind_date'] : '';
        $review_status = isset($option['review_status']) ? $option['review_status'] : '';

        $gmt_offset = get_option('gmt_offset');
        $today_date = date('Y-m-d H:i:s', strtotime('+'.$gmt_offset.' hour'));

        //echo '<pre>'.var_export($option, true).'</pre>';

        if(!empty($review_status)){
            if($review_status == 'done'){ return;}
            if($review_status == 'remind_later' && (strtotime($today_date) < strtotime($remind_date)) ){ return;}

        }else{
            $option['review_status'] = 'remind_later';
            $option['remind_date'] = date('Y-m-d H:i:s', strtotime('+30 days'));
            update_option($this->option_name, $option);

            return;
        }




        ob_start();

        if($request_reviews != 'done'):
            ?>
            <div class="update-nag">
                <?php
                echo sprintf(__('&#128525; We hope you are enjoying <strong>Product Designer</strong> plugin, please help us by providing your feedback <a target="_blank" href="%s">click here</a> to submit us five star review. <a href="%s">Remind me later</a> | <a href="%s">Mark as done</a> ', 'post-grid-pro'), $this->review_url, $remind_later, $mark_as_done)
                ?>
            </div>
        <?php
        endif;


        echo ob_get_clean();
    }




    function request_reviews_action(){

        if(!current_user_can('manage_options')) return;

        $nonce = isset($_GET['_wpnonce']) ? sanitize_text_field($_GET['_wpnonce']) : '';

        if(wp_verify_nonce( $nonce, $this->option_name.'_request_reviews' ) ) {
            $review_status = isset($_GET['review_status']) ? sanitize_text_field($_GET['review_status']) : '';
            $option = get_option($this->option_name);

            if($review_status =='remind_later'):

                $option['review_status'] = 'remind_later';
                $option['remind_date'] = date('Y-m-d H:i:s', strtotime('+30 days'));

                ?>
                <div class="update-nag is-dismissible"><?php echo __('We will remind you later.','product-designer'); ?></div>
                <?php
                update_option($this->option_name, $option);

            elseif ($review_status =='done'):

                $option['review_status'] = 'done';
                ?>
                <div class="update-nag notice is-dismissible"><?php echo __('Thanks for your time and feedback.','product-designer'); ?></div>
                <?php

                update_option($this->option_name, $option);

            endif;


        }



    }






}

//new pickplugins_request_reviews();