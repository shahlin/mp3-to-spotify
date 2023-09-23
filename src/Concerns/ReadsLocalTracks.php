<?php

namespace Shahlinibrahim\Mp3ToSpotify\Concerns;
use Shahlinibrahim\Mp3ToSpotify\Exceptions\EmptyFolderException;

trait ReadsLocalTracks {

    private function readOneTrackName(string $path): string {
        return $this->readAllTrackNames($path)[0];
    }

    private function readAllTrackNames(string $path): array {
        $filenames = preg_grep('~\.(mp3)$~', scandir($path));

        if (empty($filenames)) {
            throw new EmptyFolderException();
        }

        return array_values($filenames);
    }

}