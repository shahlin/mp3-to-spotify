<?php

namespace Shahlinibrahim\Mp3ToSpotify\Concerns;

use Shahlinibrahim\Mp3ToSpotify\ValueObjects\AccessToken;

trait Data {

    private array $data = [];
    private AccessToken $accessToken;

    public function data(): array {
        return $this->data;
    }

    public function accessToken(): AccessToken {
        return $this->accessToken;
    }

    public function setAccessToken(AccessToken $accessToken) {
        $this->accessToken = $accessToken;
    }

}