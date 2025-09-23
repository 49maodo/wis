<?php

namespace App\Filament\Admin\Resources\Compagnies;

use App\Filament\Admin\Resources\Compagnies\Pages\CreateCompagny;
use App\Filament\Admin\Resources\Compagnies\Pages\EditCompagny;
use App\Filament\Admin\Resources\Compagnies\Pages\ListCompagnies;
use App\Filament\Admin\Resources\Compagnies\Pages\ViewCompagny;
use App\Filament\Admin\Resources\Compagnies\Schemas\CompagnyForm;
use App\Filament\Admin\Resources\Compagnies\Schemas\CompagnyInfolist;
use App\Filament\Admin\Resources\Compagnies\Tables\CompagniesTable;
use App\Models\Compagny;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class CompagnyResource extends Resource
{
    protected static ?string $model = Compagny::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return CompagnyForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return CompagnyInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CompagniesTable::configure($table);
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
            'index' => ListCompagnies::route('/'),
            'create' => CreateCompagny::route('/create'),
            'view' => ViewCompagny::route('/{record}'),
            'edit' => EditCompagny::route('/{record}/edit'),
        ];
    }
}
