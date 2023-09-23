<?php

namespace Shahlinibrahim\Mp3ToSpotify\Responses\Playlist;


class PlaylistResponse {

    public function __construct(
        private readonly string $id,
        private readonly string $name,
    ) {}

    public function id(): string {
        return $this->id;
    }

    public function name(): string {
        return $this->name;
    }

}