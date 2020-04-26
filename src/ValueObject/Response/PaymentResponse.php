<?php

namespace PaynowSimple\ValueObject\Response;

use PaynowSimple\Exception\InvalidArgument;
use Psr\Http\Message\ResponseInterface;

class PaymentResponse
{
    private $content;

    public function __construct(ResponseInterface $response)
    {
        $this->content = json_decode($response->getBody()->getContents(), true);

        if (null === $this->content) {
            throw new InvalidArgument('Empty response from Paynow API');
        }
    }

    public function paymentId() : string
    {
        return $this->content['paymentId'];
    }

    public function status() : string
    {
        return $this->content['status'];
    }

    public function redirectUrl() : ?string
    {
        if (array_key_exists('redirectUrl', $this->content)) {
            return $this->content['redirectUrl'];
        }

        return null;
    }
}