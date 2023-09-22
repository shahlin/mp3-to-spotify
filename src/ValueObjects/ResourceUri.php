<?php

declare(strict_types=1);

namespace Shahlinibrahim\Mp3ToSpotify\ValueObjects;

use Shahlinibrahim\Mp3ToSpotify\Contracts\StringableContract;

/**
 * @internal
 */
final class ResourceUri implements StringableContract
{
    /**
     * Creates a new ResourceUri value object.
     */
    private function __construct(private readonly string $uri)
    {
        // ..
    }

    /**
     * Creates a new ResourceUri value object that creates the given resource.
     */
    public static function create(string $resource): self
    {
        return new self($resource);
    }

    /**
     * Creates a new ResourceUri value object that retrieves the given resource.
     */
    // public static function retrieve(string $resource, string $id, string $suffix): self
    // {
    //     // return new self("{$resource}/{$id}{$suffix}");
    // }

    /**
     * {@inheritDoc}
     */
    public function toString(): string
    {
        return $this->uri;
    }
}