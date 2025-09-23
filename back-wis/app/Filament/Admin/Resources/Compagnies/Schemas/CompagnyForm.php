<?php

namespace App\Filament\Admin\Resources\Compagnies\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class CompagnyForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('description'),
                TextInput::make('website'),
                TextInput::make('location'),
                TextInput::make('logo'),
            ]);
    }
}
