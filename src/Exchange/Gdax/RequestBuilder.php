<?php

declare(strict_types=1);

namespace App\Exchange\Gdax;

use GuzzleHttp\Client;

class RequestBuilder
{
    const API_BASE_URI = 'https://api.gdax.com';

    private $key;
    private $secret;
    private $passphrase;

    private $client;
    private $requestSigner;

    public function __construct(string $key, string $secret, string $passphrase, Client $client, RequestSigner $requestSigner)
    {
        $this->key = $key;
        $this->secret = $secret;
        $this->passphrase = $passphrase;

        $this->client = $client;
        $this->requestSigner = $requestSigner;
    }

    public function request(string $method, string $requestPath, array $headers = [], string $body = ''): array
    {
        $timestamp = time();

        $response = $this->client
            ->request(
                $method,
                self::API_BASE_URI . $requestPath,
                [
                    'headers' => array_merge(
                        $headers,
                        [
                            'CB-ACCESS-KEY' => $this->key,
                            'CB-ACCESS-SIGN' => $this->requestSigner->sign($this->secret, $method, $requestPath, $timestamp, $body),
                            'CB-ACCESS-TIMESTAMP' => $timestamp,
                            'CB-ACCESS-PASSPHRASE' => $this->passphrase,
                        ]
                    ),
                    // TODO: Implement body somewhere (POST parameters)
                ]
            )
            ->getBody()
            ->getContents();

        return json_decode(
            $response,
            true
        );
    }
}
