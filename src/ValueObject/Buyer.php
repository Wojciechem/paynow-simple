<?php

namespace PaynowSimple\ValueObject;

class Buyer implements \JsonSerializable
{
    private $email;
    private $firstName;
    private $lastName;
    /** @var Phone */
    private $phone;

    public function __construct(string $email)
    {
        $this->email = $email;
    }

    public function addFirstName(string $firstName): Buyer
    {
        $buyer = clone $this;
        $buyer->firstName = $firstName;

        return $buyer;
    }

    public function addLastName(string $lastName): Buyer
    {
        $buyer = clone $this;
        $buyer->lastName = $lastName;

        return $buyer;
    }

    public function addPhone(Phone $phone): Buyer
    {
        $buyer = clone $this;
        $buyer->phone = $phone;

        return $buyer;
    }

    public function jsonSerialize()
    {
        $serialized = ['email' => $this->email];

        if ($this->firstName) {
            $serialized['firstName'] = $this->firstName;
        }

        if ($this->lastName) {
            $serialized['lastName'] = $this->lastName;
        }

        if ($this->phone) {
            $serialized['phone'] = [
                'prefix' => $this->phone->prefix(),
                'number' => $this->phone->number(),
            ];
        }

        return $serialized;
    }
}
