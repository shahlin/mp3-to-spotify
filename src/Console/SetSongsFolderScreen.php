<?php

namespace Shahlinibrahim\Mp3ToSpotify\Console;

use Shahlinibrahim\Mp3ToSpotify\Concerns\Data;
use Shahlinibrahim\Mp3ToSpotify\Concerns\ShouldProceed;
use Shahlinibrahim\Mp3ToSpotify\Contracts\ConsoleScreen;
use Shahlinibrahim\Mp3ToSpotify\Exceptions\PathNotFoundException;

use function Laravel\Prompts\error;
use function Laravel\Prompts\text;

class SetSongsFolderScreen implements ConsoleScreen {

    use Data, ShouldProceed;

    public function display() {
        $path = text("Specify the path to your songs folder that you want to transfer");

        try {
            $this->validatePath($path);

            $this->setPath($path);
            $this->shouldProceed();
        } catch (PathNotFoundException $e) {
            error($e->getMessage());
            $this->shouldNotProceed();
        }
    }

    private function validatePath(String $path) {
        if (!file_exists($path)) {
            throw new PathNotFoundException("Given path does not exist");
        } 
    }

}