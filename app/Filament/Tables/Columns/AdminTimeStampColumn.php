<?php

namespace App\Filament\Tables\Columns;

use Filament\Tables\Columns\TextColumn;

class AdminTimeStampColumn extends TextColumn
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->label(trans('admin.created_at'))
            ->dateTime()
            ->sortable()
            ->toggleable(isToggledHiddenByDefault: true)
            ->width('10px');
    }
}
