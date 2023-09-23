<?php

namespace Shahlinibrahim\Mp3ToSpotify\Console;

use Shahlinibrahim\Mp3ToSpotify\Concerns\Data;
use Shahlinibrahim\Mp3ToSpotify\Concerns\ReadsLocalTracks;
use Shahlinibrahim\Mp3ToSpotify\Concerns\ShouldProceed;
use Shahlinibrahim\Mp3ToSpotify\Contracts\ConsoleScreen;
use Shahlinibrahim\Mp3ToSpotify\Exceptions\EmptyFolderException;
use Shahlinibrahim\Mp3ToSpotify\Exceptions\PathNotFoundException;
use Shahlinibrahim\Mp3ToSpotify\Exceptions\SeparatorNotFoundInNameException;

use function Laravel\Prompts\confirm;
use function Laravel\Prompts\info;
use function Laravel\Prompts\error;

class SelectArtistAndTrackScreen implements ConsoleScreen {

    use Data, ShouldProceed, ReadsLocalTracks;

    public function display() {
        try {
            $trackName = $this->readOneTrackName($this->path());
        } catch (EmptyFolderException $e) {
            error($e->getMessage());
            $this->shouldNotProceed();
            return;
        }

        try {
            $leftToken = $this->getLeftToken($trackName);
            $rightToken = $this->getRightToken($trackName);
        } catch (SeparatorNotFoundInNameException $e) {
            error($e->getMessage());
            $this->shouldNotProceed();
            return;
        }

        info("The Artist is: {$leftToken}");
        info("The Track is: {$rightToken}");

        $orderIsCorrect = confirm(
            label: "Is the above information correct?",
            yes: "Yes, it is",
            no: "No, it's the opposite"
        );

        $this->setArtistNameLeftSide(true);
        if (!$orderIsCorrect) {
            $this->setArtistNameLeftSide(false);
        }

        $this->shouldProceed();
    }

    private function getLeftToken(string $trackName): string {
        return $this->getAllTokensFromTrackName($trackName)[0];
    }

    private function getRightToken(string $trackName): string {
        return $this->getAllTokensFromTrackName($trackName)[1];
    }

    private function getAllTokensFromTrackName(string $trackName): array {
        $tokens = explode($this->separator(), $trackName);

        if (empty($tokens) || count($tokens) < 2) {
            throw new SeparatorNotFoundInNameException("Naming separation not found in track name: " . $trackName);
        }

        return $tokens;
    }

}