<?php

declare(strict_types=1);

namespace Shahlinibrahim\Mp3ToSpotify\ValueObjects\Transporter;

use Shahlinibrahim\Mp3ToSpotify\Enums\Transporter\ContentType;
use Shahlinibrahim\Mp3ToSpotify\ValueObjects\AccessToken;
use Shahlinibrahim\Mp3ToSpotify\ValueObjects\ClientId;
use Shahlinibrahim\Mp3ToSpotify\ValueObjects\ClientSecret;

/**
 * @internal
 */
final class Headers
{
    /**
     * Creates a new Headers value object.
     *
     * @param  array<string, string>  $headers
     */
    private function __construct(private readonly array $headers)
    {
        // ..
    }

    /**
     * Creates a new Headers value object
     */
    public static function create(): self
    {
        return new self([]);
    }

    /**
     * Creates a new Headers value object with the given Access token.
     */
    public static function withAuthorization(AccessToken $accessToken): self
    {
        return new self([
            'Authorization' => "Bearer {$accessToken->toString()}",
        ]);
    }

    public static function withBasicAuthorization(ClientId $clientId, ClientSecret $clientSecret): self
    {
        $encodedCredentials = base64_encode($clientId->toString() . ':' . $clientSecret->toString());

        return new self([
            'Authorization' => "Basic {$encodedCredentials}",
        ]);
    }

    /**
     * Creates a new Headers value object, with the given content type, and the existing headers.
     */
    public function withContentType(ContentType $contentType): self
    {
        return new self([
            ...$this->headers,
            'Content-Type' => $contentType->value,
        ]);
    }

    /**
     * Creates a new Headers value object, with the newly added header, and the existing headers.
     */
    public function withCustomHeader(string $name, string $value): self
    {
        return new self([
            ...$this->headers,
            $name => $value,
        ]);
    }

    /**
     * @return array<string, string> $headers
     */
    public function toArray(): array
    {
        return $this->headers;
    }
}