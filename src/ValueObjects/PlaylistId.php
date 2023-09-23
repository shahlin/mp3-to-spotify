<?php

declare(strict_types=1);

namespace Shahlinibrahim\Mp3ToSpotify\ValueObjects;
use Shahlinibrahim\Mp3ToSpotify\Contracts\StringableContract;

/**
 * @internal
 */
final class PlaylistId implements StringableContract
{
    /**
     * Creates a new Playlist Id value object.
     */
    private function __construct(public readonly string $playlistId)
    {
        // ..
    }

    public static function from(string $playlistId): self
    {
        return new self($playlistId);
    }

    /**
     * {@inheritdoc}
     */
    public function toString(): string
    {
        return $this->playlistId;
    }
}