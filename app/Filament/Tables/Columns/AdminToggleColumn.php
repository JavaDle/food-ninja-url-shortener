<?php

namespace App\Filament\Tables\Columns;

use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\ToggleColumn;

class AdminToggleColumn
{
    public static function make(string $name = 'is_active'): ToggleColumn
    {
        return ToggleColumn::make($name)
            ->label(trans('admin.is_active'))
            ->onIcon(Heroicon::OutlinedCheck)
            ->offIcon(Heroicon::OutlinedXMark)
            ->onColor('success')
            ->offColor('danger')
            ->sortable()
            ->width('10px');
    }
}
