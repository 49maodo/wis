<?php

namespace App\Filament\Admin\Resources\Compagnies\Schemas;

use App\Enums\VerificationStatus;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class CompagnyInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name')->badge(),
                TextEntry::make('description')->badge()->default('N/A'),
                TextEntry::make('status')
                    ->badge()
                    ->color(fn (VerificationStatus|string $state): string => match ($state) {
                        VerificationStatus::PENDING => 'primary',
                        VerificationStatus::APPROVED => 'success',
                        VerificationStatus::REJECTED => 'danger',
                        default => 'secondary',
                    }),
                TextEntry::make('website')->badge()->default('N/A'),
                TextEntry::make('location')->badge()->default('N/A'),
                ImageEntry::make('logo')
                    ->default('N/A')
                    ->imageHeight(50)
                    ->circular()
                    ->disk('public'),
                TextEntry::make('created_at')->badge()
                    ->dateTime(),
                TextEntry::make('updated_at')->badge()
                    ->dateTime(),
            ]);
    }
}
