<?php

// Register and define the settings
function hotspot_register_settings()
{
    register_setting('hotspot_settings_group', 'hotspot-switch');
    register_setting('hotspot_settings_group', 'baijiahao_hotspot_cookies');
    register_setting('hotspot_settings_group', 'ai_select');
    register_setting('hotspot_settings_group', 'openai_key');
    register_setting('hotspot_settings_group', 'custom_proxy');
    register_setting('hotspot_settings_group', 'seo-analysis');
    register_setting('hotspot_settings_group', 'search-images');
    register_setting('hotspot_settings_group', 'auth_signin_token');
}
add_action('admin_init', 'hotspot_register_settings');
