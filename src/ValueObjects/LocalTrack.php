<?php

declare(strict_types=1);

namespace Shahlinibrahim\Mp3ToSpotify\ValueObjects;

use Shahlinibrahim\Mp3ToSpotify\Contracts\StringableContract;

/**
 * @internal
 */
final class LocalTrack implements StringableContract
{
    /**
     * Creates a new Local Track value object.
     */
    private function __construct(public readonly string $artistName, public readonly string $trackName)
    {
        // ..
    }

    public static function from(string $artistName, string $trackName): self
    {
        return new self($artistName, $trackName);
    }

    public function artistName(): string {
        return $this->artistName;
    }

    public function trackName(): string {
        return $this->trackName;
    }

    public function toString(): string {
        return "Artist: {$this->artistName}, Track: {$this->trackName}";
    }

}