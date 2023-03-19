<?php
// Enqueue scripts

// 注册并加载JavaScript脚本
add_action('admin_enqueue_scripts', 'hotspot_admin_enqueue_scripts');
function hotspot_admin_enqueue_scripts()
{
    if (isset($_GET['page']) && $_GET['page'] == 'hotspot-choices') {
        wp_register_script('admin-hot-spot-handler', HOTSPOT_AI_URL_PATH . 'assets/js/admin-hot-spot-handler.js', array('jquery'), '1.0', true);
        // 将myAjaxObject对象添加到JavaScript脚本中
        wp_localize_script('admin-hot-spot-handler', 'hotSpotObject', array(
            'ajax_url' => esc_url(rest_url('hotspot/v1/baidu_hot_pot')),
            'nonce'    => wp_create_nonce('wp_rest'),
        ));
        $hotspot_api = Hotspot_Api::get_instance();

        $create_post_url = $hotspot_api->get_create_post_url();

        // 将变量传递到JavaScript文件中
        wp_localize_script('admin-hot-spot-handler', 'hotspot_vars', array(
            'create_post_url' => $create_post_url,
        ));
        wp_enqueue_script('admin-hot-spot-handler');
    } elseif (isset($_GET['page']) && $_GET['page'] == 'hotspot-statistics') {
        wp_register_script('admin-hotspot-statistics', HOTSPOT_AI_URL_PATH . 'assets/js/admin-hotspot-statistics.js', array('jquery'), '1.0', true);
        wp_localize_script('admin-hotspot-statistics', 'hotSpotObject', array(
            'ajax_url' => esc_url(rest_url('hotspot/v1/load_more_posts')),
            'nonce'    => wp_create_nonce('wp_rest'),
        ));
        wp_enqueue_script('admin-hotspot-statistics');
    }

}

// 编辑器注册相关变量的js
function add_hotspot_admin_script()
{
    $post_type = get_post_type();
    if ($post_type === 'post') {
        echo '<script>window.request_worker_url = "' . HOTSPOT_AI_URL_PATH . 'assets/js/request-worker.js' . '";</script>';
        echo '<script>hotspot_nonce="' . wp_create_nonce('wp_rest') . '";</script>';
        $AI_select_option = get_option('AI_select_option');

        $request_proxy_url = '';

        if ($AI_select_option == 'domestic_interface') {
            echo '<script>window.request_proxy_url = "' . rest_url('hotspot/v1/proxy/domestic') . '";</script>';
        } elseif ($AI_select_option == 'exclusive_interface') {
            echo '<script>window.request_proxy_url = "' . rest_url('hotspot/v1/proxy/hotspot') . '";</script>';
        }

    }
}
add_action('admin_head', 'add_hotspot_admin_script');

function sidebar_plugin_register()
{
    wp_register_script(
        'plugin-sidebar-js',
        HOTSPOT_AI_URL_PATH . 'assets/js/plugin-sidebar.js',
        array(
            'wp-plugins',
            'wp-edit-post',
            'wp-element',
            'wp-components',
        )
    );
}
add_action('init', 'sidebar_plugin_register');

function sidebar_plugin_script_enqueue()
{
    wp_enqueue_script('plugin-sidebar-js');
}
add_action('enqueue_block_editor_assets', 'sidebar_plugin_script_enqueue');
