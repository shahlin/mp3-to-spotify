<?php

namespace Shahlinibrahim\Mp3ToSpotify;

use Shahlinibrahim\Mp3ToSpotify\ValueObjects\ClientId;
use Shahlinibrahim\Mp3ToSpotify\ValueObjects\ClientSecret;

require 'init.php';

$clientId = ClientId::from("xyz");
$clientSecret = ClientSecret::from("abc");

$auth = new Auth();
$accessToken = $auth->authenticate($clientId, $clientSecret);