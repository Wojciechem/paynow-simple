<?php

namespace PaynowSimple;

final class Sha256SignatureCalculator implements SignatureCalculator
{
    private $signatureKey;

    public function __construct(string $signatureKey)
    {
        $this->signatureKey = $signatureKey;
    }

    public function calculate(array $data): string
    {
        return \base64_encode(\hash_hmac('sha256', \json_encode($data), $this->signatureKey, true));
    }
}
