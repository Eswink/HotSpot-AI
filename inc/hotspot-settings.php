<?php
/**
 * Register and define settings.
 */

// Register and define the settings
function hotspot_register_settings()
{
    register_setting('hotspot_settings_group', 'hot_cookie');
    register_setting('hotspot_settings_group', 'AI_select_option');
    register_setting('hotspot_settings_group', 'APPID');
    register_setting('hotspot_settings_group', 'APPSECRET');
}
add_action('admin_init', 'hotspot_register_settings');
