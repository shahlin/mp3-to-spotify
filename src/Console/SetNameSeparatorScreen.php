<?php

namespace Shahlinibrahim\Mp3ToSpotify\Console;

use Shahlinibrahim\Mp3ToSpotify\Concerns\Data;
use Shahlinibrahim\Mp3ToSpotify\Concerns\ShouldProceed;
use Shahlinibrahim\Mp3ToSpotify\Contracts\ConsoleScreen;
use Shahlinibrahim\Mp3ToSpotify\Exceptions\PathNotFoundException;
use function Laravel\Prompts\text;

class SetNameSeparatorScreen implements ConsoleScreen {

    use Data, ShouldProceed;

    public function display() {
        $separator = text("How are the artists and tracks separated in the file names? Example: ' - ', '-'");

        $this->setSeparator($separator);
        $this->shouldProceed();
    }

    private function validatePath(String $path) {
        if (!file_exists($path) || !is_dir( $path ) ) {
            throw new PathNotFoundException("Given path does not exist");
        } 
    }

}