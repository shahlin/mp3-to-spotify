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

        /** WELCOME SCREEN */
        $welcomeScreen->display();
        if (!$welcomeScreen->proceed()) { return; }

        /** AUTH SCREEN */
        $authScreen->display();
        if (!$authScreen->proceed()) { return; }

        /** SELECT PLAYLIST SCREEN */
        $accessToken = $authScreen->accessToken();
        $selectPlaylistScreen->setAccessToken($accessToken);
        $selectPlaylistScreen->display();
        $playlistId = $selectPlaylistScreen->playlistId();
        if (!$selectPlaylistScreen->proceed()) { return; }

        /** SET SONGS FOLDER PATH SCREEN */
        $setSongsFolderPathScreen->display();
        if (!$setSongsFolderPathScreen->proceed()) { return; }

        /** SET NAMES SEPARATOR SCREEN */
        $songsFolderPath = $setSongsFolderPathScreen->path();
        $setNamesSeparatorScreen->display();
        if (!$setNamesSeparatorScreen->proceed()) { return; }

        /** SELECT ARTIST AND TRACK ORDER SCREEN */
        $separator = $setNamesSeparatorScreen->separator();
        $selectArtistAndTrackScreen->setSeparator($separator);
        $selectArtistAndTrackScreen->setPath($songsFolderPath);
        $selectArtistAndTrackScreen->display();
        if (!$selectArtistAndTrackScreen->proceed()) { return; }

        /** TRANSFER SCREEN */
        $transferScreen->setAccessToken($accessToken);
        $transferScreen->setSeparator($separator);
        $transferScreen->setPath($songsFolderPath);
        $transferScreen->setPlaylistId($playlistId);
        $transferScreen->setArtistNameLeftSide($selectArtistAndTrackScreen->artistNameLeftSide());
        $transferScreen->display();
    }

}