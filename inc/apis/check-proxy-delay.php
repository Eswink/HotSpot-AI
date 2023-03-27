<?php

namespace HotSpot\Proxy;

use InvalidArgumentException;

class UrlLatencyChecker
{
    private $__url;
    private $__timeout;

    public function __construct($url, $timeout = 1)
    {
        $this->__url     = esc_url_raw($url); // 将 $__url 修改为 $url
        $this->__timeout = (int)$timeout;
    }

    public function check()
    {
        $start_time = microtime(true);
        $args       = array(
            'timeout'   => $this->__timeout,
            'sslverify' => false,
            'headers'   => array(
                'Host' => $this->__parse_host(),
            ),
        );

        $response = wp_remote_get($this->__build_url($this->__url), $args); // 将 $this->$__url 修改为 $this->url

        if (is_wp_error($response)) {
            return "无法检测，请询问开发者";
        }
        $end_time = microtime(true);
        return round(($end_time - $start_time) * 1000, 2);
    }

    private function __build_url($url)
    {
        $parsed_url = parse_url($url);
        $scheme     = isset($parsed_url['scheme']) ? strtolower($parsed_url['scheme']) : 'http';
        $host       = isset($parsed_url['host']) ? strtolower($parsed_url['host']) : '';
        $port       = isset($parsed_url['port']) ? $parsed_url['port'] : ($scheme == 'https' ? 443 : 80);
        $path       = isset($parsed_url['path']) ? $parsed_url['path'] : '/';
        $query      = isset($parsed_url['query']) ? $parsed_url['query'] : '';

        $result = "{$scheme}://{$host}:{$port}{$path}";
        if (!empty($query)) {
            $result .= '?' . $query;
        }

        return $result;
    }

    private function __parse_host()
    {
        $parts = parse_url($this->__url); // 将 $__url 修改为 $url
        if (isset($parts['host'])) {
            return $parts['host'];
        } elseif (isset($parts['path'])) {
            return $parts['path'];
        } else {
            throw new InvalidArgumentException('Invalid host');
        }
    }
}
