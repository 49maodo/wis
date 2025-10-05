<?php

namespace App\Filament\Admin\Resources\CompagnyVerifications\Pages;

use App\Filament\Admin\Resources\CompagnyVerifications\CompagnyVerificationsResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCompagnyVerifications extends ListRecords
{
    protected static string $resource = CompagnyVerificationsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
