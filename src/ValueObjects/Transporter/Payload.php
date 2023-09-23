<?php

namespace Shahlinibrahim\Mp3ToSpotify\ValueObjects\Transporter;

use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\RequestInterface;
use Shahlinibrahim\Mp3ToSpotify\Enums\Transporter\ContentType;
use Shahlinibrahim\Mp3ToSpotify\Enums\Transporter\Method;
use Shahlinibrahim\Mp3ToSpotify\ValueObjects\ResourceUri;

class Payload {

    /**
     * Creates a new Request value object.
     *
     * @param  array<string, mixed>  $parameters
     */
    private function __construct(
        private readonly ContentType $contentType,
        private readonly Method $method,
        private readonly ResourceUri $uri,
        private readonly FormData $formData,
    ) {
        // ..
    }

    /**
     * Creates a new Payload value object from the given parameters.
     *
     * @param  array<string, mixed>  $parameters
     */
    public static function create(
        string $resource,
        ContentType $contentType = ContentType::JSON,
        FormData $formData = null,
    ): self {
        $formData ??= FormData::create();

        $method = Method::POST;
        $uri = ResourceUri::from($resource);

        return new self($contentType, $method, $uri, $formData);
    }

        /**
     * Creates a new Payload value object
     *
     * @param  array<string, mixed>  $parameters
     */
    public static function retrieve(string $resource): self {
        $contentType = ContentType::JSON;
        $method = Method::GET;
        $uri = ResourceUri::from($resource);

        return new self($contentType, $method, $uri, FormData::create());
    }

    /**
     * Creates a new Psr 7 Request instance.
     */
    public function toRequest(BaseUri $baseUri, Headers $headers): RequestInterface
    {
        $uri = $baseUri->toString() . $this->uri->toString();
        $headers = $headers->withContentType($this->contentType);

        $request = new Request(
            $this->method->value,
            $uri,
            $headers->toArray(),
            http_build_query($this->formData->toArray())
        );

        return $request;
    }

}
