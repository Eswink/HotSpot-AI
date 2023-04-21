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
