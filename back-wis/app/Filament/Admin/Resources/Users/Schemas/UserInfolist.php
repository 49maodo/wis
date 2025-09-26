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
                TextEntry::make('firstname'),
                TextEntry::make('name'),
                TextEntry::make('email')
                    ->label('Email address'),
                TextEntry::make('email_verified_at')
                    ->dateTime(),
                TextEntry::make('phoneNumber'),
                TextEntry::make('role')
                    ->badge()
                    ->color(fn (UserRole|string $state): string => match ($state) {
                        UserRole::USER => 'primary',
                        UserRole::RECRUITER => 'success',
                        UserRole::ADMIN => 'danger',
                        default => 'secondary',
                    }),
                TextEntry::make('compagny_id')
                    ->numeric(),
                TextEntry::make('created_at')
                    ->dateTime(),
                TextEntry::make('updated_at')
                    ->dateTime(),
            ]);
    }
}
