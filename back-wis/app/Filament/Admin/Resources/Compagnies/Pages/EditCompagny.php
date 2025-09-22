<?php

namespace App\Filament\Admin\Resources\Compagnies\Pages;

use App\Filament\Admin\Resources\Compagnies\CompagnyResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditCompagny extends EditRecord
{
    protected static string $resource = CompagnyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
