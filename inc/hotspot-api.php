<?php

require plugin_dir_path(__FILE__) . 'apis/vendor/autoload.php';

require_once plugin_dir_path(__FILE__) . 'apis/baidu-spot.php'; //引用 百度热点
require_once plugin_dir_path(__FILE__) . 'apis/proxy-hotspot.php'; //引用 HotSpot AI Proxy
require_once plugin_dir_path(__FILE__) . 'apis/proxy-domestic.php'; //引用 HotSpot AI Free
require_once plugin_dir_path(__FILE__) . 'apis/check-credit.php'; // 引用 检查信用

use GuzzleHttp\Psr7;
use HotSpot\Baidu\Baidu_V1;
use HotSpot\Check\Check_Credit;
use HotSpot\Free\HotSpot_Domestic_AI_Proxy;
use HotSpot\Porxy\HotSpot_AI_Proxy;

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
        add_action('rest_api_init', array($this, 'register_check_credit_route'));
    }

    // 验证 API 接口
    public function register_check_credit_route()
    {
        register_rest_route("hotspot/{$this->__version}", '/check/credit', array(
            'methods'             => 'POST',
            'callback'            => array($this, 'check_credit'),
            'permission_callback' => function () {
                return current_user_can('edit_posts');
            },
        ));
    }

    public function check_credit($request)
    {
        $params = $request->get_params();
        $key    = $params['key'];

        $check_credit = new Check_Credit($key);
        return rest_ensure_response($check_credit->getCredit());

    }

    // 不需要填写key的接口
    public function register_proxy_domestic_route()
    {
        register_rest_route("hotspot/{$this->__version}", '/proxy/domestic', array(
            'methods'             => 'POST',
            'callback'            => array($this, 'proxy_domestic'),
            'permission_callback' => function () {
                return current_user_can('edit_posts');
            },
        ));
    }

    public function proxy_domestic($request)
    {

        $params = $request->get_params();

        $prompt = isset($params['prompt']) ? $params['prompt'] : '';

        $HotSpot_Domestic_AI_Proxy = new HotSpot_Domestic_AI_Proxy();
        $HotSpot_Domestic_AI_Proxy->handleRequest($prompt);
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

        $request_text = 'Please write a 1,000-character article in Chinese with the title "' . $prompt . '", requiring subtitles for each paragraph and no H1 headings. Paragraphs need to be wrapped with <p> tags, and subheadings are wrapped with <h2>. In addition, the first paragraph must be an introduction, no subheadings, packaging labels and symbols need to be included in the character count, and the article must be complete without truncation';

        $key = get_option('openai_key', '');

        $HotSpot_AI_Proxy = new HotSpot_AI_Proxy(get_option('openai_key', '') ?? null);

        try {
            $answer = $HotSpot_AI_Proxy->ask($request_text, null, true);
        } catch (RequestException $e) {
            $error = $e->getMessage();
            echo esc_html($error);
        }

        header('Content-type: application/octet-stream');
        header('Cache-Control: no-cache');

        ob_end_clean();
        $temp       = '';
        $message_id = '';
        $first      = true;
        while (!$answer->eof()) {
            $raw  = Psr7\Utils::readLine($answer);
            $line = $HotSpot_AI_Proxy->formatStreamMessage($raw);
            if ($HotSpot_AI_Proxy->checkStreamFields($line)) {
                if (!$first) {
                    echo esc_html("\n");
                }
                $first = false;
                $temp .= $line['choices'][0]['delta']['content'];
                $single     = $line['choices'][0]['delta']['content'];
                $message_id = $line['message_id'];

                // 转义字符 避免出现问题
                echo esc_html(json_encode([
                    "role"            => "assistant",
                    "id"              => uniqid(),
                    'conversationId'  => $line['id'],
                    "parentMessageId" => uniqid(),
                    "text"            => $temp,
                    "delta"           => $single,
                ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_LINE_TERMINATORS));
            }
            unset($raw, $line);
            ob_flush();
            flush();
        }

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
                'se_pv'              => $params['se_pv'],
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
        $cookie      = get_option('baijiahao_hotspot_cookies', '');

        $api   = new Baidu_V1();
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
