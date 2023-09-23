<?php

namespace Shahlinibrahim\Mp3ToSpotify\Responses\Track;

class TrackResponse {

    private function __construct(
        private readonly string $name,
        private readonly string $uri
    ) {}

    public static function from(string $name, string $uri): self {
        return new self($name, $uri);
    }

    public function name(): string {
        return $this->name;
    }

    public function uri(): string {
        return $this->uri;
    }

}