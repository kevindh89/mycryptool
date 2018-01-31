<?php

declare(strict_types=1);

namespace App\Exchange\Gdax;

use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

/**
 * Override time() in current namespace for testing
 *
 * @return int
 */
function time()
{
    return RequestBuilderTest::$now ?: \time();
}

class RequestBuilderTest extends TestCase
{
    public static $now;

    private $client;
    private $requestBuilder;
    private $requestSigner;

    const SECRET = 'secret';
    const KEY = 'key';
    const PASSPHRASE = 'passphrase';

    protected function setUp()
    {
        parent::setUp();

        self::$now = strtotime('12:00');
        $this->client = $this->getMockBuilder(\GuzzleHttp\Client::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->requestSigner = $this->getMockBuilder(RequestSigner::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->requestBuilder = new RequestBuilder(
            self::KEY,
            self::SECRET,
            self::PASSPHRASE,
            $this->client,
            $this->requestSigner
        );
    }

    protected function tearDown(): void
    {
        self::$now = null;
    }

    /**
     * @test
     */
    public function it_uses_client_and_signs_a_request()
    {
        $this->client->expects($this->once())
            ->method('request')
            ->with(
                'GET',
                RequestBuilder::API_BASE_URI .'/orders',
                [
                    'headers' => $this->getDefaultHeaders()
                ]
            )
            ->willReturn($this->validJsonResponse());
        $this->requestSigner->expects($this->once())
            ->method('sign')
            ->with(self::SECRET, 'GET', '/orders', self::$now, '')
            ->willReturn('signature');

        $this->assertEquals(
            ['test' => 1],
            $this->requestBuilder->request('GET', '/orders', [], '')
        );
    }

    private function getDefaultHeaders(): array
    {
        return [
            'CB-ACCESS-KEY' => self::KEY,
            'CB-ACCESS-SIGN' => 'signature',
            'CB-ACCESS-TIMESTAMP' => self::$now,
            'CB-ACCESS-PASSPHRASE' => self::PASSPHRASE
        ];
    }

    private function validJsonResponse(): Response
    {
        return new Response(200, [], '{"test": 1}');
    }
}
