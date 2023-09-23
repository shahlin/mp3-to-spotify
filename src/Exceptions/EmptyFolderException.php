<?php

namespace Shahlinibrahim\Mp3ToSpotify\Exceptions;

use Exception;

final class EmptyFolderException extends Exception
{
    /**
     * Creates a new Exception instance.
     */
    public function __construct(string $message = null)
    {
        parent::__construct($message ?? "No files found in given path");
    }
}