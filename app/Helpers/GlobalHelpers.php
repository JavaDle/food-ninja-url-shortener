<?php

namespace App\Helpers;

class GlobalHelpers
{
    public static function brandLogoLight(): string
    {
        return asset('/assets/images/logo.svg');
    }

    public static function brandLogoDark(): string
    {
        return asset('/assets/images/logo-dark.svg');
    }
}
