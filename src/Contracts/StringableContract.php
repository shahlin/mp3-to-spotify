<?php

declare(strict_types=1);

namespace Shahlinibrahim\Mp3ToSpotify\Contracts;

/**
 * @internal
 */
interface StringableContract
{
    /**
     * Returns the string representation of the object.
     */
    public function toString(): string;
}