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
                TextEntry::make('title')->badge()->default('N/A'),
                TextEntry::make('description')->badge()->default('N/A'),
                TextEntry::make('salary')->badge()->default('N/A')
                    ->numeric(
                    )->prefix('XAF '),
                TextEntry::make('experienceLevel')->badge()->default('N/A'),
                TextEntry::make('location')->badge()->default('N/A'),
                TextEntry::make('jobtype')->badge()->default('N/A'),
                TextEntry::make('recruiter.email')->badge()->default('N/A')
                    ->numeric(),
                TextEntry::make('compagny.name')->badge()->default('N/A')
                    ->numeric(),
                TextEntry::make('created_at')->badge()->default('N/A')
                    ->dateTime(),
                TextEntry::make('updated_at')->badge()->default('N/A')
                    ->dateTime(),
            ]);
    }
}
