<?php

namespace App\Filament\Forms\Components;

use Filament\Forms\Components\FileUpload as BaseFileUpload;

class AdminFileUpload extends BaseFileUpload
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->label(trans('admin.image'))
            ->image()
            ->openable()
            ->previewable()
            ->downloadable()
            ->imageEditor()
            ->loadingIndicatorPosition('center')
            ->uploadProgressIndicatorPosition('center')
            ->disk(config('filesystems.default'));
    }
}
