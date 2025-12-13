<?php

namespace App\Filament\Admin\Resources\CodeLists\Pages;

use App\Filament\Admin\Resources\CodeLists\CodeListResource;
use App\Models\CodeList;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;

class ListCodeLists extends ListRecords
{
    protected static string $resource = CodeListResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('clearCache')
                ->label('Clear cache')
                ->icon('heroicon-o-arrow-path')
                ->color('warning')
                ->action(function () {
                    CodeList::clearCache();
                    Notification::make()
                        ->success()
                        ->title('Cache cleared')
                        ->body('All code lists have been reloaded.')
                        ->send();
                }),
            CreateAction::make(),
        ];
    }
}
