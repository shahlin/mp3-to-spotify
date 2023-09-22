<?php

declare(strict_types=1);

namespace Shahlinibrahim\Mp3ToSpotify\ValueObjects;
use Shahlinibrahim\Mp3ToSpotify\Contracts\StringableContract;

/**
 * @internal
 */
final class ClientSecret implements StringableContract
{
    /**
     * Creates a new Client Secret value object.
     */
    private function __construct(public readonly string $clientSecret)
    {
        // ..
    }

    public static function from(string $clientSecret): self
    {
        return new self($clientSecret);
    }

    /**
     * {@inheritdoc}
     */
    public function toString(): string
    {
        return $this->clientSecret;
    }
}