<?php

namespace App\Filament\Tables\Columns;

use Filament\Tables\Columns\ImageColumn;

class AdminImageColumn extends ImageColumn
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->label(trans('admin.image'))
            ->defaultImageUrl(asset('/vendor/alisa-core/images/no-image.svg'))
            ->disk(config('filesystems.default'))
            ->circular()
            ->sortable()
            ->imageSize(60)
            ->width('10px')
            ->extraImgAttributes([
                'alt' => trans('admin.image_alt'),
                'loading' => 'lazy',
                'style' => 'border-radius: 1rem;',
            ]);
    }
}
