<?php

namespace Shahlinibrahim\Mp3ToSpotify\Console;

use Shahlinibrahim\Mp3ToSpotify\Concerns\Data;
use Shahlinibrahim\Mp3ToSpotify\Concerns\ShouldProceed;
use Shahlinibrahim\Mp3ToSpotify\Contracts\ConsoleScreen;
use Shahlinibrahim\Mp3ToSpotify\Resources\Playlist;
use Shahlinibrahim\Mp3ToSpotify\ValueObjects\PlaylistId;

use function Laravel\Prompts\select;

class SelectPlaylistScreen implements ConsoleScreen {

    use Data, ShouldProceed;

    public function display() {
        $playlistId = select(
            label: 'Which playlist do you want to save the songs to?',
            options: $this->getPlaylists()
        );

        $this->setPlaylistId(PlaylistId::from($playlistId));
        $this->shouldProceed();
    }

    private function getPlaylists(): array {
        $playlist = Playlist::fromAccessToken($this->accessToken());
        $playlistList = [];

        foreach ($playlist->list() as $playlist) {
            $playlistList[$playlist->id()] = $playlist->name();
        }

        return $playlistList;
    }

}