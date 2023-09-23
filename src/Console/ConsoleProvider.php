<?php

namespace Shahlinibrahim\Mp3ToSpotify\Console;

use Shahlinibrahim\Mp3ToSpotify\Console\AuthScreen;
use Shahlinibrahim\Mp3ToSpotify\Console\WelcomeScreen;

class ConsoleProvider {

    public static function boot() {
        $welcomeScreen = new WelcomeScreen();
        $authScreen = new AuthScreen();
        $selectPlaylistScreen = new SelectPlaylistScreen();
        $setSongsFolderPathScreen = new SetSongsFolderScreen();
        $setNamesSeparatorScreen = new SetNameSeparatorScreen();

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

        $setSongsFolderPathScreen->display();
        $songsFolderPath = $setSongsFolderPathScreen->data()['path'];

        $setNamesSeparatorScreen->display();
        $separator = $setNamesSeparatorScreen->data()['separator'];
    }

}