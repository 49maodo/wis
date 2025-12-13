<?php

namespace App\Filament\Admin\Resources\CodeLists\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class CodeListInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('type')->badge()->default('N/A'),
                TextEntry::make('value')->badge()->default('N/A'),
                TextEntry::make('description')->badge()->default('N/A'),
                IconEntry::make('active')
                    ->boolean(),
                TextEntry::make('created_at')->badge()->default('N/A')
                    ->dateTime(),
                TextEntry::make('updated_at')->badge()->default('N/A')
                    ->dateTime(),
            ]);
    }
}
