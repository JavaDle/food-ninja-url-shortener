<?php

namespace App\Filament\Tables\Columns;

use Filament\Tables\Columns\TextColumn;

class AdminIDColumn extends TextColumn
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->label(trans('admin.id'))
            ->sortable()
            ->toggleable()
            ->copyable()
            ->copyMessage(trans('admin.copied'))
            ->copyMessageDuration(1500)
            ->toggleable(isToggledHiddenByDefault: true)
            ->width('10px');
    }
}
