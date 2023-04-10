<?php

namespace HotSpot\Signin;

use Exception;
use WP_Error;
use WP_REST_Response;

class SigninApi
{
    /**
     * 登录方法，接收 email 和 password 数据并发送 POST 请求
     *
     * @param string $email
     * @param string $password
     *
     * @return WP_REST_Response
     *
     * @throws Exception 如果请求失败或登录失败
     */
    public static function signin($email, $password, $token)
    {
        try {
            // 检查 email 和 password 是否为空
            if (empty($email)) {
                return new WP_Error('LOGIN_FAILED', __('邮箱不能为空'), ['status' => 400]);
            }
            if (empty($password)) {
                return new WP_Error('LOGIN_FAILED', __('密码不能为空'), ['status' => 400]);
            }

            // 发送 POST 请求
            $response = wp_remote_post('https://x8ki-letl-twmt.n7.xano.io/api:tHUkNdeR/auth/login', [
                'body'      => [
                    'email'                => $email,
                    'password'             => $password,
                    'g-recaptcha-response' => $token,
                ],
                'headers'   => [
                    'Accept' => 'application/json',
                ],
                'sslverify' => true, // 开启 SSL 验证
            ]);

            // 判断是否出现错误
            if (is_wp_error($response)) {
                return new WP_Error('REQUEST_FAILED', $response->get_error_message(), ['status' => 500]);
            }

            // 检查响应状态码，如果不是 200，则抛出异常
            if ($response['response']['code'] !== 200) {
                throw new Exception('邮箱或密码不正确!');
            }

            // 解析响应数据
            $data = json_decode($response['body'], true);

            // 判断是否登录成功 登录成功后我们需要保存token值
            if (isset($data['authToken'])) {
                update_option('auth_signin_token', $data['authToken']);
                $result = [
                    'success' => true,
                    'msg'     => '登录成功！',
                ];
            } elseif (isset($data['code'])) {
                $result = [
                    'success' => false,
                    'message' => $data['message'],
                ];
            } else {
                throw new Exception('Unknown response.');
            }

            // 将结果封装成 WP_REST_Response 类型并返回
            return rest_ensure_response($result);

        } catch (Exception $e) {
            // 捕获 Exception 异常并返回一个符合 rest_ensure_response 规范的错误信息
            return new WP_Error('LOGIN_FAILED', __('失败原因: ') . $e->getMessage(), ['status' => 500]);
        }
    }
}
