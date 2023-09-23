<?php

namespace Shahlinibrahim\Mp3ToSpotify\Responses\Search;

use Shahlinibrahim\Mp3ToSpotify\Responses\Track\TrackResponse;

class SearchResponse {

    private function __construct(private readonly array $list) {}

    public static function fromJson(string $json) {
        $obj = json_decode($json);
        $list = [];

        foreach ($obj->tracks->items as $track) {
            $list[] = TrackResponse::from($track->name, $track->uri);
        }

        return new self($list);
    }

    public function list(): array {
        return $this->list;
    }

}