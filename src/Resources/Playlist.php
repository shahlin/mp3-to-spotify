<?php

namespace Shahlinibrahim\Mp3ToSpotify\Resources;

use Shahlinibrahim\Mp3ToSpotify\Concerns\Transportable;
use Shahlinibrahim\Mp3ToSpotify\Responses\Playlist\ListResponse;
use Shahlinibrahim\Mp3ToSpotify\ValueObjects\AccessToken;
use Shahlinibrahim\Mp3ToSpotify\ValueObjects\Transporter\Headers;
use Shahlinibrahim\Mp3ToSpotify\ValueObjects\Transporter\Payload;

class Playlist {

    use Transportable;

    public function list(AccessToken $accessToken): array {
        $payload = Payload::retrieve('me/playlists');
        $headers = Headers::create()->withAuthorization($accessToken);

        $response = $this->transporter->requestObject($payload, $headers);

        return ListResponse::fromJson($response->data())->list();
    }

}