<?php

namespace App\Filament\Admin\Resources\SubscriptionOffers\Pages;

use App\Filament\Admin\Resources\SubscriptionOffers\SubscriptionOfferResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditSubscriptionOffer extends EditRecord
{
    protected static string $resource = SubscriptionOfferResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
