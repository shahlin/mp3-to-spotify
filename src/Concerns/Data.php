<?php

namespace Shahlinibrahim\Mp3ToSpotify\Concerns;

use Shahlinibrahim\Mp3ToSpotify\ValueObjects\AccessToken;

trait Data {

    private AccessToken $accessToken;
    private string $path;
    private string $separator;
    private bool $artistNameLeftSide;

    public function accessToken(): AccessToken {
        return $this->accessToken;
    }

    public function setAccessToken(AccessToken $accessToken) {
        $this->accessToken = $accessToken;
    }

    public function path() {
        return $this->path;
    }

    public function setPath(string $path) {
        $this->path = $path;
    }

    public function separator() {
        return $this->separator;
    }

    public function setSeparator(string $separator) {
        $this->separator = $separator;
    }

    public function artistNameLeftSide() {
        return $this->artistNameLeftSide;
    }

    public function setArtistNameLeftSide(bool $artistNameLeftSide) {
        $this->artistNameLeftSide = $artistNameLeftSide;
    }

}