<?php

namespace App\Contracts;

interface GeoLocationServiceInterface
{
    public function locate(?string $ip = null): ?array;
}
