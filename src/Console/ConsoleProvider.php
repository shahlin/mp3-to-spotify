<?php

namespace Shahlinibrahim\Mp3ToSpotify\Console;

class ConsoleProvider {

    public static function boot() { 
        $welcomeScreen = new WelcomeScreen();
        $authScreen = new AuthScreen();
        $selectPlaylistScreen = new SelectPlaylistScreen();
        $setSongsFolderPathScreen = new SetSongsFolderScreen();
        $setNamesSeparatorScreen = new SetNameSeparatorScreen();
        $selectArtistAndTrackScreen = new SelectArtistAndTrackScreen();
        $transferScreen = new TransferScreen();

        $welcomeScreen->display();

        if (!$welcomeScreen->proceed()) {
            return;
        }

        $authScreen->display();

        if (!$authScreen->proceed()) {
            return;
        }

        $accessToken = $authScreen->accessToken();
        $selectPlaylistScreen->setAccessToken($accessToken);
        $selectPlaylistScreen->display();
        $playlistId = $selectPlaylistScreen->playlistId();

        if (!$selectPlaylistScreen->proceed()) {
            return;
        }

        $setSongsFolderPathScreen->display();

        if (!$setSongsFolderPathScreen->proceed()) {
            return;
        }

        $songsFolderPath = $setSongsFolderPathScreen->path();

        $setNamesSeparatorScreen->display();

        if (!$setNamesSeparatorScreen->proceed()) {
            return;
        }

        $separator = $setNamesSeparatorScreen->separator();

        $selectArtistAndTrackScreen->setSeparator($separator);
        $selectArtistAndTrackScreen->setPath($songsFolderPath);
        $selectArtistAndTrackScreen->display();

        if (!$selectArtistAndTrackScreen->proceed()) {
            return;
        }

        $transferScreen->setAccessToken($accessToken);
        $transferScreen->setSeparator($separator);
        $transferScreen->setPath($songsFolderPath);
        $transferScreen->setPlaylistId($playlistId);
        $transferScreen->setArtistNameLeftSide($selectArtistAndTrackScreen->artistNameLeftSide());
        $transferScreen->display();
    }

}