<?php
// Add menu item to the admin dashboard
function hotspot_add_menu_item()
{
    add_menu_page(
        __('Hotspot 设置', 'hotspot'), // page title
        __('Hotspot', 'hotspot'), // menu title
         'manage_options', // capability
         'hotspot', // menu slug
         '', // callback function
         'dashicons-admin-plugins', // icon
        90// position
    );

    add_submenu_page(
        'hotspot', //parent slug
        __('设置', 'hotspot'), // page title
        __('设置', 'hotspot'), // menu title
         'manage_options', // capability
         'hotspot-settings', // menu slug
         'hotspot_settings_page' // callback function
    );

    // Add sub-menu items under Hotspot

    if (get_option('hotspot-switch') == 'on' || get_option('hospot-switch') == '') {

        add_submenu_page(
            'hotspot', // parent slug
            __('热词筛选', 'hotspot'), // page title
            __('热词筛选', 'hotspot'), // menu title
             'manage_options', // capability
             'hotspot-choices', // menu slug
             'hotspot_choices_page' // callback function
        );
    }

    add_submenu_page(
        'hotspot', // parent slug
        __('统计分析', 'hotspot'), // page title
        __('统计分析', 'hotspot'), // menu title
         'manage_options', // capability
         'hotspot-statistics', // menu slug
         'hotspot_statistics_page' // callback function
    );

    // Add sub-menu items under Hotspot about
    add_submenu_page(
        'hotspot', // parent slug
        __('关于', 'hotspot'), // page title
        __('关于', 'hotspot'), // menu title
         'manage_options', // capability
         'hotspot-about', // menu slug
         'hotspot_about_page' // callback function
    );
}
add_action('admin_menu', 'hotspot_add_menu_item');

function remove_hotspot_submenu()
{
    global $submenu;
    if (isset($submenu['hotspot'])) {
        unset($submenu['hotspot'][0]);
    }
}
add_action('admin_menu', 'remove_hotspot_submenu');
