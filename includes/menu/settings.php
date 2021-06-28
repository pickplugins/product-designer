<?php	
if ( ! defined('ABSPATH')) exit;  // if direct access


$current_tab = isset($_REQUEST['tab']) ? sanitize_text_field($_REQUEST['tab']) : 'general';

$tabs = array();

$tabs[] = array(
    'id' => 'general',
    'title' => sprintf(__('%s General','product-designer'),'<i class="fas fa-list-ul"></i>'),
    'priority' => 1,
    'active' => ($current_tab == 'general') ? true : false,
);

$tabs[] = array(
    'id' => 'editor',
    'title' => sprintf(__('%s Editor','product-designer'),'<i class="fas fa-gamepad"></i>'),
    'priority' => 5,
    'active' => ($current_tab == 'editor') ? true : false,
);

$tabs[] = array(
    'id' => 'tour_guide',
    'title' => sprintf(__('%s Tour Guide','product-designer'),'<i class="far fa-life-ring"></i>'),
    'priority' => 10,
    'active' => ($current_tab == 'tour_guide') ? true : false,
);



$tabs[] = array(
    'id' => 'help_support',
    'title' => sprintf(__('%s Help & support','product-designer'),'<i class="fas fa-hands-helping"></i>'),
    'priority' => 90,
    'active' => ($current_tab == 'help_support') ? true : false,
);



$tabs[] = array(
    'id' => 'buy_pro',
    'title' => sprintf(__('%s Buy Pro','product-designer'),'<i class="fas fa-store"></i>'),
    'priority' => 95,
    'active' => ($current_tab == 'buy_pro') ? true : false,
);







$tabs = apply_filters('product_designer_settings_tabs', $tabs);

$tabs_sorted = array();

if(!empty($tabs))
foreach ($tabs as $page_key => $tab) $tabs_sorted[$page_key] = isset( $tab['priority'] ) ? $tab['priority'] : 0;
array_multisort($tabs_sorted, SORT_ASC, $tabs);



$product_designer_settings = get_option('product_designer_settings');

?>
<div class="wrap">
	<div id="icon-tools" class="icon32"><br></div><h2><?php echo sprintf(__('%s Settings', 'product-designer'), product_designer_plugin_name)?></h2>
		<form  method="post" action="<?php echo str_replace( '%7E', '~', esc_url_raw($_SERVER['REQUEST_URI'])); ?>">
	        <input type="hidden" name="product_designer_hidden" value="Y">
            <input type="hidden" name="tab" value="<?php echo $current_tab; ?>">
            <?php
            if(!empty($_POST['product_designer_hidden'])){
                $nonce = sanitize_text_field($_POST['_wpnonce']);
                if(wp_verify_nonce( $nonce, 'product_designer_nonce' ) && $_POST['product_designer_hidden'] == 'Y') {
                    do_action('product_designer_settings_save');
                    ?>
                    <div class="updated notice  is-dismissible"><p><strong><?php _e('Changes Saved.', 'product-designer' ); ?></strong></p></div>
                    <?php
                }
            }
            ?>
            <div class="settings-tabs-loading" style="">Loading...</div>
            <div class="settings-tabs vertical has-right-panel" style="display: none">
                <div class="settings-tabs-right-panel">
                    <?php
                    if(!empty($tabs))
                    foreach ($tabs as $tab) {
                        $id = $tab['id'];
                        $active = $tab['active'];
                        ?>
                        <div class="right-panel-content <?php if($active) echo 'active';?> right-panel-content-<?php echo $id; ?>">
                            <?php
                            do_action('product_designer_settings_tabs_right_panel_'.$id);
                            ?>
                        </div>
                        <?php
                    }
                    ?>
                </div>
                <ul class="tab-navs">
                    <?php
                    if(!empty($tabs))
                    foreach ($tabs as $tab){
                        $id = $tab['id'];
                        $title = $tab['title'];
                        $active = $tab['active'];
                        $data_visible = isset($tab['data_visible']) ? $tab['data_visible'] : '';
                        $hidden = isset($tab['hidden']) ? $tab['hidden'] : false;
                        $is_pro = isset($tab['is_pro']) ? $tab['is_pro'] : false;
                        $pro_text = isset($tab['pro_text']) ? $tab['pro_text'] : '';
                        ?>
                        <li <?php if(!empty($data_visible)):  ?> data_visible="<?php echo $data_visible; ?>" <?php endif; ?> class="tab-nav <?php if($hidden) echo 'hidden';?> <?php if($active) echo 'active';?>" data-id="<?php echo $id; ?>">
                            <?php echo $title; ?>
                            <?php
                            if($is_pro):
                                ?><span class="pro-feature"><?php echo $pro_text; ?></span> <?php
                            endif;
                            ?>
                        </li>
                        <?php
                    }
                    ?>
                </ul>
                <?php
                if(!empty($tabs))
                foreach ($tabs as $tab){
                    $id = $tab['id'];
                    $title = $tab['title'];
                    $active = $tab['active'];
                    ?>
                    <div class="tab-content <?php if($active) echo 'active';?>" id="<?php echo $id; ?>">
                        <?php
                        do_action('product_designer_settings_content_'.$id, $tab);
                        ?>
                    </div>
                    <?php
                }
                ?>
                <div class="clear clearfix"></div>
                <p class="submit">
                    <?php wp_nonce_field( 'product_designer_nonce' ); ?>
                    <input class="button button-primary" type="submit" name="Submit" value="<?php _e('Save Changes','product-designer' ); ?>" />
                </p>
            </div>
		</form>
</div>