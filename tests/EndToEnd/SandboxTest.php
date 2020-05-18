<?php

namespace PaynowSimple\EndToEnd;

use PaynowSimple\ClientFactory;
use PaynowSimple\ValueObject\Payment;
use PaynowSimple\ValueObject\PaymentId;
use PaynowSimple\ValueObject\Response\PaymentResponse;
use PaynowSimple\ValueObject\Response\PaymentStatus;
use PHPUnit\Framework\TestCase;

/**
 * @coversNothing
 */
class SandboxTest extends TestCase
{
    private $apiKey;
    private $signature;

    protected function setUp(): void
    {
        $this->apiKey = getenv('PAYNOW_SANDBOX_APIKEY');
        $this->signature = getenv('PAYNOW_SANDBOX_SIGNATURE');

        if (false === $this->apiKey) {
            $this->markTestSkipped('PAYNOW_SANDBOX_APIKEY environment variable must be set');
        }

        if (false === $this->signature) {
            $this->markTestSkipped('PAYNOW_SANDBOX_SIGNATURE environment variable must be set');
        }
    }

    public function testPaymentScenarioIsSuccesful()
    {
        $client = ClientFactory::sandbox()->create($this->apiKey, $this->signature);
        $externalId = 'SANDBOX_TEST-';
        $externalId .= (string) mt_rand(1, 100000000);

        $madePayment = $client->makePayment(
            Payment::create(
                20000,
                'PLN',
                $externalId,
                'Sandbox Test payment',
                'test@er.invalid'
            )
        );

        $this->assertInstanceOf(PaymentResponse::class, $madePayment);
        echo $madePayment->redirectUrl();

        sleep(5);

        $paymentStatus = $client->paymentStatus(new PaymentId($madePayment->paymentId()));

        $this->assertInstanceOf(PaymentStatus::class, $paymentStatus);
        $this->assertSame('NEW', $paymentStatus->status());
    }
}
