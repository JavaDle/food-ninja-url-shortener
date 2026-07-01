<?php

namespace App\Filament\Forms\Components;

use Filament\Forms\Components\Toggle;
use Filament\Support\Icons\Heroicon;

class AdminToggle
{
    public static function make(string $name = 'is_active'): Toggle
    {
        return Toggle::make($name)
            ->label(trans('admin.active'))
            ->onIcon(Heroicon::OutlinedCheck)
            ->offIcon(Heroicon::OutlinedXMark)
            ->onColor('success')
            ->offColor('danger')
            ->columnSpanFull();
    }
}
