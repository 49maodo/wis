<?php

namespace App\Filament\Admin\Resources\Compagnies\Pages;

use App\Filament\Admin\Resources\Compagnies\CompagnyResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCompagnies extends ListRecords
{
    protected static string $resource = CompagnyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
