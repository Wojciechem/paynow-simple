<?php

namespace PaynowSimple;

use Http\Message\RequestFactory;
use PaynowSimple\Exception\ClientException;
use PaynowSimple\ValueObject\Payment;
use PaynowSimple\ValueObject\PaymentId;
use PaynowSimple\ValueObject\Response\PaymentResponse;
use PaynowSimple\ValueObject\Response\PaymentStatus;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;

final class Client
{
    private $client;
    private $apiKey;
    private $signatureKey;
    private $requestFactory;

    public function __construct(
        ClientInterface $client,
        string $apiKey,
        string $signatureKey,
        RequestFactory $requestFactory
    ) {
        $this->client = $client;
        $this->apiKey = $apiKey;
        $this->signatureKey = $signatureKey;
        $this->requestFactory = $requestFactory;
    }

    /**
     * @throws ClientException
     */
    public function makePayment(Payment $payment): PaymentResponse
    {
        $request = $this->requestFactory->createRequest(
            'POST',
            '/v1/payments',
            [
                'Api-Key' => $this->apiKey,
                'Signature' => Sha256SignatureCalculator::calculate($this->signatureKey, $payment->asArray()),
                'Idempotency-Key' => $payment->externalId()->id(),
                'Content-Type' => 'application/json',
            ],
            \json_encode($payment)
        );

        try {
            $response = $this->client->sendRequest($request);
        } catch (ClientExceptionInterface $clientException) {
            throw new ClientException($clientException->getMessage());
        }

        return new PaymentResponse($response);
    }

    /**
     * @throws ClientException
     */
    public function paymentStatus(PaymentId $id): PaymentStatus
    {
        $request = $this->requestFactory->createRequest(
            'GET',
            \sprintf('/v1/payments/%s/status', $id->id()),
            [
                'Api-Key' => $this->apiKey,
                'Accept' => 'application/json',
            ]
        );

        try {
            $response = $this->client->sendRequest($request);
        } catch (ClientExceptionInterface $clientException) {
            throw new ClientException($clientException->getMessage());
        }

        return new PaymentStatus($response);
    }
}
