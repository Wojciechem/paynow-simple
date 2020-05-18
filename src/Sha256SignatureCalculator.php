<?php

namespace PaynowSimple;

final class Sha256SignatureCalculator implements SignatureCalculator
{
    public static function calculate(string $signatureKey, array $data): string
    {
        return \base64_encode(\hash_hmac('sha256', \json_encode($data), $signatureKey, true));
    }
}
