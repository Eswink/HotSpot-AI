<?php
/**
 * Plugin Name: HotSpot AI 热点创作
 * Description: 基于AI技术的WordPress插件，旨在帮助您分析获取全网热词并帮助构思和写作，提高您网站的整体权重
 * Author: Eswlnk
 * Version: 1.3.8
 * Author URI: https://blog.eswlnk.com/
 */

// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

if (!defined('HOTSPOT_AI_URL_PATH')) {
    define('HOTSPOT_AI_URL_PATH', plugin_dir_url(__FILE__));
}
if (!defined('HOTSPOT_AI_DIR_PATH')) {
    define('HOTSPOT_AI_DIR_PATH', plugin_dir_path(__FILE__));
}

if (!defined('HOTSPOT_AI_SOURCE')) {
    define('HOTSPOT_AI_SOURCE', plugin_basename(__FILE__));
}

// Include the other PHP files for different functionalities
require_once plugin_dir_path(__FILE__) . 'inc/hotspot-admin-menu.php'; //注册菜单

require_once plugin_dir_path(__FILE__) . 'inc/hotspot-settings-register.php'; //注册菜单页面设置 存储设置

require_once plugin_dir_path(__FILE__) . 'inc/hotspot-admin-page.php'; //注册菜单页面

require_once plugin_dir_path(__FILE__) . 'inc/hotspot-styles-register.php'; //注册样式表

require_once plugin_dir_path(__FILE__) . 'inc/hotspot-scripts-register.php'; //注册相关脚本

require_once plugin_dir_path(__FILE__) . 'inc/hotspot-sidebar-register.php'; //注册sidebar

require_once plugin_dir_path(__FILE__) . 'inc/hotspot-init.php'; //初始化
