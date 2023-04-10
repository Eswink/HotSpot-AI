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

    if (get_option('hotspot-switch') == 'on') {

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
    add_submenu_page(
        'hotspot', // 父级菜单的页面slug
        __('教程', 'hotspot'), // page title
        __('教程', 'hotspot'), // menu title
         'manage_options', // 用户角色
         'open-dcos', // 子菜单slug
         '__return_false'
    );

    add_submenu_page(
        'noid', // 父级菜单的页面slug
        __('HotSpot AI - Signin', 'hotspot'), // page title
        __('HotSpot AI - Signin', 'hotspot'), // menu title
         'manage_options', // 用户角色
         'hotspot-signin', // 子菜单slug
         'hotspot_signin_page'
    );

    add_submenu_page(
        'noid', // 父级菜单的页面slug
        __('HotSpot AI - Signup', 'hotspot'), // page title
        __('HotSpot AI - Signup', 'hotspot'), // menu title
         'manage_options', // 用户角色
         'hotspot-signup', // 子菜单slug
         'hotspot_signup_page'
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

// 添加目标URL的主机名到allowed_redirect_hosts列表中
function hotspot_allowed_redirect_hosts($content)
{
    $content[] = 'docs.eswlnk.com';
    return $content;
}
add_filter('allowed_redirect_hosts', 'hotspot_allowed_redirect_hosts');

function maybe_redirect()
{
    $page = filter_input(INPUT_GET, 'page');

    if ('open-dcos' === $page) {
        wp_safe_redirect('https://docs.eswlnk.com');
        exit();
    }
}

add_action('admin_init', 'maybe_redirect');
