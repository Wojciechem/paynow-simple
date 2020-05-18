<?php

namespace PaynowSimple;

use Http\Adapter\Guzzle6\Client as GuzzleClientAdapter;
use Http\Message\MessageFactory\GuzzleMessageFactory;
use Http\Message\RequestFactory;
use Psr\Http\Client\ClientInterface;

class ClientFactory
{
    private const API_URL = 'https://api.paynow.pl';
    private const SANDBOX_URL = 'https://api.sandbox.paynow.pl';

    private $client;
    private $requestFactory;

    public function __construct(ClientInterface $httpClient, RequestFactory $requestFactory)
    {
        $this->client = $httpClient;
        $this->requestFactory = $requestFactory;
    }

    public static function default(): self
    {
        $guzzleClient = new \GuzzleHttp\Client([
            'base_uri' => self::API_URL,
            'timeout' => 20,
        ]);
        $clientAdapter = new GuzzleClientAdapter($guzzleClient);

        return new self(
            $clientAdapter,
            new GuzzleMessageFactory()
        );
    }

    public static function sandbox(): self
    {
        $guzzleClient = new \GuzzleHttp\Client([
            'base_uri' => self::SANDBOX_URL,
            'timeout' => 20,
        ]);
        $clientAdapter = new GuzzleClientAdapter($guzzleClient);

        return new self(
            $clientAdapter,
            new GuzzleMessageFactory()
        );
    }

    public function create(string $apiKey, string $signatureKey): Client
    {
        return new Client($this->client, $apiKey, $signatureKey, $this->requestFactory);
    }
}
