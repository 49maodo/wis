<?php

namespace App\Filament\Admin\Resources\Compagnies\Pages;

use App\Filament\Admin\Resources\Compagnies\CompagnyResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewCompagny extends ViewRecord
{
    protected static string $resource = CompagnyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
