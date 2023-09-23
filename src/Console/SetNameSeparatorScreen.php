<?php

namespace Shahlinibrahim\Mp3ToSpotify\Console;

use Shahlinibrahim\Mp3ToSpotify\Concerns\Data;
use Shahlinibrahim\Mp3ToSpotify\Concerns\ShouldProceed;
use Shahlinibrahim\Mp3ToSpotify\Contracts\ConsoleScreen;
use function Laravel\Prompts\text;

class SetNameSeparatorScreen implements ConsoleScreen {

    use Data, ShouldProceed;

    public function display() {
        $separator = $_ENV['LOCAL_TRACK_NAMES_SEPARATOR'] ?? text("How are the artists and tracks separated in the file names? Example: ' - ', '-'");

        $this->setSeparator($separator);
        $this->shouldProceed();
    }

}