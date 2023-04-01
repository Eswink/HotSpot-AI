<?php
/*
 * @Descripttion: js
 * @Version: 1.0
 * @Author: name
 * @Date: 2023-03-25 03:06:33
 * @LastEditors: name
 * @LastEditTime: 2023-04-01 13:49:50
 */

namespace HotSpot\Check;

require_once 'vendor/autoload.php';
use Exception;
use GuzzleHttp\Client;

if (!defined('ABSPATH')) {
    exit;
}

class Check_Credit
{
    // 定义 API 请求的基础 URL
    private $__base_url = 'https://hotspot-ai.eswlnk.com';

    // 定义授权信息中的 Bearer Token
    private $__key;

    public function __construct($key, $base_url)
    {
        $this->__key = $key;
        if ($base_url) {
            $this->__base_url = $base_url;
        }

    }

    // 获取用户的信用额度
    public function getCredit()
    {
        try {
            // 创建 GuzzleHttp Client 实例
            $client = new Client([
                'base_uri' => $this->__base_url, // 设置 API 请求的基础 URL
                 'timeout'  => 30.0, // 设置请求超时时间
                 'verify'   => false,
            ]);

            // 定义请求 Headers
            $headers = [
                'Authorization' => 'Bearer ' . $this->__key,
                'Content-Type'  => 'application/json',
            ];

            // 发送 GET 请求并获取响应 添加时间戳防止缓存
            $response = $client->get('/dashboard/billing/credit_grants?timestamp=' . time(), [
                'headers' => $headers, // 设置请求 Headers
            ]);

            // 解析响应数据
            $data = json_decode($response->getBody()->getContents(), true);

            if (isset($data['error'])) {
                $result = array(
                    "error" => true,
                    "msg"   => $data['invalid_api_key'],
                );
                return $result;
            }
            if (isset($data['grants'])) {
                $grant_amount    = number_format($data['grants']['data'][0]['grant_amount'], 2);
                $used_amount     = number_format($data['grants']['data'][0]['used_amount'], 2);
                $expires_at      = date('Y-m-d H:i:s', $data['grants']['data'][0]['expires_at']); // 每个授权的过期时间
                $total_available = number_format($data['total_available'], 2);
                $result          = array(
                    "grant_amount"    => $grant_amount,
                    "used_amount"     => $used_amount,
                    "expires_at"      => $expires_at,
                    "total_available" => $total_available,
                );

                return $result;
            }
            $result = array(
                "error" => true,
                "msg"   => "发生错误，请核对API秘钥是否正确或更换API秘钥！",
            );

            return $result;

        } catch (Exception $e) {
            $result = array(
                "error" => true,
                "msg"   => '发生错误，请核对API秘钥是否正确或更换API秘钥！',
            );
            // 发生异常时返回错误信息
            return $result;
        }
    }
}
