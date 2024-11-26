<?php

// 2024年11月21日 引入为vue版本
add_action('admin_enqueue_scripts', 'hotspot_admin_enqueue_scripts');
function hotspot_admin_enqueue_scripts()
{
    if (isset($_GET['page']) && $_GET['page'] == 'hotspot') {
        // 获取插件的版本号
        $plugin_data = get_plugin_data(HOTSPOT_AI_DIR_PATH . 'hotspot.php'); // 获取插件主文件的版本号
        $plugin_version = $plugin_data['Version']; // 获取插件版本号

        wp_enqueue_script(
            'hotspot-vue-script',
            HOTSPOT_AI_URL_PATH . 'assets/js/index.js',
            [],
            $plugin_version, // 使用插件的动态版本号
            true // 在页面 footer 中加载
        );

        // 注入全局数据
        $rest_api_available = !is_rest_api_disabled() ? 'true' : 'false';

        wp_localize_script(
            'hotspot-vue-script', // 关联的脚本句柄
            'hotspot', // JavaScript 全局变量名称
            [
                "wp_nonce" => wp_create_nonce('wp_rest'), // 创建REST API的nonce
                "hotspot_rest_api" => $rest_api_available,
            ]
        );
    }
}


// 2024年11月21日
// 为生产环境的脚本添加 `type="module"` 属性
add_filter('script_loader_tag', function ($tag, $handle, $src) {
    if ('hotspot-vue-script' === $handle) {
        // 修改标签以支持ES Module
        return sprintf('<script type="module" src="%s"></script>', esc_url($src));
    }
    return $tag;
}, 10, 3);


// 编辑器注册相关变量的js
// 2.0.1 2024年11月26日 修改不必要的加载文件，不再支持经典编辑器

function add_hotspot_admin_script()
{

    global $pagenow;

    // 检查当前页面是否为文章编辑页面
    $is_edit_page = in_array($pagenow, array('post.php', 'post-new.php'));

    if ($is_edit_page) {

        $data_inline_script = array(
            'hotspot_nonce' => wp_create_nonce('wp_rest'),
        );

        $request_proxy_url = '';
        $AI_select_option = get_option('ai_select');
        if ($AI_select_option == "Open_AI_Free") {
            $request_proxy_url = rest_url('hotspot/v1/proxy/domestic');
        } elseif ($AI_select_option == 'Open_AI_Domestic' || $AI_select_option == 'Open_AI_Custom') {
            $request_proxy_url = rest_url('hotspot/v1/proxy/hotspot');
        }
        $data_inline_script['request_proxy_url'] = $request_proxy_url;

        if (get_option('seo-analysis') == 'on') {
            $data_inline_script['seo_analysis_url'] = rest_url('hotspot/v1/seo/analysis');
        }

        if (get_option('search-images') == 'on') {
            $data_inline_script['search_images_url'] = rest_url('hotspot/v1/search/images');
        }

        wp_localize_script('jquery', 'gutenberg_optimize', $data_inline_script);

    }

}
add_action('admin_enqueue_scripts', 'add_hotspot_admin_script');

// 2.0.1 2024年11月26日 修改古腾堡编辑器区块注册逻辑
function sidebar_plugin_register()
{
    register_block_type( HOTSPOT_AI_DIR_PATH . '/blocks/build' );
}
add_action('init', 'sidebar_plugin_register');

