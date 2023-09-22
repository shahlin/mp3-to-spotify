<?php

declare(strict_types=1);

namespace Shahlinibrahim\Mp3ToSpotify\ValueObjects;
use Shahlinibrahim\Mp3ToSpotify\Contracts\StringableContract;

/**
 * @internal
 */
final class ClientId implements StringableContract
{
    /**
     * Creates a new Client Id value object.
     */
    private function __construct(public readonly string $clientId)
    {
        // ..
    }

    public static function from(string $clientId): self
    {
        return new self($clientId);
    }

    /**
     * {@inheritdoc}
     */
    public function toString(): string
    {
        return $this->clientId;
    }
}