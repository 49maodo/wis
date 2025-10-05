<?php

namespace App\Filament\Admin\Resources\CompagnyVerifications;

use App\Filament\Admin\Resources\CompagnyVerifications\Pages\CreateCompagnyVerifications;
use App\Filament\Admin\Resources\CompagnyVerifications\Pages\EditCompagnyVerifications;
use App\Filament\Admin\Resources\CompagnyVerifications\Pages\ListCompagnyVerifications;
use App\Filament\Admin\Resources\CompagnyVerifications\Schemas\CompagnyVerificationsForm;
use App\Filament\Admin\Resources\CompagnyVerifications\Tables\CompagnyVerificationsTable;
use App\Models\CompagnyVerifications;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class CompagnyVerificationsResource extends Resource
{
    protected static ?string $model = CompagnyVerifications::class;

    protected static string | UnitEnum | null $navigationGroup = 'Compagnies';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCheckBadge;

    protected static ?string $recordTitleAttribute = 'ninea';

    public static function getNavigationBadgeColor(): ?string
    {
        return static::getModel()::count() > 10 ? 'warning' : 'primary';
    }
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Schema $schema): Schema
    {
        return CompagnyVerificationsForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CompagnyVerificationsTable::configure($table);
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
            'index' => ListCompagnyVerifications::route('/'),
            'create' => CreateCompagnyVerifications::route('/create'),
            'edit' => EditCompagnyVerifications::route('/{record}/edit'),
        ];
    }
}
