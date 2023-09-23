<?php

namespace Shahlinibrahim\Mp3ToSpotify\Concerns;

trait ShouldProceed {

    private bool $proceed;

    private function shouldProceed() {
        $this->proceed = true;
    }

    private function shouldNotProceed() {
        $this->proceed = false;
    }

    public function proceed(): bool {
        return $this->proceed;
    }

}