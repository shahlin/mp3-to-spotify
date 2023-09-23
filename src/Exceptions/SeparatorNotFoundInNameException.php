<?php

namespace Shahlinibrahim\Mp3ToSpotify\Exceptions;

use Exception;

final class SeparatorNotFoundInNameException extends Exception
{
    /**
     * Creates a new Exception instance.
     */
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}