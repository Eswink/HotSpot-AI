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
