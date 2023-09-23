<?php

namespace Shahlinibrahim\Mp3ToSpotify\Concerns;

use GuzzleHttp\Client;
use Shahlinibrahim\Mp3ToSpotify\Transporter\HttpTransporter;
use Shahlinibrahim\Mp3ToSpotify\ValueObjects\Transporter\BaseUri;

trait Transportable {

    private HttpTransporter $transporter;

    public function __construct() {
        $baseUri = $this->getBaseUri();
        $client = new Client(['base_uri' => $baseUri->toString()]);

        $this->transporter = new HttpTransporter($client, $baseUri);
    }

    private function getBaseUri(): BaseUri {
        return BaseUri::from('api.spotify.com/v1');
    }


}