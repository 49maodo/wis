<?php

namespace App\Filament\Admin\Resources\CodeLists\Tables;

use App\Models\CodeList;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class CodeListsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultGroup('type')
            ->defaultSort('type')
            ->persistSortInSession()
            ->striped()
            ->columns([
//                TextColumn::make('type')
//                    ->searchable(),
                TextColumn::make('type')
                    ->label('Type')
                    ->formatStateUsing(fn ($state) => CodeList::TYPES[$state] ?? $state)
                    ->badge()
                    ->searchable()
                    ->sortable(),
//                TextColumn::make('value')
//                    ->searchable(),
                TextColumn::make('value')
                    ->searchable()
                    ->sortable()
                    ->copyable(),
//                TextColumn::make('description')
//                    ->searchable(),
                TextColumn::make('description')
                    ->label('Description')
                    ->searchable()
                    ->limit(50)
                    ->wrap(),
                IconColumn::make('active')
                    ->boolean()
                    ->sortable(),
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
                SelectFilter::make('type')
                    ->options(CodeList::TYPES)
                    ->label('Type'),

                Filter::make('active')
                    ->label('Statut')
                    ->default('All'),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    BulkAction::make('activate')
                        ->label('Activate')
                        ->icon('heroicon-o-check-circle')
                        ->action(fn ($records) => $records->each->update(['active' => true]))
                        ->deselectRecordsAfterCompletion()
                        ->successNotification(
                            Notification::make()
                                ->success()
                                ->title('Enabled elements')
                        ),
                    BulkAction::make('deactivate')
                        ->label('Deactivate')
                        ->icon('heroicon-o-x-circle')
                        ->action(fn ($records) => $records->each->update(['active' => false]))
                        ->deselectRecordsAfterCompletion()
                        ->successNotification(
                            Notification::make()
                                ->success()
                                ->title('Disabled elements')
                        ),
                ]),
            ]);
    }
}
