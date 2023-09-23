<?php

namespace Shahlinibrahim\Mp3ToSpotify\Resources;

use Shahlinibrahim\Mp3ToSpotify\Concerns\Authenticated;
use Shahlinibrahim\Mp3ToSpotify\Concerns\Transportable;
use Shahlinibrahim\Mp3ToSpotify\Enums\Transporter\ContentType;
use Shahlinibrahim\Mp3ToSpotify\Responses\Search\SearchResponse;
use Shahlinibrahim\Mp3ToSpotify\ValueObjects\Transporter\BaseUri;
use Shahlinibrahim\Mp3ToSpotify\ValueObjects\Transporter\Headers;
use Shahlinibrahim\Mp3ToSpotify\ValueObjects\Transporter\Payload;
use Shahlinibrahim\Mp3ToSpotify\ValueObjects\Transporter\QueryParams;

class Search {

    use Transportable, Authenticated;

    public function search(string $artistName, string $trackName): array {
        // Removing single quotes to workaround a possible Spotify API issue
        $artistName = str_replace("'", "", $artistName);
        $trackName = str_replace("'", "", $trackName);

        $searchQuery = "artist:{$artistName} track:{$trackName}";
        $queryParams = QueryParams::create()
            ->add('q', $searchQuery)
            ->add('type', 'track')
            ->add('limit', 1);

        $payload = Payload::retrieve('search', $queryParams, ContentType::WWW_FORM_ENCODED);
        $headers = Headers::create()->withAuthorization($this->accessToken);

        $response = $this->transporter->requestObject($payload, $headers);

        return SearchResponse::fromJson($response->data())->list();
    }

}