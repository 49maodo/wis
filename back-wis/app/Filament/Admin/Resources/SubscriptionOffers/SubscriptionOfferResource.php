<?php

namespace App\Filament\Admin\Resources\SubscriptionOffers;

use App\Filament\Admin\Resources\SubscriptionOffers\Pages\CreateSubscriptionOffer;
use App\Filament\Admin\Resources\SubscriptionOffers\Pages\EditSubscriptionOffer;
use App\Filament\Admin\Resources\SubscriptionOffers\Pages\ListSubscriptionOffers;
use App\Filament\Admin\Resources\SubscriptionOffers\Schemas\SubscriptionOfferForm;
use App\Filament\Admin\Resources\SubscriptionOffers\Tables\SubscriptionOffersTable;
use App\Models\SubscriptionOffer;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class SubscriptionOfferResource extends Resource
{
    protected static ?string $model = SubscriptionOffer::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCurrencyDollar;

    protected static string | UnitEnum | null $navigationGroup = 'Billing';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return SubscriptionOfferForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SubscriptionOffersTable::configure($table);
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
            'index' => ListSubscriptionOffers::route('/'),
            'create' => CreateSubscriptionOffer::route('/create'),
            'edit' => EditSubscriptionOffer::route('/{record}/edit'),
        ];
    }
}
