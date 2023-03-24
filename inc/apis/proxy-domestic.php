<?php

namespace HotSpot\Free;

require_once 'vendor/autoload.php';
use GuzzleHttp\Client;
use GuzzleHttp\Psr7;

class HotSpot_Domestic_AI_Proxy
{
    private $__chatProcessUrl = 'https://233.gay/api/chat-process';

    public function handleRequest($prompt)
    {
        $request_text = 'Please write a 1,000-character article in Chinese with the title "' . $prompt . '", requiring subtitles for each paragraph and no H1 headings. Paragraphs need to be wrapped with <p> tags, and subheadings are wrapped with <h2>. In addition, the first paragraph must be an introduction, no subheadings, packaging labels and symbols need to be included in the character count, and the article must be complete without truncation';

        $client = new Client(['verify' => false]);

        try {
            $response = $client->request('POST', $this->__chatProcessUrl, [
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
                'json'    => [
                    'prompt' => $request_text,
                ],
                'stream'  => true,
            ]);
        } catch (GuzzleException $e) {
            throw new Exception($e->getMessage());
        }

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
