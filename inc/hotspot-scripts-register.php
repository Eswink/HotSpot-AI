<?php

// 2024年11月21日 引入为vue版本
add_action('admin_enqueue_scripts', 'hotspot_admin_enqueue_scripts');
function hotspot_admin_enqueue_scripts()
{
    if (isset($_GET['page']) && $_GET['page'] == 'hotspot'){    
        wp_enqueue_script(
            'hotspot-vue-script',
            HOTSPOT_AI_URL_PATH . 'assets/js/index.js',
            [],
            '2.0',
            true // 在页面 footer 中加载
        );
    
        // 注入全局数据
        $rest_api_available = !is_rest_api_disabled() ? 'true' : 'false';
    
        wp_localize_script(
            'hotspot-vue-script', // 关联的脚本句柄
            'hotspot',            // JavaScript 全局变量名称
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
function add_hotspot_admin_script()
{
    $editor = get_option('classic_editor_support_switch');

    global $pagenow;

    // 检查当前页面是否为文章编辑页面
    $is_edit_page = in_array($pagenow, array('post.php', 'post-new.php'));

    if ($is_edit_page) {
        wp_localize_script('jquery', 'classic_switch', array(
            "checked" => $editor,
        ));

        wp_register_script('hotspot_classic_editor_judge', HOTSPOT_AI_URL_PATH . 'assets/js/tinymce/judge.js');
        wp_enqueue_script('hotspot_classic_editor_judge');

        if ($editor == 'on') {
            // 经典编辑器页面

            wp_register_script('hotspot_classic_editor_js', HOTSPOT_AI_URL_PATH . 'assets/js/tinymce/optimize.js');
            wp_register_style('hotspot_classic_editor_css', HOTSPOT_AI_URL_PATH . 'assets/css/tinymce/optimize.css');
            wp_enqueue_script('hotspot_classic_editor_js');
            wp_enqueue_style('hotspot_classic_editor_css');
            // 加载相关的接口

            // 新建一个数组

            $data_inline_script = array();
            $request_worker_url = HOTSPOT_AI_URL_PATH . 'assets/js/request-worker.js';
            $data_inline_script = array(
                'request_worker_url' => $request_worker_url,
                'hotspot_nonce'      => wp_create_nonce('wp_rest'),
                'he_js_url'          => HOTSPOT_AI_URL_PATH . 'assets/js/he.min.js',
            );

            $request_proxy_url = '';
            $AI_select_option  = get_option('ai_select');
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

            //这里需要传递一个 css 的地址过去

            $data_inline_script['editor_css'] = HOTSPOT_AI_URL_PATH . 'assets/css/tinymce/editor.css';
            wp_localize_script('hotspot_classic_editor_js', 'classic_optimize', $data_inline_script);

        } else {
            $request_worker_url = HOTSPOT_AI_URL_PATH . 'assets/js/request-worker.js';
            $data_inline_script = array(
                'request_worker_url' => $request_worker_url,
                'hotspot_nonce'      => wp_create_nonce('wp_rest'),
                'he_js_url'          => HOTSPOT_AI_URL_PATH . 'assets/js/he.min.js',
            );

            $request_proxy_url = '';
            $AI_select_option  = get_option('ai_select');
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

}
add_action('admin_enqueue_scripts', 'add_hotspot_admin_script');

// 古登堡编辑器
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

/*----------------经典编辑器区域-----------------------------*/

// 经典编辑器 按钮
add_action('media_buttons', 'add_hotspot_classic_button', 15);
function add_hotspot_classic_button()
{
    $button_html = '<button class="button" id="ai-idea-btn"><span class="media-button-icon dashicons"></span>AI构思</button>';
    $button_html .= '<button class="button" id="ai-search-btn" type="button"><span class="media-button-icon image-button-icon dashicons"></span>智能搜图</button>';
    echo $button_html;
    wp_enqueue_media();
}

function add_hotspot_AI_SEO_postbox()
{

    $editor = get_option('classic_editor_support_switch');

    if ($editor == 'on') {
        add_meta_box(
            'hotspot-seo-analysis-postbox',
            '文章分析',
            'add_hotspot_AI_SEO_postbox_callback',
            'post',
            'normal',
            'high'
        );
    }

}

function add_hotspot_AI_SEO_postbox_callback()
{
    $editor = get_option('classic_editor_support_switch');

    if ($editor == 'on') {
        wp_nonce_field(basename(__FILE__), 'hotspot_ai_seo_nonce');
        $hotspot_content = get_post_meta(get_the_ID(), '_hotspot_content', true);
        ?>
    <p>
      <div class="mask">
        <textarea id="hotspot_seo_analysis_content" name="hotspot-content" rows="5" style="width: 100%;"><?php echo esc_textarea($hotspot_content); ?></textarea>
      </div>
      <button id="ai_seo_analysis" class="button" type="button">AI分析</button>
    </p>
    <?php
}

}

// 保存文本域的值
function save_hotspot_AI_SEO_postbox($post_id)
{
    if (!isset($_POST['hotspot_ai_seo_nonce']) || !wp_verify_nonce($_POST['hotspot_ai_seo_nonce'], basename(__FILE__))) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (isset($_POST['hotspot-content'])) {
        update_post_meta($post_id, '_hotspot_content', sanitize_text_field($_POST['hotspot-content']));
    }
}

add_action('add_meta_boxes', 'add_hotspot_AI_SEO_postbox');
add_action('save_post', 'save_hotspot_AI_SEO_postbox');
