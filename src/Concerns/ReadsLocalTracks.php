<?php

namespace Shahlinibrahim\Mp3ToSpotify\Concerns;

use Exception;
use Shahlinibrahim\Mp3ToSpotify\Exceptions\EmptyFolderException;
use Shahlinibrahim\Mp3ToSpotify\Exceptions\SeparatorNotFoundInNameException;
use Shahlinibrahim\Mp3ToSpotify\Logger;
use Shahlinibrahim\Mp3ToSpotify\ValueObjects\LocalTrack;

trait ReadsLocalTracks {

    private function getLocalTracks(string $path, string $separator, bool $artistNameLeftSide): array {
        $filenames = $this->readAllTrackFileNames($path);
        $tracks = [];

        foreach ($filenames as $filename) {
            try {
                if ($artistNameLeftSide) {
                    $artist = $this->getLeftToken($filename, $separator);
                    $track = $this->getRightToken($filename, $separator);
                } else {
                    $artist = $this->getRightToken($filename, $separator);
                    $track = $this->getLeftToken($filename, $separator);
                }
            } catch (SeparatorNotFoundInNameException $e) {
                continue;
            }

            $tracks[] = LocalTrack::from($artist, $track);
        }

        return $tracks;
    }

    private function readSingleTrackFileName(string $path): string {
        return $this->readAllTrackFileNames($path)[0];
    }

    private function readAllTrackFileNames(string $path): array {
        if (str_ends_with($path, '.txt')) {
            $filenames = file($path, FILE_IGNORE_NEW_LINES);
        } else {
            $filenames = preg_grep('~\.(mp3)$~', scandir($path));
        }

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
        $fileName = str_replace(".mp3", "", $fileName);
        $tokens = explode($separator, $fileName);

        if (empty($tokens) || count($tokens) < 2) {
            Logger::failed($fileName);
            throw new SeparatorNotFoundInNameException("Naming separation not found in file name: " . $fileName);
        }

        return $tokens;
    }

}