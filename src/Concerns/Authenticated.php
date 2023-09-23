<?php

namespace Shahlinibrahim\Mp3ToSpotify\Concerns;
use Shahlinibrahim\Mp3ToSpotify\ValueObjects\AccessToken;

trait Authenticated {

    private AccessToken $accessToken;

    public static function fromAccessToken(AccessToken $accessToken): static {
        $self = new static;
        $self->setAccessToken($accessToken);

        return $self;
    }

    private function setAccessToken(AccessToken $accessToken) {
        $this->accessToken = $accessToken;
    }

    private function accessToken(): AccessToken {
        return $this->accessToken;
    }

}