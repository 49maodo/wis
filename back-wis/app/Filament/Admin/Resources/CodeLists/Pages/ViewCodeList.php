<?php

namespace App\Filament\Admin\Resources\CodeLists\Pages;

use App\Filament\Admin\Resources\CodeLists\CodeListResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewCodeList extends ViewRecord
{
    protected static string $resource = CodeListResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
