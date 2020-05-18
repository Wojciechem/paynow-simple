<?php

namespace PaynowSimple;

use Http\Message\RequestFactory;
use PHPUnit\Framework\TestCase;

/**
 * @covers \PaynowSimple\ClientFactory
 *
 * @uses \PaynowSimple\Client
 */
class ClientFactoryTest extends TestCase
{
    public function testCreateClient()
    {
        $httpClient = new \Http\Mock\Client();
        $requestFactory = $this->createMock(RequestFactory::class);
        $factory = new ClientFactory($httpClient, $requestFactory);

        $client = $factory->create('apikey', 'signaturekey');

        $this->assertInstanceOf(Client::class, $client);
    }

    public function testCreateDefault()
    {
        $factory = ClientFactory::default();
        $client = $factory->create('apikey', 'signaturekey');

        $this->assertInstanceOf(ClientFactory::class, $factory);
        $this->assertInstanceOf(Client::class, $client);
    }

    public function testCreateSandbox()
    {
        $factory = ClientFactory::sandbox();
        $client = $factory->create('apikey', 'signaturekey');

        $this->assertInstanceOf(ClientFactory::class, $factory);
        $this->assertInstanceOf(Client::class, $client);
    }
}
