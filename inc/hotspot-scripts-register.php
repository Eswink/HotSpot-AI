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
            'hotspot-settings-settings-js'     => 'assets/js/admin-hotspot-settings.js',
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

    if (isset($_GET['page']) && $_GET['page'] == 'hotspot-signin') {
        $general_js = array(
            'hotspot-signin-validate-js'   => 'assets/js/jquery.validate.min.js',
            'hotspot-signin-sweetalert-js' => 'assets/js/sweet-alert/sweetalert.min.js',
            //'hotspot-signin-captcha-js'    => 'assets/js/api.js',
             'hotspot-signin-api-js'        => 'assets/js/login/login-api.js',
            'hotspot-signin-script-js'     => 'assets/js/script.js',
        );

        foreach ($general_js as $name => $src) {
            wp_register_script($name, HOTSPOT_AI_URL_PATH . $src, array(), '1.0', 'all');
            wp_enqueue_script($name);
        }

        wp_localize_script('hotspot-signin-api-js', 'access_token', array(
            "hotspot_signin" => rest_url('hotspot/v1/hotspot/signin'),
            "wp_nonce"       => wp_create_nonce('wp_rest'),
        ));

    }

    if (isset($_GET['page']) && $_GET['page'] == 'hotspot-signup') {
        $general_js = array(
            'hotspot-signup-validate-js'    => 'assets/js/jquery.validate.min.js',
            'hotspot-signup-sweetalert2-js' => 'assets/js/sweet-alert/sweetalert2.js',
            //'hotspot-signup-captcha-js'     => 'assets/js/api.js',
             'hotspot-signup-api-js'         => 'assets/js/login/signup-api.js',
            'hotspot-signup-script-js'      => 'assets/js/script.js',
        );

        foreach ($general_js as $name => $src) {
            wp_register_script($name, HOTSPOT_AI_URL_PATH . $src, array(), '1.0', 'all');
            wp_enqueue_script($name);
        }

        wp_localize_script('hotspot-signup-api-js', 'access_token', array(
            "hotspot_send"   => rest_url('hotspot/v1/hotspot/send_email'),
            "hotspot_signup" => rest_url('hotspot/v1/hotspot/signup'),
            "wp_nonce"       => wp_create_nonce('wp_rest'),
        ));

    }

}

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
