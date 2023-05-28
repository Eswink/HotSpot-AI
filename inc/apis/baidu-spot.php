<?php
namespace HotSpot\Baidu;

if (!defined('ABSPATH')) {
    exit;
}

class Baidu_V1
{
    private $__post_url = "https://x8ki-letl-twmt.n7.xano.io/api:tHUkNdeR/auth/get_baijiahao";

    public function getPostUrl()
    {
        return $this->__post_url;
    }
    public function get_baidu_hotspot($page_no = 1, $page_size = 10, $se_pv = 1, $se_headline = '', $cookies = '')
    {

        $postData = array(
            "page_no"     => $page_no,
            "page_size"   => $page_size,
            "se_pv"       => $se_pv,
            "se_headline" => $se_headline,
        );

        $headers = array(
            'Authorization' => get_option("auth_signin_token"),
            'Content-Type'  => 'application/x-www-form-urlencoded',
        );

        $args = array(
            'body'    => $postData,
            'headers' => $headers,
            'timeout' => 30, // 超时时间为 30 秒
        );

        $response = wp_remote_post($this->getPostUrl(), $args);

        $response_body = wp_remote_retrieve_body($response); // 获取响应正文

        $datas = json_decode($response_body); // 解析JSON数据

        $response_code = wp_remote_retrieve_response_code($response); // 获取响应状态码

        if ($response_code == 200) {

            if (!isset($datas->data->lists)) {
                wp_send_json(array(
                    "error" => true,
                    "msg"   => "未填写正确的Cookies",
                ));
            }

            if (sizeof($datas->data->lists) == 0) {
                if ($datas->errno) {
                    wp_send_json(array(
                        "error" => true,
                        "msg"   => "未填写正确的Cookies",
                    ));
                }
                wp_send_json(array(
                    "error" => true,
                    "msg"   => "无更多文章",
                ));
            }

            $packed_data = array("data" => array());

            foreach ($datas->data->lists as $data) {
                if (!isset($data->headline)) {
                    continue;
                }

                array_push($packed_data['data'], array(
                    "id"         => $data->id,
                    "headline"   => $data->headline,
                    "se_pv"      => $data->pv,
                    "updated_at" => $data->updated_at,
                ));
            }

            $packed_data['msg']          = "success";
            $packed_data['current_page'] = $datas->data->page->current_page;
            $packed_data['page_size']    = $datas->data->page->page_size;
            $packed_data['total_pages']  = $datas->data->page->total_page - 1;

            wp_send_json($packed_data, true);
        } else {
            wp_send_json(array(
                "error" => true,
                "msg"   => "鉴权失败或超时,重试后如果重复出现此问题,请务必联系开发者，Q群：689155556",
            ));
        }

    }
}
