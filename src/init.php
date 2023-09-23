<?php

namespace Shahlinibrahim\Mp3ToSpotify;
use Dotenv\Dotenv;

require 'vendor/autoload.php';

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

Logger::$log_level = 'debug';