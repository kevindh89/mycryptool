<?php

declare(strict_types=1);

namespace App\Exchange\Gdax;

class RequestSigner
{
    public function sign(string $secret, string $method, string $requestPath = '', int $timestamp, string $body = ''): string
    {
        $body = is_array($body) ? json_encode($body) : $body;
        $timestamp = $timestamp ? $timestamp : time();

        $what = $timestamp . $method . $requestPath . $body;

        return base64_encode(hash_hmac('sha256', $what, base64_decode($secret), true));
    }
}
