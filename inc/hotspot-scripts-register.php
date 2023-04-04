<?php
// Enqueue scripts

// 注册并加载JavaScript脚本
// 去除第三方jquery
add_action('admin_enqueue_scripts', 'hotspot_admin_enqueue_scripts');
function hotspot_admin_enqueue_scripts()
{

    if (isset($_GET['page']) && $_GET['page'] == 'hotspot-settings') {
        // 通用js

        $general_js = array(
            'hotspot-settings-feather-js'      => 'assets/js/icons/feather-icon/feather.min.js',
            'hotspot-settings-feather-icon-js' => 'assets/js/icons/feather-icon/feather-icon.js',
            'hotspot-settings-config-js'       => 'assets/js/config.js',
            'hotspot-settings-slick-js'        => 'assets/js/slick/slick.js',
            'hotspot-settings-header-slick-js' => 'assets/js/header-slick.js',
            'hotspot-settings-sweetalert-js'   => 'assets/js/sweet-alert/sweetalert.min.js',
            'hotspot-settings-settings-js'     => 'assets/js/admin-hotspot-settings.js"',
            'hotspot-settings-script-js'       => 'assets/js/script.js',
        );

        foreach ($general_js as $name => $src) {
            wp_register_script($name, HOTSPOT_AI_URL_PATH . $src, array(), '1.0', 'all');
            wp_enqueue_script($name);
        }
        wp_localize_script('hotspot-settings-settings-js', 'check_credit', array(
            "url"      => rest_url('hotspot/v1/check/credit'),
            "wp_nonce" => wp_create_nonce('wp_rest'),
        ));
        wp_localize_script('hotspot-settings-settings-js', 'check_delay', array(
            "url"      => rest_url('hotspot/v1/proxy/check_delay'),
            "wp_nonce" => wp_create_nonce('wp_rest'),
        ));

    }

    // 统计分析页面
    if (isset($_GET['page']) && $_GET['page'] == 'hotspot-statistics') {

        $general_js = array(
            'hotspot-settings-bootstrap-js'         => 'assets/js/bootstrap/bootstrap.bundle.min.js',
            'hotspot-settings-feather-js'           => 'assets/js/icons/feather-icon/feather.min.js',
            'hotspot-settings-feather-icon-js'      => 'assets/js/icons/feather-icon/feather-icon.js',
            'hotspot-settings-config-js'            => 'assets/js/config.js',
            'hotspot-settings-apex-chart-js'        => 'assets/js/chart/apex-chart/apex-chart.js',
            'hotspot-settings-stock-prices-js'      => 'assets/js/chart/apex-chart/stock-prices.js',
            'hotspot-settings-chart-custom-2-js'    => 'assets/js/chart/apex-chart/chart-custom-2.js',
            'hotspot-settings-datepicker-js'        => 'assets/js/datepicker/date-picker/datepicker.js',
            'hotspot-settings-datepicker-zh-js'     => 'assets/js/datepicker/date-picker/datepicker.zh.js',
            'hotspot-settings-datepicker-custom-js' => 'assets/js/datepicker/date-picker/datepicker.custom.js',
            'hotspot-settings-dashboard_3-js'       => 'assets/js/dashboard/dashboard_3.js',
            'hotspot-settings-slick-js'             => 'assets/js/slick/slick.js',
            'hotspot-settings-header-slick-js'      => 'assets/js/header-slick.js',
            'hotspot-settings-script-js'            => 'assets/js/script.js',
        );

        foreach ($general_js as $name => $src) {
            wp_register_script($name, HOTSPOT_AI_URL_PATH . $src, array(), '1.0', 'all');
            wp_enqueue_script($name);
        }

        // 显示一个当前的目录
        wp_localize_script('hotspot-settings-dashboard_3-js', 'hotspot_url', array(
            "plugin_url" => HOTSPOT_AI_URL_PATH,
        ));
    }

    // 热词筛选配置界面

    if (isset($_GET['page']) && $_GET['page'] == 'hotspot-choices') {
        $general_js = array(
            'hotspot-settings-bootstrap-js'    => 'assets/js/bootstrap/bootstrap.bundle.min.js',
            'hotspot-settings-feather-js'      => 'assets/js/icons/feather-icon/feather.min.js',
            'hotspot-settings-feather-icon-js' => 'assets/js/icons/feather-icon/feather-icon.js',
            'hotspot-settings-config-js'       => 'assets/js/config.js',
            'hotspot-settings-slick-js'        => 'assets/js/slick/slick.js',
            'hotspot-settings-header-slick-js' => 'assets/js/header-slick.js',
            'hotspot-settings-sweetalert-js'   => 'assets/js/sweet-alert/sweetalert.min.js',
            'hotspot-settings-script-js'       => 'assets/js/script.js',
            'hotspot-settings-choices-js'      => 'assets/js/admin-hotspot-choices.js',
        );

        foreach ($general_js as $name => $src) {
            wp_register_script($name, HOTSPOT_AI_URL_PATH . $src, array(), '1.0', 'all');
            wp_enqueue_script($name);
        }

        wp_localize_script('hotspot-settings-choices-js', 'access_choices', array(
            "baidu_hotspot" => rest_url('hotspot/v1/baidu_hot_pot'),
            "create_post"   => rest_url('hotspot/v1/create_post'),
            "wp_nonce"      => wp_create_nonce('wp_rest'),
        ));
    }

    if (isset($_GET['page']) && $_GET['page'] == 'hotspot-about') {
        $general_js = array(
            'hotspot-settings-feather-js'      => 'assets/js/icons/feather-icon/feather.min.js',
            'hotspot-settings-feather-icon-js' => 'assets/js/icons/feather-icon/feather-icon.js',
            'hotspot-settings-config-js'       => 'assets/js/config.js',
            'hotspot-settings-slick-js'        => 'assets/js/slick/slick.js',
            'hotspot-settings-header-slick-js' => 'assets/js/header-slick.js',
            'hotspot-settings-script-js'       => 'assets/js/script.js',
        );

        foreach ($general_js as $name => $src) {
            wp_register_script($name, HOTSPOT_AI_URL_PATH . $src, array(), '1.0', 'all');
            wp_enqueue_script($name);
        }

    }

}

// 编辑器注册相关变量的js
function add_hotspot_admin_script()
{
    $post_type = get_post_type();
    if ($post_type === 'post') {
        // 将 request-worker.js 的路径作为变量保存
        $request_worker_url = HOTSPOT_AI_URL_PATH . 'assets/js/request-worker.js';
        // 使用 wp_localize_script 函数将变量传递到前台 JS 脚本中
        wp_localize_script('jquery', 'request_worker_url', $request_worker_url);
        wp_localize_script('jquery', 'hotspot_nonce', wp_create_nonce('wp_rest'));
        wp_localize_script('jquery', 'he_js_url', HOTSPOT_AI_URL_PATH . 'assets/js/he.min.js');
        $AI_select_option = get_option('ai_select');

        $request_proxy_url = '';
        if ($AI_select_option == "Open_AI_Free") {
            $request_proxy_url = rest_url('hotspot/v1/proxy/domestic');
        } elseif ($AI_select_option == 'Open_AI_Domestic') {
            $request_proxy_url = rest_url('hotspot/v1/proxy/hotspot');
        }
        wp_localize_script('jquery', 'request_proxy_url', $request_proxy_url);

        if (get_option('seo-analysis') == 'on') {
            wp_localize_script('jquery', 'seo_analysis_url', rest_url('hotspot/v1/seo/analysis'));
        }

        if (get_option('seo-analysis') == 'on') {
            wp_localize_script('jquery', 'search_images_url', rest_url('hotspot/v1/search/images'));
        }

    }
}
add_action('admin_enqueue_scripts', 'add_hotspot_admin_script');

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
