<?php

use Shahlinibrahim\Mp3ToSpotify\Auth;

require 'src/init.php';

$code = $_GET["code"];

if (isset($code) && !empty($code)) {
    file_put_contents(Auth::AUTH_CODE_FILENAME, $code);

    echo "<h1>Check the terminal!</h1>";
}
