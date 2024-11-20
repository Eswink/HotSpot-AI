<?php
// Add menu item to the admin dashboard

function hotspot_add_menu_item()
{
    add_menu_page(
        __('Hotspot 设置', 'hotspot'), // page title
        __('Hotspot', 'hotspot'), // menu title
         'manage_options', // capability
         'hotspot', // menu slug
         'hotspot_render', // callback function
         'dashicons-admin-plugins', // icon
        90
    );

    add_submenu_page(
        'hotspot', //parent slug
        __('设置', 'hotspot'), // page title
        __('设置', 'hotspot'), // menu title
         'manage_options', // capability
         'hotspot-settings', // menu slug
         'hotspot_settings_page' // callback function
    );

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


// 2024年11月21日 修改子菜单
add_action('admin_menu', function () {
    global $submenu;

    $custom_urls = [
        'hotspot-settings' => 'admin.php?page=hotspot#/',
        'hotspot-choices'  => 'admin.php?page=hotspot#/hotword',
        'hotspot-about'    => 'admin.php?page=hotspot#/about',
    ];

    if (isset($submenu['hotspot'])) {
        foreach ($submenu['hotspot'] as &$submenu_item) {
            $menu_slug = $submenu_item[2];
            if (isset($custom_urls[$menu_slug])) {
                $submenu_item[2] = $custom_urls[$menu_slug];
            }
        }
    }
}, 999);



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
