<?php

// 注册并加载样式表 美化设置页面
add_action('admin_enqueue_scripts', 'my_admin_enqueue_styles');
function my_admin_enqueue_styles()
{
    if (isset($_GET['page']) && $_GET['page'] == 'hotspot-choices') {
        wp_register_style('my-style', HOTSPOT_AI_URL_PATH . 'assets/css/admin-hotspot-styles.css', array(), '1.0', 'all');
        wp_enqueue_style('my-style');
    }
}

//美化古腾堡

function myplugin_enqueue_styles()
{
    global $pagenow;

    if ($pagenow == 'post.php' || $pagenow == 'post-new.php') {
        wp_enqueue_style('my-plugin-styles', HOTSPOT_AI_URL_PATH . '/assets/css/gutenberg-editor.css');
    }
}

add_action('admin_enqueue_scripts', 'myplugin_enqueue_styles');
