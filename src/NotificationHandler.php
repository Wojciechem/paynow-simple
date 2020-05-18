<?php

declare(strict_types=1);

namespace PaynowSimple;

use PaynowSimple\Exception\InvalidSignature;
use PaynowSimple\ValueObject\Notification\PaymentStatusNotification;

final class NotificationHandler
{
    private $signatureKey;

    public function __construct(string $signatureKey)
    {
        $this->signatureKey = $signatureKey;
    }

    /**
     * @return void
     *
     * @throws InvalidSignature
     */
    public function handle()
    {
        $notification = PaymentStatusNotification::createFromGlobals();

        $calculatedSignature = Sha256SignatureCalculator::calculate($this->signatureKey, $notification->asArray());

        if ($calculatedSignature !== $notification->signature()) {
            throw new InvalidSignature('Notification signature does not match calculated signature!');
        }
    }
}
