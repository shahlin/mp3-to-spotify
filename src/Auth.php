<?php

namespace Shahlinibrahim\Mp3ToSpotify;

use Shahlinibrahim\Mp3ToSpotify\Concerns\Transportable;
use Shahlinibrahim\Mp3ToSpotify\Enums\Transporter\ContentType;
use Shahlinibrahim\Mp3ToSpotify\Responses\AuthResponse;
use Shahlinibrahim\Mp3ToSpotify\ValueObjects\AccessToken;
use Shahlinibrahim\Mp3ToSpotify\ValueObjects\AuthCode;
use Shahlinibrahim\Mp3ToSpotify\ValueObjects\ClientId;
use Shahlinibrahim\Mp3ToSpotify\ValueObjects\ClientSecret;
use Shahlinibrahim\Mp3ToSpotify\ValueObjects\ResourceUri;
use Shahlinibrahim\Mp3ToSpotify\ValueObjects\Transporter\BaseUri;
use Shahlinibrahim\Mp3ToSpotify\ValueObjects\Transporter\FormData;
use Shahlinibrahim\Mp3ToSpotify\ValueObjects\Transporter\Headers;
use Shahlinibrahim\Mp3ToSpotify\ValueObjects\Transporter\Payload;
use Shahlinibrahim\Mp3ToSpotify\ValueObjects\Transporter\QueryParams;

class Auth {

    use Transportable;

    private const BASE_URI = "accounts.spotify.com";
    public const AUTH_CODE_FILENAME = ".auth.code";
    private const SCOPES_NEEDED = [
        'playlist-read-private',
        'playlist-modify-public',
        'playlist-modify-private'
    ];

    public function authorize(ClientId $clientId): AuthCode {
        $scopes = implode(' ', self::SCOPES_NEEDED);
        $queryParams = QueryParams::create()
            ->add('client_id', $clientId->toString())
            ->add('response_type', 'code')
            ->add('redirect_uri', $this->getRedirectUri())
            ->add('scope', $scopes);

        $uri = ResourceUri::fromQueryParams('authorize', $queryParams);
        $authUrl = $this->getBaseUri()->toString() . $uri->toString();

        $this->openInBrowser($authUrl);

        $authCode = $this->waitForAuthCode();

        $this->deleteAuthCodeFile();

        return $authCode;
    }

    public function authenticate(ClientId $clientId, ClientSecret $clientSecret, AuthCode $authCode): AccessToken {
        $formData = FormData::create()
            ->add('grant_type', 'authorization_code')
            ->add('code', $authCode->toString())
            ->add('redirect_uri', $this->getRedirectUri());

        $payload = Payload::create('api/token', ContentType::WWW_FORM_ENCODED, $formData);
        $headers = Headers::withBasicAuthorization($clientId, $clientSecret);

        $response = $this->transporter->requestObject($payload, $headers);

        return AuthResponse::fromJson($response->data())->accessToken();
    }

    private function getBaseUri(): BaseUri {
        return BaseUri::from(self::BASE_URI);
    }

    private function getRedirectUri(): string {
        return $_ENV['REDIRECT_BASE_URI'] . '/callback.php';
    }

    public function openInBrowser(string $url)
    {
        switch (PHP_OS) {
            case 'Darwin':
                $opener = 'open';
                break;
            case 'WINNT':
                $opener = 'start';
                break;
            default:
                $opener = 'xdg-open';
        }

        exec($opener . ' "' . $url . '"');
    }

    private function waitForAuthCode(): AuthCode {
        while(true) {
            if ($authCode = @file_get_contents(self::AUTH_CODE_FILENAME)) {
                return AuthCode::from($authCode);
            }
        }
    }

    private function deleteAuthCodeFile() {
        unlink(self::AUTH_CODE_FILENAME);
    }

}