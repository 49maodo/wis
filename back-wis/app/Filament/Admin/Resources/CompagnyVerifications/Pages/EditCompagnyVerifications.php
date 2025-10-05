<?php

namespace App\Filament\Admin\Resources\CompagnyVerifications\Pages;

use App\Filament\Admin\Resources\CompagnyVerifications\CompagnyVerificationsResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditCompagnyVerifications extends EditRecord
{
    protected static string $resource = CompagnyVerificationsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
