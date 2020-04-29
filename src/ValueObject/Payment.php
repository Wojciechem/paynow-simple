<?php

namespace PaynowSimple\ValueObject;

class Payment implements \JsonSerializable
{
    /** @var Buyer */
    private $buyer;

    /** @var Amount */
    private $amount;

    /** @var Currency */
    private $currency;

    /** @var ExternalId */
    private $externalId;

    /** @var Description */
    private $description;

    public function __construct(
        Amount $amount,
        Currency $currency,
        ExternalId $externalId,
        Description $description,
        Buyer $buyer
    ) {
        $this->buyer = $buyer;
        $this->amount = $amount;
        $this->currency = $currency;
        $this->externalId = $externalId;
        $this->description = $description;
    }

    public static function create(
        int $amount,
        string $currencyCode,
        string $externalId,
        string $description,
        string $email)
    {
        return new self(
            new Amount($amount),
            new Currency($currencyCode),
            new ExternalId($externalId),
            new Description($description),
            new Buyer($email)
        );
    }

    public function asArray(): array
    {
        return [
            'amount' => $this->amount->amount(),
            'currency' => $this->currency->currencyCode(),
            'externalId' => $this->externalId->id(),
            'description' => $this->description->description(),
            'buyer' => $this->buyer->jsonSerialize(),
        ];
    }

    public function externalId(): ExternalId
    {
        return $this->externalId;
    }

    public function jsonSerialize()
    {
        return $this->asArray();
    }
}
