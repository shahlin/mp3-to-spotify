<?php

namespace Shahlinibrahim\Mp3ToSpotify\Console;

use Shahlinibrahim\Mp3ToSpotify\Auth;
use Shahlinibrahim\Mp3ToSpotify\Concerns\Data;
use Shahlinibrahim\Mp3ToSpotify\Concerns\ShouldProceed;
use Shahlinibrahim\Mp3ToSpotify\Contracts\ConsoleScreen;
use Shahlinibrahim\Mp3ToSpotify\Exceptions\TransporterException;
use Shahlinibrahim\Mp3ToSpotify\ValueObjects\ClientId;
use Shahlinibrahim\Mp3ToSpotify\ValueObjects\ClientSecret;
use function Laravel\Prompts\error;
use function Laravel\Prompts\text;
use function Laravel\Prompts\spin;

class AuthScreen implements ConsoleScreen {

    use Data, ShouldProceed;

    private Auth $auth;

    public function __construct() {
        $this->auth = new Auth();
    }

    public function display() {
        $clientId = ClientId::from(text("Enter Client ID"));
        $clientSecret = ClientSecret::from(text("Enter Client Secret"));

        try {
            $authCode = spin(
                fn() => $this->auth->authorize($clientId),
                'Authorizing user...'
            );

            $accessToken = spin(
                fn() => $this->auth->authenticate($clientId, $clientSecret, $authCode),
                'Authenticating client...'
            );

            $this->setAccessToken($accessToken);
            $this->shouldProceed();
        } catch (TransporterException) {
            error("Authentication failed: Make sure the credentials are correct");
            $this->shouldNotProceed();
            return;
        }
    }

}