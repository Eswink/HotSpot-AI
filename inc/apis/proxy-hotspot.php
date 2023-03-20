<?php

require_once 'vendor/autoload.php';
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class HotSpot_AI_Proxy
{
    private static $__instance;
    private $__version = 'v1';

    public function generate_text($prompt, $key)
    {
        $client = new Client(['verify' => false, 'timeout' => 120]);

        $headers = array(
            'Authorization' => 'Bearer ' . $key,
            'Content-Type'  => 'application/json',
        );

        $error_data = array(
            "delta" => "",
        );

        $data = array(
            'model'       => 'gpt-3.5-turbo',
            'messages'    => array(
                array(
                    'role'    => 'user',
                    'content' => $prompt,
                ),
            ),
            'temperature' => 0.5,
        );

        if (!isset($key) || $key == "") {
            $error_data['delta'] = "未填写正确的Key";
            echo json_encode($error_data) . "\n";
            die();
            exit();
        }

        try {

            $response = $client->post('https://hotspot-ai.eswlnk.com/v1/chat/completions', array(
                'headers' => $headers,
                'json'    => $data,
            ));

            $body = $response->getBody();

            $json_data = (string)$body;

            $result = json_decode($json_data, true);
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                $response = $e->getResponse();
                // 输出错误信息或记录日志
                if ($response == 'Unauthorized') {
                    $error_data['delta'] = "未填写正确的Key";
                    echo json_encode($error_data) . "\n";
                    die();
                    exit();
                }
            }
        }

        if (!isset($result['choices'][0]['message']['content'])) {
            $error_data['delta'] = "超时，请重新构思即可";
            echo json_encode($error_data) . "\n";
            die();
            exit();
        }

        $content = $result['choices'][0]['message']['content'];

// 将 content 字符串逐一拆分为多个字符串，并生成相应的 JSON 对象数组
        $json_objects = array();
        $prev_text    = '';
        for ($i = 0; $i < mb_strlen($content); $i++) {
            $char           = mb_substr($content, $i, 1);
            $json_objects[] = [
                'role'            => 'user',
                'text'            => $prev_text . $char,
                'delta'           => $char,
                'detail'          => [
                    'id'      => uniqid(),
                    'object'  => 'chat.completion.chunk',
                    'created' => time(),
                    'model'   => 'gpt-3.5-turbo-0301',
                    'choices' => [
                        [
                            'delta'         => [
                                'content' => $char,
                                'role'    => 'assistant',
                            ],
                            'index'         => 0,
                            'finish_reason' => null,
                        ],
                    ],
                ],
                'id'              => uniqid(),
                'parentMessageId' => uniqid(),
            ];
            $prev_text .= $char;
        }

// 生成二进制流并输出
        header('Content-Type: application/octet-stream');
        foreach ($json_objects as &$obj) {
            echo json_encode($obj, JSON_UNESCAPED_UNICODE), "\r\n";
        }
        echo "\r\n";
        ob_flush();
        flush();
        usleep(200000);
    }
}
