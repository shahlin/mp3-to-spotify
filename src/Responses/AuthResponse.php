<?php

namespace Shahlinibrahim\Mp3ToSpotify\Responses;

use Shahlinibrahim\Mp3ToSpotify\ValueObjects\AccessToken;

class AuthResponse {

    private function __construct(
        private readonly AccessToken $accessToken,
        private readonly string $tokenType,
        private readonly int $expiresIn,
    ) {
        // ..
    }

    public static function fromJson(string $json) {
        $obj = json_decode($json);

        return new self(AccessToken::from($obj->access_token), $obj->token_type, $obj->expires_in);
    }

    public function accessToken(): AccessToken {
        return $this->accessToken;
    }

}