<?php

namespace App\Filament\Admin\Resources\CodeLists;

use App\Filament\Admin\Resources\CodeLists\Pages\CreateCodeList;
use App\Filament\Admin\Resources\CodeLists\Pages\EditCodeList;
use App\Filament\Admin\Resources\CodeLists\Pages\ListCodeLists;
use App\Filament\Admin\Resources\CodeLists\Pages\ViewCodeList;
use App\Filament\Admin\Resources\CodeLists\Schemas\CodeListForm;
use App\Filament\Admin\Resources\CodeLists\Schemas\CodeListInfolist;
use App\Filament\Admin\Resources\CodeLists\Tables\CodeListsTable;
use App\Models\CodeList;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class CodeListResource extends Resource
{
    protected static ?string $model = CodeList::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'type';

    public static function form(Schema $schema): Schema
    {
        return CodeListForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return CodeListInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CodeListsTable::configure($table);
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
            'index' => ListCodeLists::route('/'),
            'create' => CreateCodeList::route('/create'),
            'view' => ViewCodeList::route('/{record}'),
            'edit' => EditCodeList::route('/{record}/edit'),
        ];
    }
}
