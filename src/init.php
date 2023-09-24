<?php

namespace Shahlinibrahim\Mp3ToSpotify;
use Dotenv\Dotenv;
use Dotenv\Exception\InvalidPathException;

require 'vendor/autoload.php';

try {
    $dotenv = Dotenv::createImmutable(__DIR__ . '/../');
    $dotenv->load();
} catch (InvalidPathException) {}

Logger::$log_level = 'debug';