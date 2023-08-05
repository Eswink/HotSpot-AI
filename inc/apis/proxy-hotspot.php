<?php

namespace HotSpot\Proxy;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

defined('ABSPATH') || exit;

class HotSpot_AI_Proxy
{
    private $__baseUrl = 'https://chatapi.chatanywhere.cn/api/openai/';

    private $__model = 'gpt-3.5-turbo';

    private $__key;

    private $__temperature = 1;

    private $__topP = 1;

    private $__messages = [];

    private $__http;

    public function __construct(
        string $key,
        string $baseUrl = null,
        string $model = null,
        int $temperature = null,
        int $topP = null,
        int $timeout = 360
    ) {
        $this->__key = 'Bearer ' . $key;
        if ($baseUrl) {
            $this->__baseUrl = $baseUrl;
        }
        if ($model) {
            $this->model = $model;
        }
        if ($temperature) {
            $this->__temperature = $temperature;
        }
        if ($topP) {
            $this->__topP = $topP;
        }

        $this->__http = new Client([
            'base_uri' => $this->__baseUrl,
            'timeout'  => $timeout,
            'stream'   => true,
            'verify'   => false,
        ]);
    }

    /**
     * 添加消息
     * @param  string  $message
     * @param  string  $role
     * @return void
     */
    public function addMessage(string $message, string $role = 'user'): void
    {
        $this->__messages[] = [
            'role'    => $role,
            'content' => $message,
        ];
    }

    /**
     * 发送消息
     * @param  string  $prompt
     * @param  string|null  $user
     * @param  bool  $stream
     * @return mixed
     * @throws Exception
     */
    public function ask(string $prompt, string $user = null, bool $stream = false)
    {

        // 将消息添加到消息列表中
        $this->addMessage($prompt);

        $data = [
            'model'       => $this->__model,
            'messages'    => $this->__messages,
            'stream'      => $stream,
            'temperature' => $this->__temperature,
            'top_p'       => $this->__topP,
            'n'           => 1,
        ];

        try {
            $response = $this->__http->post(
                'v1/chat/completions',
                [
                    'json'    => $data,
                    'headers' => [
                        'Authorization' => $this->__key,
                    ],
                    'stream'  => $stream,
                ]
            );
        } catch (GuzzleException $e) {
            throw new Exception("请求出现异常，请尝试重新构思，如果重复出现此问题，请加入开发者Q群：689155556");
        }

        // 如果是数据流模式，则直接返回数据流
        if ($stream) {
            return $response->getBody();
        }

        $data = json_decode($response->getBody()->getContents(), true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception('Response is not json');
        }

        if (!$this->checkFields($data)) {
            throw new Exception('Field missing');
        }

        $answer = $data['choices'][0]['message']['content'];
        $this->addMessage($answer, 'assistant');

        return [
            'answer' => $answer,
            'id'     => $data['id'],
            'model'  => $this->__model,
            'usage'  => $data['usage'],
        ];
    }

    public function checkFields($line): bool
    {
        return isset($line['choices'][0]['message']['content']) && isset($line['id']) && isset($line['usage']);
    }

    public function checkStreamFields($line): bool
    {
        return isset($line['choices'][0]['delta']['content']) && isset($line['id']);
    }

    public function formatStreamMessage(string $line)
    {
        preg_match('/data: (.*)/', $line, $matches);
        if (empty($matches[1])) {
            return false;
        }

        $line = $matches[1];
        $data = json_decode($line, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return false;
        }

        return $data;
    }

}
