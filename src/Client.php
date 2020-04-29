<?php

namespace PaynowSimple;

use Http\Adapter\Guzzle6\Client as GuzzleClientAdapter;
use Http\Message\MessageFactory\GuzzleMessageFactory;
use Http\Message\RequestFactory;
use PaynowSimple\Exception\ClientException;
use PaynowSimple\ValueObject\Payment;
use PaynowSimple\ValueObject\PaymentId;
use PaynowSimple\ValueObject\Response\PaymentResponse;
use PaynowSimple\ValueObject\Response\PaymentStatus;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;

class Client
{
    private $client;
    private $signatureCalculator;
    private $apiKey;
    private $requestFactory;

    private const API_URL = 'https://api.paynow.pl';
    private const SANDBOX_URL = 'https://api.sandbox.paynow.pl';

    public function __construct(
        ClientInterface $client,
        string $apiKey,
        SignatureCalculator $signatureCalculator,
        RequestFactory $requestFactory
    ) {
        $this->client = $client;
        $this->signatureCalculator = $signatureCalculator;
        $this->apiKey = $apiKey;
        $this->requestFactory = $requestFactory;
    }

    private static function template(string $baseUri, string $apiKey, string $signature): self
    {
        $guzzleClient = new \GuzzleHttp\Client([
            'base_uri' => $baseUri,
            'timeout' => 20,
        ]);
        $clientAdapter = new GuzzleClientAdapter($guzzleClient);
        $signatureCalculator = new Sha256SignatureCalculator($signature);

        return new self($clientAdapter, $apiKey, $signatureCalculator, new GuzzleMessageFactory());
    }

    public static function create(string $apiKey, string $signature)
    {
        return self::template(self::API_URL, $apiKey, $signature);
    }

    public static function sandbox(string $apiKey, string $signature)
    {
        return self::template(self::SANDBOX_URL, $apiKey, $signature);
    }

    public function makePayment(Payment $payment): PaymentResponse
    {
        $request = $this->requestFactory->createRequest(
            'POST',
            '/v1/payments',
            [
                'Api-Key' => $this->apiKey,
                'Signature' => $this->signatureCalculator->calculate($payment->asArray()),
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

    public function paymentStatus(PaymentId $id)
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
