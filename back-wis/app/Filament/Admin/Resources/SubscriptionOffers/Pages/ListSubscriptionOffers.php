<?php

namespace App\Filament\Admin\Resources\SubscriptionOffers\Pages;

use App\Filament\Admin\Resources\SubscriptionOffers\SubscriptionOfferResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSubscriptionOffers extends ListRecords
{
    protected static string $resource = SubscriptionOfferResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
