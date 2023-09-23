<?php

namespace Shahlinibrahim\Mp3ToSpotify\Console;

use Shahlinibrahim\Mp3ToSpotify\Concerns\Data;
use Shahlinibrahim\Mp3ToSpotify\Concerns\ShouldProceed;
use Shahlinibrahim\Mp3ToSpotify\Contracts\ConsoleScreen;
use function Laravel\Prompts\confirm;
use function Laravel\Prompts\info;
use function Laravel\Prompts\table;
use function Laravel\Prompts\warning;

class WelcomeScreen implements ConsoleScreen {

    use Data, ShouldProceed;

    public function display() {
        info("Welcome! Before you proceed, make sure you have the following information:");

        table(
            [ '#', 'Pre-requisites' ],
            [
                [ 1, "Spotify Developer Account", "https://developer.spotify.com/dashboard" ],
                [ 2, "An App created on the Dashboard (Redirect URI doesn't matter)", "https://developer.spotify.com/dashboard/create" ],
                [ 3, "Client ID & Secret" ],
                [ 4, "Folder with MP3 Files with Artist & Track names", "Example: Bob Dylan - Desolation Row.mp3" ],
            ]
        );

        $confirm = confirm("Do you have all the pre-requisites listed above?");

        if (!$confirm) {
            warning("Hope to see you back when you've got all the information!");
            $this->shouldNotProceed();
            return;
        }

        $this->shouldProceed();
    }

}