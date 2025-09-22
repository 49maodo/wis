<?php

namespace App\Filament\Admin\Resources\Jobs\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class JobInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('title'),
                TextEntry::make('description'),
                TextEntry::make('salary')
                    ->numeric(),
                TextEntry::make('experienceLevel'),
                TextEntry::make('location'),
                TextEntry::make('jobtype'),
                TextEntry::make('creatorId')
                    ->numeric(),
                TextEntry::make('compagny.name')
                    ->numeric(),
                TextEntry::make('created_at')
                    ->dateTime(),
                TextEntry::make('updated_at')
                    ->dateTime(),
            ]);
    }
}
