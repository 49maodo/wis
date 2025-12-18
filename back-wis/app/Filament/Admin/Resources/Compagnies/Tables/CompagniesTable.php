<?php

namespace App\Filament\Admin\Resources\Compagnies\Tables;

use App\Enums\VerificationStatus;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CompagniesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('logo')
                    ->default('https://placehold.co/400')
                    ->searchable(),
                TextColumn::make('name')
                    ->limit(15)
                    ->searchable(),
                TextColumn::make('description')
                    ->default('N/A')
                    ->limit(20)
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (VerificationStatus|string $state): string => match ($state) {
                        VerificationStatus::PENDING => 'warning',
                        VerificationStatus::APPROVED => 'success',
                        VerificationStatus::REJECTED => 'danger',
                        default => 'secondary',
                    })
                    ->searchable(),
                TextColumn::make('website')
                    ->default('N/A')
                    ->searchable(),
                TextColumn::make('location')
                    ->default('N/A')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
