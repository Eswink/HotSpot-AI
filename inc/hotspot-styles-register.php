<?php

// 2024年11月21日 引入为vue版本
add_action('admin_enqueue_scripts', 'hotspot_admin_enqueue_styles');
function hotspot_admin_enqueue_styles()
{

    if (isset($_GET['page']) && $_GET['page'] == 'hotspot'){
        wp_enqueue_style(
            'hotspot-vue-style',
            HOTSPOT_AI_URL_PATH . 'assets/css/index.css',
            [],
            '2.0'
        );
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
            wp_enqueue_style('classic-styles', HOTSPOT_AI_URL_PATH . '/assets/css/gutenberg-editor.css');
        }
    }

}

add_action('admin_enqueue_scripts', 'hotspot_enqueue_styles');
