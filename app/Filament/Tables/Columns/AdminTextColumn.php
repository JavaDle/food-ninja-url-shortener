<?php

namespace App\Filament\Tables\Columns;

use Filament\Tables\Columns\TextColumn;

class AdminTextColumn extends TextColumn
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->label(trans('admin.title'))
            ->sortable()
            ->searchable()
            ->default('#-#-#-#-#-#')
            ->wrap();
    }
}
