<?php

namespace PaynowSimple;

interface SignatureCalculator
{
    public static function calculate(string $signatureKey, array $data): string;
}
