<?php

declare(strict_types=1);

namespace Shahlinibrahim\Mp3ToSpotify\ValueObjects;

use Shahlinibrahim\Mp3ToSpotify\Contracts\StringableContract;
use Shahlinibrahim\Mp3ToSpotify\ValueObjects\Transporter\QueryParams;

/**
 * @internal
 */
final class ResourceUri implements StringableContract
{

    private readonly QueryParams $queryParams;

    /**
     * Creates a new ResourceUri value object.
     */
    private function __construct(
        private readonly string $uri,
    ) {
        // ..
    }

    /**
     * Creates a new ResourceUri value object
     */
    public static function from(string $resource): self
    {
        return new self($resource);
    }

    public static function fromQueryParams(string $resource, QueryParams $queryParams): self {
        $uri = new self($resource);
        $uri->setQueryParams($queryParams);

        return $uri;
    }

    /**
     * {@inheritDoc}
     */
    public function toString(): string
    {
        $queryParams = "";
        if (isset($this->queryParams)) {
            $queryParams = $this->queryParams->toString();
        }

        return $this->uri . '?' . $queryParams;
    }

    public function setQueryParams(QueryParams $queryParams) {
        $this->queryParams = $queryParams;
    }
}