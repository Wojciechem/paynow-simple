<?php

declare(strict_types=1);

namespace PaynowSimple\ValueObject\Notification;

use PaynowSimple\Exception\InvalidArgument;
use PaynowSimple\ValueObject\ExternalId;
use PaynowSimple\ValueObject\PaymentId;

class PaymentStatusNotification
{
    /** @var string */
    private $signature;

    /** @var PaymentId */
    private $paymentId;

    /** @var ExternalId */
    private $externalId;

    /** @var string */
    private $status;

    /** @var string */
    private $modifiedAt;

    public function __construct(
        string $signature,
        PaymentId $paymentId,
        ExternalId $externalId,
        string $status,
        string $modifiedAt
    ) {
        $this->signature = $signature;
        $this->paymentId = $paymentId;
        $this->status = $status;
        $this->modifiedAt = $modifiedAt;
        $this->externalId = $externalId;
    }

    public static function createFromGlobals(): self
    {
        if (false === isset($_SERVER['HTTP_SIGNATURE'])) {
            throw new InvalidArgument('Missing Signature header in received notification');
        }

        $content = file_get_contents('php://input');
        $data = (array) \json_decode($content, true);

        if ([] === $data) {
            throw new InvalidArgument('Invalid JSON payload in received notification');
        }

        if (false === \array_key_exists('paymentId', $data)) {
            throw new InvalidArgument('missing paymentId');
        }

        if (false === \array_key_exists('externalId', $data)) {
            throw new InvalidArgument('missing externalId');
        }

        if (false === \array_key_exists('status', $data)) {
            throw new InvalidArgument('missing status');
        }

        if (false === \array_key_exists('modifiedAt', $data)) {
            throw new InvalidArgument('missing modifiedAt');
        }

        return new self(
            (string) $_SERVER['HTTP_SIGNATURE'],
            new PaymentId((string) $data['paymentId']),
            new ExternalId((string) $data['externalId']),
            (string) $data['status'],
            (string) $data['modifiedAt']
        );
    }

    public function signature(): string
    {
        return $this->signature;
    }

    public function paymentId(): PaymentId
    {
        return $this->paymentId;
    }

    public function externalId(): ExternalId
    {
        return $this->externalId;
    }

    public function status(): string
    {
        return $this->status;
    }

    public function modifiedAt(): string
    {
        return $this->modifiedAt;
    }

    public function asArray(): array
    {
        return [
            'paymentId' => $this->paymentId,
            'externalId' => $this->externalId,
            'status' => $this->status,
            'modifiedAt' => $this->modifiedAt,
        ];
    }
}
