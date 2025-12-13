<?php

namespace App\Filament\Admin\Resources\CodeLists\Pages;

use App\Filament\Admin\Resources\CodeLists\CodeListResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCodeList extends CreateRecord
{
    protected static string $resource = CodeListResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
