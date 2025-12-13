<?php

namespace App\Filament\Admin\Resources\CodeLists\Schemas;

use App\Models\CodeList;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class CodeListForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
//                TextInput::make('type')
//                    ->required(),
                Select::make('type')
                    ->label('Type')
                    ->options(CodeList::TYPES)
                    ->required()
                    ->searchable()
                    ->native(false),
//                TextInput::make('value')
//                    ->required(),
                TextInput::make('value')
                    ->label('Valeur')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true)
                    ->helperText('Valeur technique utilisée dans le code'),
//                Textarea::make('description'),
                Textarea::make('description')
                    ->label('Description')
                    ->maxLength(500)
                    ->rows(3)
                    ->helperText('Description affichée aux utilisateurs'),
                Toggle::make('active')
                    ->default(true)
                    ->helperText('Désactiver pour masquer sans supprimer')
                    ->required(),
            ]);
    }
}
