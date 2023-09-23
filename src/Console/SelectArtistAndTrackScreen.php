<?php

namespace Shahlinibrahim\Mp3ToSpotify\Console;

use Shahlinibrahim\Mp3ToSpotify\Concerns\Data;
use Shahlinibrahim\Mp3ToSpotify\Concerns\ReadsLocalTracks;
use Shahlinibrahim\Mp3ToSpotify\Concerns\ShouldProceed;
use Shahlinibrahim\Mp3ToSpotify\Contracts\ConsoleScreen;
use Shahlinibrahim\Mp3ToSpotify\Exceptions\EmptyFolderException;
use Shahlinibrahim\Mp3ToSpotify\Exceptions\SeparatorNotFoundInNameException;

use function Laravel\Prompts\confirm;
use function Laravel\Prompts\info;
use function Laravel\Prompts\error;

class SelectArtistAndTrackScreen implements ConsoleScreen {

    use Data, ShouldProceed, ReadsLocalTracks;

    public function display() {
        try {
            $fileName = $this->readSingleTrackFileName($this->path());
        } catch (EmptyFolderException $e) {
            error($e->getMessage());
            $this->shouldNotProceed();
            return;
        }

        try {
            $leftToken = $this->getLeftToken($fileName, $this->separator());
            $rightToken = $this->getRightToken($fileName, $this->separator());
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

}