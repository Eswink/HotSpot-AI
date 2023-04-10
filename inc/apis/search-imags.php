<?php
/*
 * @Descripttion: js
 * @Version: 1.0
 * @Author: name
 * @Date: 2023-03-29 16:53:57
 * @LastEditors: name
 * @LastEditTime: 2023-04-01 15:16:39
 */

namespace HotSpot\Search;

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
        $url = $this->_api_endpoint . '/auth/search-images';

        $response = wp_remote_post(
            $url,
            array(
                'headers'   => array(
                    'Authorization' => $this->_auth_token,
                    'Content-Type'  => 'application/json',
                ),
                'body'      => json_encode(array('query' => $query)),
                'timeout'   => 20,
                'sslverify' => false, // 启用 SSL/TLS 证书验证
            )
        );

        if (is_wp_error($response)) {
            // 请求失败
            return $response;
        } else {
            $response_code = wp_remote_retrieve_response_code($response);
            $response_body = wp_remote_retrieve_body($response);

            if ($response_code == '200') {
                // 请求成功
                $data = array(
                    'data' => json_decode($response_body, true),
                );
                return rest_ensure_response($data);
            } else {
                // 请求错误
                return new \WP_Error('api_error', json_decode($response_body));
            }
        }
    }
}
