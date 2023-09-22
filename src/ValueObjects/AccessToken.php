<?php

declare(strict_types=1);

namespace Shahlinibrahim\Mp3ToSpotify\ValueObjects;
use Shahlinibrahim\Mp3ToSpotify\Contracts\StringableContract;

/**
 * @internal
 */
final class AccessToken implements StringableContract
{
    /**
     * Creates a new Access token value object.
     */
    private function __construct(public readonly string $accessToken)
    {
        // ..
    }

    public static function from(string $accessToken): self
    {
        return new self($accessToken);
    }

    /**
     * {@inheritdoc}
     */
    public function toString(): string
    {
        return $this->accessToken;
    }
}