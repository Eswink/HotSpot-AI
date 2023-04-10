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
        $this->__chatProcessUrl = 'https://cbjtestapi.binjie.site:7777/api/generateStream';
        if ($prompt) {
            $this->__prompt = $prompt;
        }
        $token = get_option("auth_signin_token");
        if (!$token) {
            throw new Exception("未登录用户，无法使用免费接口");
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
        // 初始化 GuzzleHttp 客户端
        $client = new Client(['verify' => false, 'timeout' => 15]);

        try {
            // 发送 POST 请求
            $response = $client->request('POST', $this->__chatProcessUrl, [
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
                'json'    => [
                    'prompt'         => $this->__prompt,
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

        // 获取响应的正文并输出到浏览器
        $body   = $response->getBody();
        $stream = Psr7\Utils::streamFor($body);
        header('Content-type: application/octet-stream');
        header('Cache-Control: no-cache');

// 先设置每次读取的长度
        $chunkSize = 512;
        stream_set_chunk_size($stream, $chunkSize);

// 初始化未处理数据
        $remainingData = '';

        while (!$stream->eof()) {
            // 读取 $chunkSize 个字符
            $chunk = Psr7\Utils::readLine($stream, $chunkSize);

            // 如果 $chunk 不为空，则说明读取到了数据
            if (!empty($chunk)) {
                // 拼接上一段未处理完的数据
                $chunk = $remainingData . $chunk;

                // 将 $chunk 分割为单个字符
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
                    echo esc_html(json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_LINE_TERMINATORS));
                    echo esc_html("\n");
                }

                // 设置未处理数据
                $remainingData = '';
            } else {
                // 如果 $chunk 为空，则说明读取到了文件尾（EOF）
                // 将未处理完的数据保存到 $remainingData 变量中
                $remainingData .= $chunk;
            }

            unset($chunk);
            ob_flush();
            flush();
        }

        ob_end_clean();
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
                ],
                'json'    => [
                    'prompt' => $prompt,
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
