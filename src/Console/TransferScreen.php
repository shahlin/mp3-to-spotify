<?php

namespace Shahlinibrahim\Mp3ToSpotify\Console;

use Shahlinibrahim\Mp3ToSpotify\Concerns\Data;
use Shahlinibrahim\Mp3ToSpotify\Concerns\ReadsLocalTracks;
use Shahlinibrahim\Mp3ToSpotify\Concerns\ShouldProceed;
use Shahlinibrahim\Mp3ToSpotify\Contracts\ConsoleScreen;
use Shahlinibrahim\Mp3ToSpotify\Logger;
use Shahlinibrahim\Mp3ToSpotify\Resources\Playlist;
use Shahlinibrahim\Mp3ToSpotify\Resources\Search;
use function Laravel\Prompts\confirm;
use function Laravel\Prompts\info;
use function Laravel\Prompts\error;
use function Laravel\Prompts\spin;
use function Laravel\Prompts\outro;
use function Laravel\Prompts\warning;

class TransferScreen implements ConsoleScreen {

    use Data, ShouldProceed, ReadsLocalTracks;

    public function display() {
        $start = confirm("Start transfer process?");

        if (!$start) {
            warning("Come back when you're ready!");
            $this->shouldNotProceed();
            return;
        }

        $trackUris = $this->searchTracks();

        $addConfirmation = confirm("Add " . count($trackUris) . " tracks to selected playlist?");

        if (!$addConfirmation) {
            warning("Until next time!");
            $this->shouldNotProceed();
            return;
        }

        spin(
            fn() => $this->addTracksToPlaylist($trackUris),
            "Adding tracks to playlist..."
        );

        outro("Successfully completed the transfer!");
        $this->shouldProceed();
    }

    private function searchTracks(): array {
        $uris = [];
        $search = Search::fromAccessToken($this->accessToken());
        $localTracks = $this->getLocalTracks(
            $this->path(),
            $this->separator(),
            $this->artistNameLeftSide()
        );

        $notFoundCount = 0;
        foreach ($localTracks as $i => $localTrack) {
            info(($i + 1) . ". Searching for: {$localTrack->toString()}");
            $foundTracks = $search->search($localTrack->artistName(), $localTrack->trackName());

            if (empty($foundTracks)) {
                error("Track not found");
                Logger::warning("No Spotify tracks found for " . $localTrack->toString());
                $notFoundCount++;
                continue;
            }

            $trackToUse = $foundTracks[0];

            Logger::info("Found Spotify track with name: " . $trackToUse->name());
            $uris[] = $trackToUse->uri();
        }

        info("Found " . (count($localTracks) - $notFoundCount) . "/" . count($localTracks) . " tracks");

        return $uris;
    }

    private function addTracksToPlaylist(array $trackUris) {
        $playlist = Playlist::fromAccessToken($this->accessToken());

        $playlist->add($this->playlistId(), $trackUris);
    }

}