<?php

declare(strict_types=1);

namespace Shahlinibrahim\Mp3ToSpotify\ValueObjects\Transporter;

/**
 * @internal
 */
class Response
{
    private function __construct(
        private readonly array|string $data,
        private readonly Headers $headers,
    ) {
        // ..
    }

    public static function from(array|string $data, array $rawHeaders = []): self
    {
        $headers = Headers::create();

        foreach ($rawHeaders as $key => $value) {
            if (is_array($value) && count($value) > 1) { continue; }

            if (is_array($value) && count($value) === 1) {
                $value = $value[0];
            }

            $headers->withCustomHeader($key, $value);
        }

        return new self($data, $headers);
    }

    public function data(): array|string
    {
        return $this->data;
    }

}