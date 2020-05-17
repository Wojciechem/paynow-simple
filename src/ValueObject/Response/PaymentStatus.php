<?php

namespace PaynowSimple\ValueObject\Response;

use PaynowSimple\Exception\InvalidArgument;
use Psr\Http\Message\ResponseInterface;

final class PaymentStatus
{
    private $content;

    public function __construct(ResponseInterface $response)
    {
        $this->content = json_decode($response->getBody()->getContents(), true);

        if (null === $this->content) {
            throw new InvalidArgument('Empty response from Paynow API');
        }
    }

    public function paymentId()
    {
        return $this->content['paymentId'];
    }

    public function status()
    {
        return $this->content['status'];
    }
}
