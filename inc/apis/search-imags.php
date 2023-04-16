<?php

namespace HotSpot\Search;

use Exception;
use WP_Error;

class ImageSearchAPI
{
    protected $_auth_token; // API 授权令牌
    protected $_api_endpoint; // API 端点 URL

    /**
     * 构造函数，初始化 API 授权令牌和端点 URL
     **/
    public function __construct($auth_token, $api_endpoint)
    {
        $this->_auth_token   = $auth_token;
        $this->_api_endpoint = $api_endpoint;
    }

    /**
     * 图像搜索方法
     **/
    public function searchImages($query)
    {
        try {
            // 构造 POST 请求参数
            $url     = $this->_api_endpoint . '/auth/search-images';
            $headers = array(
                'Authorization' => $this->_auth_token,
                'Content-Type'  => 'application/json',
            );
            $body = array('query' => $query);
            $args = array(
                'timeout'   => 20,
                'sslverify' => false, // 启用 SSL/TLS 证书验证
                 'headers'   => $headers,
                'body'      => json_encode($body),
            );

            // 发送 POST 请求，并捕获异常
            $response = wp_remote_post($url, $args);
            if (is_wp_error($response)) {
                // 请求失败
                return new WP_Error('SEARCH_FAILED', __('无法连接到图像搜索服务'), ['status' => 500]);
            }

            // 解析响应结果
            $data = json_decode($response['body'], true);

            // 检查响应状态码，如果不是 200，则抛出异常
            if (isset($data['code'])) {
                throw new Exception($data['message']);
            }

            if (empty($data)) {
                throw new Exception("无法搜索到相关图片");
            }

            $result = array(
                "data" => $data,
            );
            return rest_ensure_response($result);

        } catch (Exception $e) {
            return new WP_Error('SEARCH_FAILED', __('失败原因: ') . $e->getMessage(), ['status' => 500]);
        }
    }
}
