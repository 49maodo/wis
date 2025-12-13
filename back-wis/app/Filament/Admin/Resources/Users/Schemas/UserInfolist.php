<?php

namespace App\Filament\Admin\Resources\Users\Schemas;

use App\Enums\UserRole;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class UserInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('firstname')->badge()->default('N/A'),
                TextEntry::make('name')->badge()->default('N/A'),
                TextEntry::make('email')->badge()->default('N/A')
                    ->label('Email address'),
                TextEntry::make('email_verified_at')->badge()->default('N/A')
                    ->dateTime(),
                TextEntry::make('phoneNumber')->badge()->default('N/A'),
                TextEntry::make('role')
                    ->badge()
                    ->color(fn (UserRole|string $state): string => match ($state) {
                        UserRole::USER => 'primary',
                        UserRole::RECRUITER => 'success',
                        UserRole::ADMIN => 'danger',
                        default => 'secondary',
                    }),
                TextEntry::make('compagny.name')->label('Company')->badge()->default('N/A'),
                TextEntry::make('created_at')->badge()->default('N/A')
                    ->dateTime(),
                TextEntry::make('updated_at')->badge()->default('N/A')
                    ->dateTime(),
            ]);
    }
}
