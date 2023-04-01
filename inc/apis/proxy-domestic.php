<?php
/*
 * @Descripttion: js
 * @Version: 1.0
 * @Author: name
 * @Date: 2023-03-20 11:47:56
 * @LastEditors: name
 * @LastEditTime: 2023-04-01 12:58:03
 */

namespace HotSpot\Free;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7;

/**
 * AI 机器人类，用于调用接口获取生成的文章结果
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
        $this->__chatProcessUrl = 'https://233.gay/api/chat-process';
        if ($prompt) {
            $this->__prompt = $prompt;
        }
    }

    /**
     * 发送 POST 请求以获取生成的文章结果并输出到浏览器
     *
     * @param string $prompt 需要生成的文章题目
     * @throws Exception 如果请求出错则抛出异常，需要在外部进行处理
     */
    public function handleRequest(string $prompt): void
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
                    'prompt' => $this->__prompt,
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
        ob_end_clean();

        while (!$stream->eof()) {
            $raw = Psr7\Utils::readLine($stream);
            echo esc_html($raw);
            unset($raw);
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
