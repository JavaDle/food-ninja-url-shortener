<?php

namespace App\Filament\Resources\Links;

use App\Filament\Resources\Links\Pages\ListLinks;
use App\Filament\Resources\Links\Pages\ViewLink;
use App\Filament\Resources\Links\Schemas\LinkForm;
use App\Filament\Resources\Links\Schemas\LinkInfoList;
use App\Filament\Resources\Links\Tables\LinksTable;
use App\Models\Link;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class LinkResource extends Resource
{
    protected static ?string $model = Link::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedLink;

    protected static ?string $recordTitleAttribute = 'title';

    protected static ?int $navigationSort = 2;

    public static function getNavigationLabel(): string
    {
        return trans('admin.links');
    }

    public static function getBreadcrumb(): string
    {
        return trans('admin.links');
    }

    public static function infolist(Schema $schema): Schema
    {
        return LinkInfoList::configure($schema);
    }


    public static function form(Schema $schema): Schema
    {
        return LinkForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return LinksTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListLinks::route('/'),
            'view' => ViewLink::route('/{record}'),
        ];
    }
}
