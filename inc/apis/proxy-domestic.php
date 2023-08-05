<?php

namespace HotSpot\Free;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7;

/**
 * 用于调用接口获取生成的文章结果
 */
class HotSpot_Domestic_AI_Proxy
{
    /**
     * 请求 API 的 URL
     *
     * @var string
     */
    private $__chatProcessUrl;
    private $__prompt;

    /**
     * 构造函数，初始化 API URL
     */
    public function __construct(string $prompt)
    {
        $this->__chatProcessUrl = 'https://api.binjie.fun/api/generateStream';
        if ($prompt) {
            $this->__prompt = $prompt;
        }
        $token = get_option("auth_signin_token");
        if (!$token) {
            throw new Exception("未登录用户，无法使用免费接口，如果重复出现此问题，请加入开发者Q群：689155556");
        }
    }

    /**
     * 发送 POST 请求以获取生成的文章结果并输出到浏览器
     *
     * @param string $prompt 需要生成的文章题目
     * @throws Exception 如果请求出错则抛出异常，需要在外部进行处理
     */
    public function handleRequest(): void
    {
        try {
            // 初始化 GuzzleHttp 客户端
            $client = new Client([
                'verify'  => false,
                'timeout' => 30,
            ]);

            // 发送 POST 请求
            $response = $client->request('POST', $this->__chatProcessUrl, [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Origin'       => 'https://chat11.aichatos.xyz',
                    'Referer'      => 'https://chat11.aichatos.xyz/',
                ],
                'json'    => [
                    'prompt'         => $this->__prompt,
                    'network'        => false,
                    'system'         => "",
                    'withoutContext' => false,
                    'stream'         => false,
                ],
                'stream'  => true,
            ]);
        } catch (GuzzleException $e) {
            // 如果请求出错，则抛出异常
            throw new Exception("请求出现异常，请尝试重新构思，如果重复出现此问题，请加入开发者Q群：689155556");
        }

// 获取响应的正文并输出到浏览器
        $body   = $response->getBody();
        $stream = Psr7\Utils::streamFor($body);
        header('Content-type: application/octet-stream');
        header('Cache-Control: no-cache');

        ob_end_clean();

        while (!$stream->eof()) {
            $chunk = Psr7\Utils::readLine($stream);

            if (!empty($chunk)) {
                $chars = mb_str_split($chunk);

                foreach ($chars as $char) {
                    $data = [
                        'id'      => uniqid('chatcmpl-'),
                        'object'  => 'chat.completion.chunk',
                        'created' => time(),
                        'model'   => 'gpt-3.5-turbo-0301',
                        'choices' => [
                            [
                                'delta'         => [
                                    'content' => $char,
                                ],
                                'index'         => 0,
                                'finish_reason' => null,
                            ],
                        ],
                        'delta'   => $char,
                    ];
                    echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_LINE_TERMINATORS);
                    echo "\n";
                }
            }

            unset($chunk);
            ob_flush();
            flush();
        }

    }

    /**
     * 解析返回的原始数据流，并将其转换为可读取的格式
     *
     * @param string $line 返回的原始数据流
     * @return mixed|null 解析后的 JSON 格式数据，如果解析失败则返回 null
     */
    public function formatStreamMessage(string $line)
    {
        preg_match('/data: (.*)/', $line, $matches);
        if (empty($matches[1])) {
            return null;
        }

        $line = $matches[1];
        $data = json_decode($line, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return null;
        }

        return $data;
    }

    /**
     * 发送 POST 请求以获取生成的文章结果并返回响应的原始数据流
     *
     * @param string $prompt 需要生成的文章题目
     * @throws Exception 如果请求出错则抛出异常，需要在外部进行处理
     * @return string 响应的原始数据流
     */
    public function fetchResponse(string $prompt): string
    {
        // 初始化 GuzzleHttp 客户端
        $client = new Client(['verify' => false, 'timeout' => 30]);

        try {
            // 发送 POST 请求
            $response = $client->request('POST', $this->__chatProcessUrl, [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'origin'       => 'http://chat1.aichatos.com',
                    'referer'      => 'http://chat1.aichatos.com/',
                ],
                'json'    => [
                    'prompt'         => $prompt,
                    "network"        => false,
                    "apikey"         => "",
                    "system"         => "",
                    "withoutContext" => false,
                ],
                'stream'  => true,
            ]);
        } catch (GuzzleException $e) {
            // 如果请求出错，则抛出异常
            throw new Exception($e->getMessage());
        }

        // 获取响应的正文并返回原始数据流
        return $response->getBody()->getContents();
    }

}
