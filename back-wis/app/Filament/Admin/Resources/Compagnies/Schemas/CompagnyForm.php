<?php

namespace App\Filament\Admin\Resources\Compagnies\Schemas;

use App\Enums\VerificationStatus;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class CompagnyForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('ninea'),
                TextInput::make('rccm'),
                TextInput::make('name')
                    ->required(),
                Textarea::make('description'),
                Select::make('status')
                    ->options(VerificationStatus::class)
                    ->default(VerificationStatus::PENDING->value),
                TextInput::make('website'),
                TextInput::make('location'),
                FileUpload::make('logo')
                    ->image()
                    ->maxSize(2048)
                    ->directory('logos')
                    ->disk('public'),
            ]);
    }
}
