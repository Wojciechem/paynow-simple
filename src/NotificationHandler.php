<?php

declare(strict_types=1);

namespace PaynowSimple;

use PaynowSimple\Exception\InvalidSignature;
use PaynowSimple\ValueObject\Notification\PaymentStatusNotification;

final class NotificationHandler
{
    /** @var SignatureCalculator */
    private $calculator;

    public function __construct(SignatureCalculator $calculator)
    {
        $this->calculator = $calculator;
    }

    public static function create(string $signatureKey): self
    {
        return new self(new Sha256SignatureCalculator($signatureKey));
    }

    /** @return void */
    public function handle()
    {
        $notification = PaymentStatusNotification::createFromGlobals();

        $calculatedSignature = $this->calculator->calculate($notification->asArray());

        if ($calculatedSignature !== $notification->signature()) {
            throw new InvalidSignature('Notification signature does not match calculated signature!');
        }
    }
}
