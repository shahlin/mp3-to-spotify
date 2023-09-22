<?php

namespace Shahlinibrahim\Mp3ToSpotify;

use GuzzleHttp\Client;
use Shahlinibrahim\Mp3ToSpotify\Enums\Transporter\ContentType;
use Shahlinibrahim\Mp3ToSpotify\Responses\AuthResponse;
use Shahlinibrahim\Mp3ToSpotify\Transporter\HttpTransporter;
use Shahlinibrahim\Mp3ToSpotify\ValueObjects\AccessToken;
use Shahlinibrahim\Mp3ToSpotify\ValueObjects\ClientId;
use Shahlinibrahim\Mp3ToSpotify\ValueObjects\ClientSecret;
use Shahlinibrahim\Mp3ToSpotify\ValueObjects\Transporter\BaseUri;
use Shahlinibrahim\Mp3ToSpotify\ValueObjects\Transporter\FormData;
use Shahlinibrahim\Mp3ToSpotify\ValueObjects\Transporter\Headers;
use Shahlinibrahim\Mp3ToSpotify\ValueObjects\Transporter\Payload;

class Auth {

    private HttpTransporter $transporter;

    public function __construct() {
        $baseUri = BaseUri::from($_ENV['SPOTIFY_AUTH_URI']);
        $authClient = new Client(['base_uri' => $baseUri->toString()]);

        $this->transporter = new HttpTransporter($authClient, $baseUri);
    }

    public function authenticate(ClientId $clientId, ClientSecret $clientSecret): AccessToken {
        $formData = FormData::create()
            ->add('grant_type', 'client_credentials')
            ->add('client_id', $clientId->toString())
            ->add('client_secret', $clientSecret->toString());

        $payload = Payload::create('token', ContentType::WWW_FORM_ENCODED, $formData);

        $response = $this->transporter->requestObject($payload);

        return AuthResponse::fromJson($response->data())->accessToken();
    }

}