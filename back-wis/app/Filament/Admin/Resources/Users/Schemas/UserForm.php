<?php

namespace App\Filament\Admin\Resources\Users\Schemas;

use App\Enums\UserRole;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('firstname'),
                TextInput::make('name')
                    ->required(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required(),
                TextInput::make('phoneNumber')
                    ->tel(),
                Select::make('role')
                    ->options(UserRole::class)
                    ->default('user'),
                Select::make('compagny_id')
                    ->label('Compagny')
                    ->relationship('compagny', 'name')
                    ->preload()
                    ->nullable()
                    ->searchable(),
            ]);
    }
}
