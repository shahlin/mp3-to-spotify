<?php

namespace Shahlinibrahim\Mp3ToSpotify\Resources;

use Shahlinibrahim\Mp3ToSpotify\Concerns\Authenticated;
use Shahlinibrahim\Mp3ToSpotify\Concerns\Transportable;
use Shahlinibrahim\Mp3ToSpotify\Enums\Transporter\ContentType;
use Shahlinibrahim\Mp3ToSpotify\Responses\Playlist\ListResponse;
use Shahlinibrahim\Mp3ToSpotify\ValueObjects\PlaylistId;
use Shahlinibrahim\Mp3ToSpotify\ValueObjects\Transporter\FormData;
use Shahlinibrahim\Mp3ToSpotify\ValueObjects\Transporter\Headers;
use Shahlinibrahim\Mp3ToSpotify\ValueObjects\Transporter\Payload;

class Playlist {

    use Transportable, Authenticated;

    public function list(): array {
        $payload = Payload::retrieve('me/playlists', null, ContentType::WWW_FORM_ENCODED);
        $headers = Headers::create()->withAuthorization($this->accessToken);

        $response = $this->transporter->requestObject($payload, $headers);

        return ListResponse::fromJson($response->data())->list();
    }

    public function add(PlaylistId $playlistId, array $trackUrisToAdd) {
        $formData = FormData::create()
            ->add('position', 0)
            ->add('uris', $trackUrisToAdd);

        $payload = Payload::create(
            'playlists/' . $playlistId->toString() . '/tracks',
            ContentType::JSON,
            $formData
        );

        $headers = Headers::create()->withAuthorization($this->accessToken);
        
        $this->transporter->requestObject($payload, $headers);
    }

}