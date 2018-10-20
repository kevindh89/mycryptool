<?php

declare(strict_types=1);

namespace App\Exchange\Gdax;

use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

/**
 * Override time() in current namespace for testing.
 *
 * @return int
 */
function time()
{
    return RequestBuilderTest::$now ?: \time();
}

class RequestBuilderTest extends TestCase
{
    const SECRET = 'secret';
    const KEY = 'key';
    const PASSPHRASE = 'passphrase';
    public static $now;

    private $requestBuilder;
    private $requestSigner;

    protected function setUp()
    {
        parent::setUp();

        self::$now = strtotime('12:00');
        $this->requestSigner = $this->getMockBuilder(RequestSigner::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->requestBuilder = new RequestBuilder(
            self::KEY,
            self::SECRET,
            self::PASSPHRASE,
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
    public function it_builds_request_headers()
    {
        $this->requestSigner->expects($this->once())
            ->method('sign')
            ->with(self::SECRET, 'GET', '/orders', self::$now, '')
            ->willReturn('signature');

        $this->assertSame(
            ['headers' => $this->getDefaultHeaders()],
            $this->requestBuilder->build('GET', '/orders', [], '')
        );
    }

    private function getDefaultHeaders(): array
    {
        return [
            'CB-ACCESS-KEY' => self::KEY,
            'CB-ACCESS-SIGN' => 'signature',
            'CB-ACCESS-TIMESTAMP' => self::$now,
            'CB-ACCESS-PASSPHRASE' => self::PASSPHRASE,
        ];
    }

    private function validJsonResponse(): Response
    {
        return new Response(200, [], '{"test": 1}');
    }
}
