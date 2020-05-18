<?php

namespace PaynowSimple\ValueObject\Response;

use PaynowSimple\Exception\InvalidArgument;
use Psr\Http\Message\ResponseInterface;

final class PaymentStatus
{
    /** @var array */
    private $content;

    public function __construct(ResponseInterface $response)
    {
        $this->content = (array) \json_decode($response->getBody()->getContents(), true);

        if ([] === $this->content) {
            throw new InvalidArgument('Empty response from Paynow API');
        }

        if (false === \array_key_exists('paymentId', $this->content)) {
            throw new InvalidArgument('missing paymentId in response');
        }

        if (false === \array_key_exists('status', $this->content)) {
            throw new InvalidArgument('missing status in response');
        }
    }

    public function paymentId(): string
    {
        return (string) $this->content['paymentId'];
    }

    public function status(): string
    {
        return (string) $this->content['status'];
    }
}
