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
