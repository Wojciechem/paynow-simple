<?php

namespace PaynowSimple;

interface SignatureCalculator
{
    public function calculate(array $data): string;
}
