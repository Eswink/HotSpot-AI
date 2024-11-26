<?php

// 2024年11月21日 引入为vue版本
add_action('admin_enqueue_scripts', 'hotspot_admin_enqueue_styles');
function hotspot_admin_enqueue_styles()
{

    if (isset($_GET['page']) && $_GET['page'] == 'hotspot'){
        $plugin_data = get_plugin_data(HOTSPOT_AI_DIR_PATH . 'hotspot.php'); // 获取插件主文件的版本号
        $plugin_version = $plugin_data['Version']; // 获取插件版本号

        wp_enqueue_style(
            'hotspot-vue-style',
            HOTSPOT_AI_URL_PATH . 'assets/css/index.css',
            [],
            $plugin_version
        );
    }

}

