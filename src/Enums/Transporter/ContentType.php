<?php

declare(strict_types=1);

namespace Shahlinibrahim\Mp3ToSpotify\Enums\Transporter;

/**
 * @internal
 */
enum ContentType: string
{
    case JSON = 'application/json';
    case WWW_FORM_ENCODED = 'application/x-www-form-urlencoded';
}