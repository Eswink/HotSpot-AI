<?php
class Domestic_AI_Proxy
{
    private $__chatProcessUrl = 'https://233.gay/api/chat-process';

    public function handleRequest($prompt)
    {

        $request_text = 'Please write a 1,000-character article in Chinese with the title "' . $prompt . '", requiring subtitles for each paragraph and no H1 headings. Paragraphs need to be wrapped with <p> tags, and subheadings are wrapped with <h2>. In addition, the first paragraph must be an introduction, no subheadings, packaging labels and symbols need to be included in the character count, and the article must be complete without truncation';

        $data = array(
            'prompt' => $request_text,
        );

        $headers = array(
            'Content-Type: application/json',
        );

        $curl_options = array(
            CURLOPT_URL            => $this->__chatProcessUrl,
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => json_encode($data),
            CURLOPT_HTTPHEADER     => $headers,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER         => false,
            CURLOPT_ENCODING       => "gzip",
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_BUFFERSIZE     => 128,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_WRITEFUNCTION  => function ($curl, $data) {
                echo $data;
                return strlen($data);
            },
            CURLOPT_REFERER        => "https://233.gay/",
        );

        $ch = curl_init();
        curl_setopt_array($ch, $curl_options);
        curl_exec($ch);
        curl_close($ch);
    }
}
