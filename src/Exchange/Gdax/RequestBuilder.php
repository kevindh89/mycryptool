<?php

declare(strict_types=1);

namespace App\Exchange\Gdax;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;

class RequestBuilder
{
    const API_BASE_URI = 'https://api.gdax.com';

    private $key;
    private $secret;
    private $passphrase;

    private $client;

    public function __construct(string $key, string $secret, string $passphrase)
    {
        $this->key = $key;
        $this->secret = $secret;
        $this->passphrase = $passphrase;

        $this->client = new Client();
    }

    public function request(string $method, string $requestPath, array $headers = [], string $body = ''): Response
    {
        $timestamp = time();

        return $this->client->request(
            $method,
            self::API_BASE_URI . $requestPath,
            [
                'headers' => array_merge(
                    $headers,
                    [
                        'CB-ACCESS-KEY' => $this->key,
                        'CB-ACCESS-SIGN' => $this->signature($method, $requestPath, $timestamp, $body),
                        'CB-ACCESS-TIMESTAMP' => $timestamp,
                        'CB-ACCESS-PASSPHRASE' => $this->passphrase
                    ]
                )
                // TODO: Implement body somewhere (POST parameters)
            ]
        );
    }

    private function signature(string $method, string $requestPath = '', int $timestamp, string $body = ''): string
    {
        $body = is_array($body) ? json_encode($body) : $body;
        $timestamp = $timestamp ? $timestamp : time();

        $what = $timestamp . $method . $requestPath . $body;

        return base64_encode(hash_hmac('sha256', $what, base64_decode($this->secret), true));
    }
}
