<?php

namespace Shahlinibrahim\Mp3ToSpotify\Transporter;

use Closure;
use JsonException;
use GuzzleHttp\ClientInterface;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Message\ResponseInterface;
use Shahlinibrahim\Mp3ToSpotify\Enums\Transporter\ContentType;
use Shahlinibrahim\Mp3ToSpotify\Exceptions\ErrorException;
use Shahlinibrahim\Mp3ToSpotify\Exceptions\TransporterException;
use Shahlinibrahim\Mp3ToSpotify\Exceptions\UnserializableResponse;
use Shahlinibrahim\Mp3ToSpotify\ValueObjects\Transporter\BaseUri;
use Shahlinibrahim\Mp3ToSpotify\ValueObjects\Transporter\Headers;
use Shahlinibrahim\Mp3ToSpotify\ValueObjects\Transporter\Payload;
use Shahlinibrahim\Mp3ToSpotify\ValueObjects\Transporter\Response;

class HttpTransporter {

    public function __construct(
        private readonly ClientInterface $client,
        private readonly BaseUri $baseUri
    ) {
        // ..
    }
    
    public function requestObject(Payload $payload, Headers $headers = null): Response
    {
        $headers ??= Headers::create();
        $request = $payload->toRequest($this->baseUri, $headers);

        $response = $this->sendRequest(fn (): ResponseInterface => $this->client->send($request));
        $contents = $response->getBody()->getContents();

        if (str_contains($response->getHeaderLine('Content-Type'), ContentType::JSON->value)) {
            return Response::from($response->getBody(), $response->getHeaders());
        }

        $this->throwIfJsonError($response, $contents);

        return Response::from($response->getBody(), $response->getHeaders());
    }

    private function sendRequest(Closure $callable): ResponseInterface
    {
        try {
            return $callable();
        } catch (ClientExceptionInterface $clientException) {
            throw new TransporterException($clientException);
        }
    }

    private function throwIfJsonError(ResponseInterface $response, string|ResponseInterface $contents): void
    {
        if ($response->getStatusCode() < 400) {
            return;
        }

        if (! str_contains($response->getHeaderLine('Content-Type'), ContentType::JSON->value)) {
            return;
        }

        if ($contents instanceof ResponseInterface) {
            $contents = $contents->getBody()->getContents();
        }

        try {
            /** @var array{error?: array{message: string|array<int, string>, type: string, code: string}} $response */
            $response = json_decode($contents, true, 512, JSON_THROW_ON_ERROR);

            if (isset($response['error'])) {
                throw new ErrorException($response['error']);
            }
        } catch (JsonException $jsonException) {
            throw new UnserializableResponse($jsonException);
        }
    }

}