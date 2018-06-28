<?php

namespace Demv\Smtp\Discovery;

class EmailAddress
{
    /**
     * @var string
     */
    private $address;

    /**
     * Email constructor.
     *
     * @param string $address
     */
    public function __construct(string $address)
    {
        $this->address = $address;
    }

    /**
     * @return EmailAddress
     */
    public static function create(string $address): self
    {
        return new self($address);
    }

    /**
     * @return string
     */
    public function extractDomain(): string
    {
        if (!filter_var($this->address, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException('Invalid Email-Address');
        }

        $exploded = explode('@', $this->address);

        return $exploded[1];
    }
}