<?php

namespace PaynowSimple;

use Http\Message\RequestFactory;
use PaynowSimple\Exception\ClientException;
use PaynowSimple\ValueObject\Payment;
use PaynowSimple\ValueObject\PaymentId;
use PaynowSimple\ValueObject\Response\PaymentResponse;
use PaynowSimple\ValueObject\Response\PaymentStatus;
use PHPUnit\Framework\TestCase;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * @covers \PaynowSimple\Client
 *
 * @uses \PaynowSimple\Sha256SignatureCalculator
 * @uses \PaynowSimple\ValueObject\Payment
 * @uses \PaynowSimple\ValueObject\PaymentId
 * @uses \PaynowSimple\ValueObject\Response\PaymentStatus
 * @uses \PaynowSimple\ValueObject\Response\PaymentResponse
 * @uses \PaynowSimple\ValueObject\Amount
 * @uses \PaynowSimple\ValueObject\Buyer
 * @uses \PaynowSimple\ValueObject\Currency
 * @uses \PaynowSimple\ValueObject\Description
 * @uses \PaynowSimple\ValueObject\ExternalId
 */
class ClientTest extends TestCase
{
    private $httpClient;
    private $factory;
    private $client;

    protected function setUp(): void
    {
        $this->httpClient = new \Http\Mock\Client();
        $this->factory = $this->createMock(RequestFactory::class);
        $this->client = new Client($this->httpClient, 'apikey', 'sigKey', $this->factory);
        $httpResponse = $this->createMock(ResponseInterface::class);
        $httpResponse->method('getBody')->willReturn(new class() {
            public function getContents()
            {
                return '{"paymentId": "abcdef", "status": "NEW"}';
            }
        });
        $this->httpClient->setDefaultResponse($httpResponse);
    }

    // TODO: fragile test with lots of mocks, what problem does it indicate?
    public function testCanMakePayment()
    {
        $this->factory->expects(self::once())
            ->method('createRequest')
            ->willReturn($this->createMock(RequestInterface::class))
        ;

        $paymentResponse = $this->client->makePayment(
            Payment::create(
                1000,
                'PLN',
                '00-1249',
                '...',
                'tester@acme.invalid'
            )
        );

        $this->assertInstanceOf(PaymentResponse::class, $paymentResponse);
    }

    public function testExceptionOnHttpClientErrorInMakePayment()
    {
        $this->factory->expects(self::once())
            ->method('createRequest')
            ->willReturn($this->createMock(RequestInterface::class))
        ;
        $this->httpClient->setDefaultException($this->createMock(ClientExceptionInterface::class));

        $this->expectException(ClientException::class);

        $this->client->makePayment(
            Payment::create(
                1000,
                'PLN',
                '00-1249',
                '...',
                'tester@acme.invalid'
            )
        );
    }

    public function testCanCheckPaymentStatus()
    {
        $this->factory->expects(self::once())
            ->method('createRequest')
            ->willReturn($this->createMock(RequestInterface::class))
        ;

        $response = $this->client->paymentStatus(new PaymentId('1234512345123456'));

        $this->assertInstanceOf(PaymentStatus::class, $response);
    }

    public function testExceptionOnHttpClientErrorInPaymentStatus()
    {
        $this->factory->expects(self::once())
            ->method('createRequest')
            ->willReturn($this->createMock(RequestInterface::class))
        ;
        $this->httpClient->setDefaultException($this->createMock(ClientExceptionInterface::class));

        $this->expectException(ClientException::class);

        $this->client->paymentStatus(new PaymentId('1234512345123456'));
    }
}
