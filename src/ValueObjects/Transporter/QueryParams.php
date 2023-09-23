<?php

namespace Shahlinibrahim\Mp3ToSpotify\ValueObjects\Transporter;

use Shahlinibrahim\Mp3ToSpotify\Contracts\StringableContract;

class QueryParams implements StringableContract {

    private function __construct(
        private readonly array $params
    ) {
        // ..
    }

    public static function create() {
        return new self([]);
    }

    public function add(string $key, string $value) {
        return new self([
            ...$this->params,
            $key => $value
        ]);
    }

    public function toArray(): array {
        return $this->params;
    }

    public function toString(): String {
        return http_build_query($this->params);
    }

}