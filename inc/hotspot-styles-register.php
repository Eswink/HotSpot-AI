<?php

// 注册并加载样式表 美化设置页面
add_action('admin_enqueue_scripts', 'hotspot_admin_enqueue_styles');
function hotspot_admin_enqueue_styles()
{
    $general_styles = array(
        'hotspot-settings-iconfont-styles'     => 'assets/css/vendors/icofont.css',
        'hotspot-settings-themify-styles'      => 'assets/css/vendors/themify.css',
        'hotspot-settings-flag-icon-styles'    => 'assets/css/vendors/flag-icon.css',
        'hotspot-settings-feather-icon-styles' => 'assets/css/vendors/feather-icon.css',
        'hotspot-settings-flag-icon-styles'    => 'assets/css/vendors/flag-icon.css',
        'hotspot-settings-slick-styles'        => 'assets/css/vendors/slick.css',
        'hotspot-settings-slick-theme-styles'  => 'assets/css/vendors/slick-theme.css',
        'hotspot-settings-scrollbar-styles'    => 'assets/css/vendors/scrollbar.css',
        'hotspot-settings-bootstrap-styles'    => 'assets/css/vendors/bootstrap.css',
        'hotspot-settings-style-styles'        => 'assets/css/style.css',
        'hotspot-settings-responsive-styles'   => 'assets/css/responsive.css',
    );

    if (isset($_GET['page']) && $_GET['page'] == 'hotspot-choices') {
        wp_register_style('my-style', HOTSPOT_AI_URL_PATH . 'assets/css/admin-hotspot-styles.css', array(), '1.0', 'all');
        wp_enqueue_style('my-style');
    }

    if (isset($_GET['page']) && $_GET['page'] == 'hotspot-settings') {
        foreach ($general_styles as $name => $src) {
            wp_register_style($name, HOTSPOT_AI_URL_PATH . $src, array(), '1.0', 'all');
            wp_enqueue_style($name);
        }
        // 添加额外的css
        wp_register_style('hotspot-settings-animate', HOTSPOT_AI_URL_PATH . 'assets/css/vendors/animate.css');
        wp_enqueue_style('hotspot-settings-animate');
    }

    if (isset($_GET['page']) && $_GET['page'] == 'hotspot-statistics') {
        foreach ($general_styles as $name => $src) {
            wp_register_style($name, HOTSPOT_AI_URL_PATH . $src, array(), '1.0', 'all');
            wp_enqueue_style($name);
        }
        // 注册额外css
        wp_register_style('hotspot-settings-animate', HOTSPOT_AI_URL_PATH . 'assets/css/vendors/animate.css', $src, array(), '1.0', 'all');
        wp_register_style('hotspot-settings-date-picker', HOTSPOT_AI_URL_PATH . 'assets/css/vendors/date-picker.css', $src, array(), '1.0', 'all');
        wp_enqueue_style('hotspot-settings-animate');
        wp_enqueue_style('hotspot-settings-date-picker');

    }

    if (isset($_GET['page']) && $_GET['page'] == 'hotspot-choices') {
        foreach ($general_styles as $name => $src) {
            wp_register_style($name, HOTSPOT_AI_URL_PATH . $src, array(), '1.0', 'all');
            wp_enqueue_style($name);
        }
        // 注册额外css
        wp_register_style('hotspot-settings-animate', HOTSPOT_AI_URL_PATH . 'assets/css/vendors/animate.css', $src, array(), '1.0', 'all');
        wp_enqueue_style('hotspot-settings-animate');
    }

    if (isset($_GET['page']) && $_GET['page'] == 'hotspot-about') {
        foreach ($general_styles as $name => $src) {
            wp_register_style($name, HOTSPOT_AI_URL_PATH . $src, array(), '1.0', 'all');
            wp_enqueue_style($name);
        }
    }

    if (isset($_GET['page']) && $_GET['page'] == 'hotspot-signin' || isset($_GET['page']) && $_GET['page'] == 'hotspot-signup') {
        foreach ($general_styles as $name => $src) {
            wp_register_style($name, HOTSPOT_AI_URL_PATH . $src, array(), '1.0', 'all');
            wp_enqueue_style($name);
        }
    }

}

//美化编辑器，区分古腾堡和经典编辑器

function hotspot_enqueue_styles()
{
    global $pagenow;

    $editor = get_option('classic_editor_support_switch');

    if ($editor == 'on') {

    } else {
        if ($pagenow == 'post.php' || $pagenow == 'post-new.php') {
            wp_enqueue_style('my-plugin-styles', HOTSPOT_AI_URL_PATH . '/assets/css/gutenberg-editor.css');
        }
    }

}

add_action('admin_enqueue_scripts', 'hotspot_enqueue_styles');
