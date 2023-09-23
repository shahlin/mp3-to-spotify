<?php

declare(strict_types=1);

namespace Shahlinibrahim\Mp3ToSpotify\ValueObjects;
use Shahlinibrahim\Mp3ToSpotify\Contracts\StringableContract;

/**
 * @internal
 */
final class AuthCode implements StringableContract
{
    /**
     * Creates a new Auth Code value object.
     */
    private function __construct(public readonly string $authCode)
    {
        // ..
    }

    public static function from(string $authCode): self
    {
        return new self($authCode);
    }

    /**
     * {@inheritdoc}
     */
    public function toString(): string
    {
        return $this->authCode;
    }
}