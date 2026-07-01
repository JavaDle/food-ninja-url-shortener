<?php

namespace App\Filament\Resources\Links\Pages;

use App\Filament\Resources\Links\LinkResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Str;

class ListLinks extends ListRecords
{
    protected static string $resource = LinkResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label(trans('admin.add_link'))
                ->modalHeading(trans('admin.add_link'))
                ->mutateDataUsing(function (array $data): array {
                    $data['short_code'] ??= Str::password(
                        length: 8,
                        symbols: false,
                    );

                    $data['user_id'] ??= auth()->id();

                    return $data;
                }),
        ];
    }

    public function getTitle(): string
    {
        return trans('admin.links');
    }
}
