<?php

namespace App\Filament\Admin\Resources\CompagnyVerifications\Tables;

use App\Enums\VerificationStatus;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CompagnyVerificationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('compagny.name')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('compagny.owner.email', )
                    ->label('Submitted By')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (VerificationStatus|string $state): string => match ($state) {
                        VerificationStatus::APPROVED => 'primary',
                        VerificationStatus::PENDING => 'success',
                        VerificationStatus::REJECTED => 'danger',
                        default => 'secondary',
                    })
                    ->searchable(),
                TextColumn::make('ninea')
                    ->searchable(),
                TextColumn::make('rccm')
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
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
