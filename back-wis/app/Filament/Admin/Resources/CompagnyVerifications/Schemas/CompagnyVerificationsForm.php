<?php

namespace App\Filament\Admin\Resources\CompagnyVerifications\Schemas;

use App\Enums\VerificationStatus;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class CompagnyVerificationsForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('compagny_id')
                    ->relationship('compagny', 'name')
                    ->disabled()
                    ->required(),
                Select::make('submitted_by')
                    ->relationship('submittedBy', 'name')
                    ->disabled()
                    ->required(),
                TextInput::make('ninea')
                    ->disabled()
                    ->required(),
                TextInput::make('rccm')
                    ->disabled(),
                Textarea::make('notes')
                    ->disabled()
                    ->columnSpanFull(),
                Select::make('status')
                    ->options(VerificationStatus::class)
                    ->default('pending')
                    ->required(),
                Textarea::make('admin_notes')
                    ->columnSpanFull(),
            ]);
    }
}
