<?php

namespace Shahlinibrahim\Mp3ToSpotify\Responses\Playlist;
use Shahlinibrahim\Mp3ToSpotify\Responses\Playlist\PlaylistResponse;


class ListResponse {

    private function __construct(private readonly array $list) {}

    public static function fromJson(string $json) {
        $obj = json_decode($json);
        $list = [];

        foreach ($obj->items as $item) { 
            $list[] = new PlaylistResponse($item->id, $item->name);
        }

        return new self($list);
    }

    public function list(): array {
        return $this->list;
    }

}