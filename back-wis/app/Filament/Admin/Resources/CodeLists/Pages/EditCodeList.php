<?php

namespace App\Filament\Admin\Resources\CodeLists\Pages;

use App\Filament\Admin\Resources\CodeLists\CodeListResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditCodeList extends EditRecord
{
    protected static string $resource = CodeListResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
