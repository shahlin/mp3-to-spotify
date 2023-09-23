<?php

namespace Shahlinibrahim\Mp3ToSpotify\Concerns;
use Shahlinibrahim\Mp3ToSpotify\Exceptions\EmptyFolderException;
use Shahlinibrahim\Mp3ToSpotify\Exceptions\SeparatorNotFoundInNameException;
use Shahlinibrahim\Mp3ToSpotify\ValueObjects\LocalTrack;

trait ReadsLocalTracks {

    private function getLocalTracks(string $path, string $separator, bool $artistNameLeftSide): array {
        $filenames = $this->readAllTrackFileNames($path);
        $tracks = [];

        foreach ($filenames as $filename) {
            if ($artistNameLeftSide) {
                $artist = $this->getLeftToken($filename, $separator);
                $track = $this->getRightToken($filename, $separator);
            } else {
                $artist = $this->getRightToken($filename, $separator);
                $track = $this->getLeftToken($filename, $separator);
            }

            $tracks[] = LocalTrack::from($artist, $track);
        }

        return $tracks;
    }

    private function readSingleTrackFileName(string $path): string {
        return $this->readAllTrackFileNames($path)[0];
    }

    private function readAllTrackFileNames(string $path): array {
        $filenames = preg_grep('~\.(mp3)$~', scandir($path));

        if (empty($filenames)) {
            throw new EmptyFolderException();
        }

        return array_values($filenames);
    }

    private function getLeftToken(string $fileName, string $separator): string {
        return $this->getAllTokensFromFileName($fileName, $separator)[0];
    }

    private function getRightToken(string $fileName, string $separator): string {
        return $this->getAllTokensFromFileName($fileName, $separator)[1];
    }

    private function getAllTokensFromFileName(string $fileName, string $separator): array {
        $tokens = explode($separator, $fileName);

        if (empty($tokens) || count($tokens) < 2) {
            throw new SeparatorNotFoundInNameException("Naming separation not found in file name: " . $fileName);
        }

        return array_map(fn($token) => str_replace(".mp3", "", $token), $tokens);
    }

}