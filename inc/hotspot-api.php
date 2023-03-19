<?php

require_once plugin_dir_path(__FILE__) . 'apis/baidu-spot.php'; //引用 百度热点
require_once plugin_dir_path(__FILE__) . 'apis/proxy-hotspot.php'; //引用 HotSpot AI Proxy
require_once plugin_dir_path(__FILE__) . 'apis/proxy-domestic.php'; //引用 HotSpot AI Proxy

class Hotspot_Api
{
    private static $__instance;
    private $__version = 'v1';

    private function __construct()
    {
        // 禁止从外部实例化该类
    }

    public static function get_instance()
    {
        if (!isset(self::$__instance)) {
            self::$__instance = new self();
            self::$__instance->register_routes();
        }
        return self::$__instance;
    }

    public function register_routes()
    {
        add_action('rest_api_init', array($this, 'register_create_post_route'));
        add_action('rest_api_init', array($this, 'register_baidu_hot_pot_route'));
        add_action('rest_api_init', array($this, 'register_load_more_posts_route'));
        add_action('rest_api_init', array($this, 'register_proxy_hotspot_route'));
        add_action('rest_api_init', array($this, 'register_proxy_domestic_route'));
    }

    public function register_proxy_domestic_route()
    {
        register_rest_route("hotspot/{$this->__version}", '/proxy/domestic', array(
            'methods'             => 'POST',
            'callback'            => array($this, 'proxy_domestic'),
            'permission_callback' => function () {
                return true;
            },
        ));
    }

    public function proxy_domestic($request)
    {

        $params = $request->get_params();

        $prompt = isset($params['prompt']) ? $params['prompt'] : '';

        $Domestic_AI_Proxy = new Domestic_AI_Proxy();
        ob_clean(); // 清除之前的所有输出缓冲区内容
        header('Content-Type: application/octet-stream'); // 指定响应类型为二进制流
        $Domestic_AI_Proxy->handleRequest($prompt);
        exit();

    }

    public function register_proxy_hotspot_route()
    {
        register_rest_route("hotspot/{$this->__version}", '/proxy/hotspot', array(
            'methods'             => 'POST',
            'callback'            => array($this, 'proxy_hotspot'),
            'permission_callback' => function () {
                return current_user_can('edit_posts');
            },
        ));
    }

    //创建 HotSpot 代理 回调函数

    public function proxy_hotspot($request)
    {

        $params = $request->get_params();

        $prompt = isset($params['prompt']) ? $params['prompt'] : '';

        $key = get_option('APPSECRET', '');

        $hotspot_proxy = new HotSpot_AI_Proxy();

        $hotspot_proxy->generate_text($prompt, $key);

        exit;

    }

    // 注册用于创建新文章的REST路由
    public function register_create_post_route()
    {
        register_rest_route("hotspot/{$this->__version}", '/create_post', array(
            'methods'             => 'POST',
            'callback'            => array($this, 'create_post'),
            'permission_callback' => function () {
                return current_user_can('edit_posts');
            },
        ));
    }

    // 用于创建新文章的REST回调函数
    public function create_post($request)
    {
        $params  = $request->get_params();
        $post_id = wp_insert_post(array(
            'post_type'   => 'post',
            'post_title'  => $params['title'],
            'post_status' => 'draft',
            'meta_input'  => array(
                'created_by_hotspot' => true,
            ),
        ));

        // 新创建文章的编辑链接
        $edit_link = admin_url("post.php?post={$post_id}&action=edit");

        // 返回JSON格式的响应数据
        $response = array(
            'success'  => true,
            'editLink' => $edit_link,
        );
        return rest_ensure_response($response);
    }

    // 注册用于获取百度热点的REST路由
    public function register_baidu_hot_pot_route()
    {
        register_rest_route("hotspot/{$this->__version}", '/baidu_hot_pot', array(
            'methods'             => 'POST',
            'callback'            => array($this, 'get_baidu_hot_pot'),
            'permission_callback' => function () {
                return current_user_can('edit_posts');
            },
        ));
    }

    // 用于获取百度热点的REST回调函数
    public function get_baidu_hot_pot($request)
    {

        $params = $request->get_params();

        $page_no     = isset($params['page_no']) ? $params['page_no'] : 1;
        $page_size   = isset($params['page_size']) ? $params['page_size'] : 10;
        $se_pv       = isset($params['se_pv']) ? $params['se_pv'] : 1;
        $se_headline = isset($params['se_headline']) ? $params['se_headline'] : '';
        $cookie      = get_option('hot_cookie');

        $api   = new My_Api();
        $datas = $api->get_baidu_hotspot($page_no, $page_size, $se_pv, $se_headline, $cookie);

        return rest_ensure_response($datas);
    }

    // 注册用于处理更多文章请求的REST路由
    public function register_load_more_posts_route()
    {
        register_rest_route("hotspot/{$this->__version}", '/load_more_posts', array(
            'methods'             => 'POST',
            'callback'            => array($this, 'load_more_posts'),
            'permission_callback' => function () {
                return current_user_can('edit_posts');
            },
        ));
    }

    // 用于处理更多文章请求的REST回调函数
    public function load_more_posts($request)
    {

        $params         = $request->get_params();
        $page           = isset($params['page']) ? $params['page'] : 1;
        $posts_per_page = 10;

        $args = array(
            'meta_query'     => array(
                array(
                    'key'   => 'created_by_hotspot',
                    'value' => true,
                ),
            ),
            'post_type'      => 'post',
            'post_status'    => 'any',
            'posts_per_page' => $posts_per_page,
            'paged'          => $page,
        );

        $hotspot_query = new WP_Query($args);

        if ($hotspot_query->have_posts()) {
            $response = array();
            while ($hotspot_query->have_posts()) {
                $hotspot_query->the_post();
                $current_post = array(
                    'title'      => get_the_title(),
                    'link'       => get_permalink(),
                    'date'       => get_the_date(),
                    'author'     => get_the_author(),
                    'categories' => get_the_category_list(', '),
                );
                array_push($response, $current_post);
            }
            wp_reset_postdata();

            // 返回JSON格式的响应数据
            return rest_ensure_response($response);
        } else {
            // 如果没有更多文章，返回 false
            $arg = array(
                "msg"  => "无更多文章",
                "data" => "none",
            );
            return rest_ensure_response($arg);
        }
    }

    public function get_create_post_url()
    {
        return rest_url('hotspot/v1/create_post');
    }

}

function hotspot_api()
{
    return Hotspot_Api::get_instance();
}

add_action('plugins_loaded', 'hotspot_api');

// 在插件启用时调用 get_instance 方法创建实例
function activate_hotspot_api()
{
    Hotspot_Api::get_instance();
}
register_activation_hook(__FILE__, 'activate_hotspot_api');
