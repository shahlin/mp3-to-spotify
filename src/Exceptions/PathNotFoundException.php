<?php

namespace Shahlinibrahim\Mp3ToSpotify\Exceptions;

use Exception;

final class PathNotFoundException extends Exception
{
    /**
     * Creates a new Exception instance.
     */
    public function __construct($message)
    {
        parent::__construct($message);
    }
}