<?php

namespace HotSpot\Signup;

use Exception;
use WP_Error;
use WP_REST_Response;

class SignupApi
{
    /**
     * 注册方法，接收 email 和 password 和 confirm password 数据并发送 POST 请求
     *
     * @param string $email
     * @param string $password
     * @param string $confirm_password
     * @param string $code
     * @param string $token 验证码
     *
     * @return WP_REST_Response
     *
     * @throws Exception 如果请求失败或注册失败
     */
    public static function signup($username, $email, $password, $confirm_password, $code, $token)
    {
        $url = 'https://x8ki-letl-twmt.n7.xano.io/api:tHUkNdeR/auth/signup';

        if (empty($username) || empty($email) || empty($password) || empty($confirm_password) || empty($token) || empty($code)) {
            return new WP_Error('REGISTER_FAILED', __('参数不能为空'), ['status' => 400]);
        }

        if ($password !== $confirm_password) {
            return new WP_Error('REGISTER_FAILED', __('两次密码不一致'), ['status' => 400]);
        }

        $data = array(
            'username'             => $username,
            'email'                => $email,
            'password'             => $password,
            'confirm_password'     => $confirm_password,
            'code'                 => $code,
            'g-recaptcha-response' => $token,
        );

        try {
            $response = wp_remote_post($url, array(
                'headers' => array('Content-Type' => 'application/json'),
                'body'    => json_encode($data),
                'timeout' => 30, // 超时时间为 30 秒
            ));

            if (is_wp_error($response)) {
                throw new Exception($response->get_error_message());
            }

            $result = json_decode(wp_remote_retrieve_body($response), true);

            if (isset($result['code'])) {
                throw new Exception($result['message']);
            }

            if (!isset($result['authToken'])) {
                throw new Exception($result['message']);
            } else {
                update_option('auth_signin_token', $result['authToken']);
                $return_res = [
                    'success' => true,
                    'message' => "注册成功",
                ];
                return new WP_REST_Response($return_res, 200);
            }

        } catch (Exception $e) {
            $error_data = array(
                'status'  => 500,
                'message' => $e->getMessage(),
            );
            return new WP_Error('REGISTER_FAILED', $e->getMessage(), $error_data);
        }
    }

/**
 * 发送电子邮件
 *
 * @param string $captchaResponse hCaptcha 响应值
 * @param string $email 电子邮件地址
 *
 * @return \WP_REST_Response REST API 响应
 */
    public function send_email($captchaResponse, $email)
    {

        // 判断参数是否完整

        if (empty($captchaResponse) || empty($email)) {
            return new WP_Error('SEND_FAILED', __('参数不能为空'), ['status' => 400]);
        }

        // 构造 POST 数据
        $postData = array(
            'g-recaptcha-response' => $captchaResponse,
            'email'                => $email,
        );

        $options = array(
            'timeout' => 30, // 超时时间为 30 秒
             'method'  => 'POST',
            'body'    => $postData,
        );

        try {

            // 发送 POST 请求并获取响应
            $response = wp_remote_post('https://x8ki-letl-twmt.n7.xano.io/api:tHUkNdeR/auth/send_email', $options);

            if (is_wp_error($response)) {
                throw new Exception($response->get_error_message());
            }

            $result = json_decode(wp_remote_retrieve_body($response), true);

            if (isset($result['code'])) {
                throw new Exception($result['message']);
            }

            if (!isset($result['success'])) {
                throw new Exception($result['message']);
            } else {
                $return_res = [
                    'success' => true,
                    'message' => "发送成功，请检查收件箱",
                ];
                return new WP_REST_Response($return_res, 200);
            }

        } catch (Exception $e) {
            $error_data = array(
                'status'  => 500,
                'message' => $e->getMessage(),
            );
            return new WP_Error('SEND_FAILED', $e->getMessage(), $error_data);
        }
    }

}
