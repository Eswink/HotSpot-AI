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
        $this->__chatProcessUrl = 'https://ai.qidianym.net/api/chat-process';
        if ($prompt) {
            $this->__prompt = $prompt;
        }
        $token = get_option("auth_signin_token");
        if (!$token) {
            throw new Exception("未登录用户，无法使用免费接口，如果重复出现此问题，请加入开发者Q群：689155556");
        }
    }

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
                    'Referer'      => 'https://ai.qidianym.net/',
                    'User-Agent'   => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) ChatBOT???/1.0.6 Chrome/98.0.4758.102 CoreVer/17.1.0 Safari/537.36 LT-PC/Win/1702/106 mianfeibanexe',
                ],
                'json'    => [
                    'prompt'      => $this->__prompt,
                    'temperature' => 0.8,
                    'top_p'       => 1,
                    'stream'      => true,
                ],
                'stream'  => true,
            ]);

            // 获取响应的正文并输出到浏览器
            $body   = $response->getBody();
            $stream = Psr7\Utils::streamFor($body);
            header('Content-type: application/octet-stream');
            header('Cache-Control: no-cache');

            ob_start();

            while (!$stream->eof()) {
                $raw = Psr7\Utils::readLine($stream);
                echo esc_html($raw);
                unset($raw);
                ob_flush();
                flush();
            }

            // 关闭流和断开连接
            $stream->close();
            $client->resetStream();

        } catch (GuzzleException $e) {
            // 如果请求出错，则抛出异常
            throw new Exception("请求出现异常，请尝试重新构思，如果重复出现此问题，请加入开发者Q群：689155556");
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
                    'Referer'      => 'https://ai.qidianym.net/',
                    'User-Agent'   => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) ChatBOT???/1.0.6 Chrome/98.0.4758.102 CoreVer/17.1.0 Safari/537.36 LT-PC/Win/1702/106 mianfeibanexe',
                ],
                'json'    => [
                    'prompt'      => $prompt,
                    'temperature' => 0.8,
                    'top_p'       => 1,
                    'stream'      => false,
                ],
                'stream'  => false,
            ]);
        } catch (GuzzleException $e) {
            // 如果请求出错，则抛出异常
            throw new Exception($e->getMessage());
        }

        $data = explode("\n", $response->getBody()->getContents());

        $data = json_decode(end($data), true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception('Response is not json');
        }

        if (!isset($data['text'])) {

            throw new Exception('请求出现异常！请联系开发者！请加入开发者Q群：689155556');
        }

        if (isset($data['status']) && $data['status'] == 'Fail') {
            throw new Exception('请求出现异常！请联系开发者！请加入开发者Q群：689155556');
        }

        $answer = $data['text'];
        return $answer;

    }

    public function checkFields($line): bool
    {
        return isset($line['choices'][0]['message']['content']) && isset($line['id']) && isset($line['usage']);
    }

    public function checkStreamFields($line): bool
    {
        return isset($line['choices'][0]['delta']['content']) && isset($line['id']);
    }

}
