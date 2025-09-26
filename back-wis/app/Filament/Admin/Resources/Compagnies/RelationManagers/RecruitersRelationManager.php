<?php

namespace App\Filament\Admin\Resources\Compagnies\RelationManagers;

use App\Filament\Admin\Resources\Users\Schemas\UserForm;
use App\Filament\Admin\Resources\Users\Tables\UsersTable;
use Filament\Actions\ActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DetachAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class RecruitersRelationManager extends RelationManager
{
    protected static string $relationship = 'recruiters';

    protected static ?string $recordTitleAttribute = 'email';

    public function form(Schema $schema): Schema
    {
        return UserForm::configure($schema);
    }

    public function table(Table $table): Table
    {
        $table = UsersTable::configure($table);

        return $table
            ->headerActions([
                CreateAction::make()
                    ->label('Add Recruiter')
                    ->modalHeading('Create Recruiter')
            ])
            ->recordActions([
                ActionGroup::make([
                    ViewAction::make(),
                    EditAction::make(),
                    DeleteAction::make(),
                ]),
                DetachAction::make(),
            ]);
    }
}
