<?php

namespace App\Filament\Admin\Resources\SubscriptionOffers\Schemas;

use App\Enums\OfferType;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class SubscriptionOfferForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('description'),
                TextInput::make('price')
                    ->numeric()
                    ->prefix('$'),
                TextInput::make('max_jobs')
                    ->required()
                    ->numeric(),
                Select::make('offer_type')
                    ->options(OfferType::class)
                    ->default('basic')
                    ->required(),
                Toggle::make('is_active')
                    ->label('Active')
                    ->default(true),
            ]);
    }
}
