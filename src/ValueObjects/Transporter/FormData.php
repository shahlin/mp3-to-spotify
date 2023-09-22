<?php

namespace Shahlinibrahim\Mp3ToSpotify\ValueObjects\Transporter;


class FormData {

    private function __construct(
        private readonly array $data
    ) {
        // ..
    }

    public static function create() {
        return new self([]);
    }

    public function add(string $key, string $value) {
        return new self([
            ...$this->data,
            $key => $value
        ]);
    }

    public function toArray(): array {
        return $this->data;
    }

}