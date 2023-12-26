<?php
/**
 * Plugin initialization and constant definitions.
 */

// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

// 自动加载 hotspot-api.php 文件
require_once plugin_dir_path(__FILE__) . 'hotspot-api.php';
// 添加 '设置'

add_filter('plugin_action_links_' . HOTSPOT_AI_SOURCE, 'hotspot_ai_add_settings_link');
function hotspot_ai_add_settings_link($links)
{
    // Add a new settings link to the plugin page
    $settings_link = '<a href="admin.php?page=hotspot-settings">' . __('设置', 'hotspot-ai') . '</a>';
    array_push($links, $settings_link);
    return $links;
}

register_activation_hook(HOTSPOT_AI_SOURCE, 'hotspot_ai_plugin_redirect');

function hotspot_ai_plugin_redirect()
{
    add_option('hotspot_ai_do_activation_redirect', true);
}

add_action('admin_init', 'hotspot_ai_activate_redirect');

function hotspot_ai_activate_redirect()
{
    if (get_option('hotspot_ai_do_activation_redirect', false)) {
        delete_option('hotspot_ai_do_activation_redirect');
        wp_safe_redirect(admin_url('admin.php?page=hotspot-settings'));
        exit;
    }
}

// ajax钩子

add_action('wp_ajax_hotspot_upload_file', 'hotspot_upload_file_callback');
function hotspot_upload_file_callback()
{
    // 检查当前用户是否具有上传文件的权限
    if (!current_user_can('upload_files')) {
        wp_send_json_error(['message' => '您不具有上传文件的权限']);
    }

    // 检查是否上传了文件
    if (empty($_POST['file'])) {
        wp_send_json_error(['message' => '没有上传文件']);
    }

    // 获取上传的文件信息
    $base64data = $_POST['file'];
    if (strpos($base64data, 'data:image/jpeg;base64,') === 0) {
        $base64data = substr($base64data, strlen('data:image/jpeg;base64,'));
    }
    $filedata = base64_decode($base64data);

    // 构造一个随机的文件名
    $filename = date('YmdHis') . rand(1000, 9999) . '.png';

    // 获取 WordPress 媒体文件夹路径
    $upload_dir  = wp_upload_dir();
    $target_path = trailingslashit($upload_dir['path']) . $filename;

    // 将 Base64 解码后的数据保存到文件中
    file_put_contents($target_path, $filedata);

    // 将文件信息插入到 WordPress 媒体库中
    $attachment_id = wp_insert_attachment(
        [
            'guid'           => $target_path,
            'post_mime_type' => 'image/png',
            'post_title'     => $filename,
            'post_content'   => '',
            'post_status'    => 'inherit',
        ],
        $target_path
    );
    wp_update_attachment_metadata(
        $attachment_id,
        wp_generate_attachment_metadata($attachment_id, $target_path)
    );

    if (is_wp_error($attachment_id)) {
        wp_send_json_error(['message' => $attachment_id->get_error_message()]);
    } else {
        $attachment_url = wp_get_attachment_url($attachment_id);
        wp_send_json_success(['url' => $attachment_url]);
    }
}

add_action('admin_notices', 'hotspot_update_notice');
function hotspot_update_notice()
{
    $current_screen = get_current_screen();

    if ($current_screen->base === 'hotspot_page_hotspot-settings') {
        $last_checked_time = get_transient('hotspot_last_checked_time'); // 从 Transients 中读取上一次检测的时间戳
        $now_time          = time(); // 获取当前时间戳

        $check_interval = 3600; // 设置检测间隔为 1 小时

        if (!$last_checked_time || $now_time - $last_checked_time >= $check_interval) {
            // 判断是否需要进行检测
            $plugin_info    = get_plugin_data(HOTSPOT_AI_DIR_PATH . 'hotspot.php');
            $plugin_version = $plugin_info['Version']; // 获取当前插件版本号

            $api_url  = "https://api.wordpress.org/plugins/info/1.0/hotspot-ai"; // WordPress 插件仓库 API 地址
            $response = wp_remote_get($api_url); // 发送 HTTP 请求获取 API 数据
            if (!is_wp_error($response) && $response['response']['code'] == 200) {
                // 判断返回值是否成功
                $api_response = unserialize($response['body']);
                if (version_compare($plugin_version, $api_response->version, '<')) {
                    // 检测插件新旧版本号
                    $update_link     = admin_url('plugin-install.php?s=%25E7%2583%25AD%25E7%2582%25B9%25E5%2588%259B%25E4%25BD%259C&tab=search&type=term'); // 拼接更新链接
                    $updated_version = "{$api_response->version}"; // 注意这里没有 HTML 标签
                    $output          = sprintf(esc_html__('插件有新本啦 (%s)，更多好用的功能尽在新版本中！', 'hotspot'), $updated_version);
                    $output .= ' <a href="' . $update_link . '">' . esc_html__('立即更新', 'hotspot') . '</a>'; // 添加更新链接
                    echo "<div class='update-message notice inline notice-warning notice-alt' style='position:absolute;z-index:100'><p>{$output}</p></div>";
                }
            }

            set_transient('hotspot_last_checked_time', $now_time); // 将当前时间戳存入 Transients 中，作为下一次检测的时间基准
        }
    }
}

// 检测 REST API

function is_rest_api_disabled()
{
    $response = wp_remote_get(rest_url());

    if (is_wp_error($response)) {
        return true; // REST API已被禁用
    }

    $status_code = wp_remote_retrieve_response_code($response);

    if ($status_code !== 200) {
        return true; // REST API已被禁用
    }

    return false; // REST API可用
}
