<?php

namespace PaynowSimple;

use Http\Message\RequestFactory;
use PaynowSimple\ValueObject\Payment;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * @covers \PaynowSimple\Client
 *
 * @uses \GuzzleHttp\Client
 * @uses \Http\Adapter\Guzzle6\Client
 * @uses \PaynowSimple\Sha256SignatureCalculator
 * @uses \PaynowSimple\ValueObject\Payment
 * @uses \PaynowSimple\ValueObject\Response\PaymentResponse
 */
class ClientTest extends TestCase
{
    public function testCreate()
    {
        $client = Client::create('123', '456');
        $this->assertInstanceOf(Client::class, $client);
    }

    public function testSandbox()
    {
        $client = Client::sandbox('123', '456');
        $this->assertInstanceOf(Client::class, $client);
    }

    // TODO: fragile test, think how to rewrite it
    public function testCanMakePayment()
    {
        $httpClient = new \Http\Mock\Client();
        $calculator = $this->createMock(SignatureCalculator::class);
        $factory = $this->createMock(RequestFactory::class);
        $payment = $this->createMock(Payment::class);
        $client = new Client($httpClient, 'apikey', $calculator, $factory);
        $response = $this->createMock(ResponseInterface::class);
        $response->method('getBody')->willReturn(new class() {
            public function getContents()
            {
                return '{"paymentId": "abcdef", "status": "NEW"}';
            }
        });

        $factory->expects(self::once())
            ->method('createRequest')
            ->willReturn($this->createMock(RequestInterface::class))
        ;
        $payment->expects(self::once())->method('asArray');
        $payment->expects(self::once())->method('jsonSerialize');
        $calculator->expects(self::once())->method('calculate');
        $httpClient->setDefaultResponse($response);

        $client->makePayment($payment);
    }
}
