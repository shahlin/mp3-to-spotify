<?php

declare(strict_types=1);

namespace Shahlinibrahim\Mp3ToSpotify\Contracts;

interface ConsoleScreen {

    public function display();

    public function proceed(): bool;

}