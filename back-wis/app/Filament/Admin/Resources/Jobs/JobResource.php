<?php

namespace App\Filament\Admin\Resources\Jobs;

use App\Filament\Admin\Resources\Jobs\Pages\CreateJob;
use App\Filament\Admin\Resources\Jobs\Pages\EditJob;
use App\Filament\Admin\Resources\Jobs\Pages\ListJobs;
use App\Filament\Admin\Resources\Jobs\Pages\ViewJob;
use App\Filament\Admin\Resources\Jobs\Schemas\JobForm;
use App\Filament\Admin\Resources\Jobs\Schemas\JobInfolist;
use App\Filament\Admin\Resources\Jobs\Tables\JobsTable;
use App\Models\Job;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class JobResource extends Resource
{
    protected static ?string $model = Job::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBriefcase;
    protected static string | UnitEnum | null $navigationGroup = 'Compagnies';

    protected static ?string $recordTitleAttribute = 'yes';

    public static function getNavigationBadgeColor(): ?string
    {
        return static::getModel()::count() > 10 ? 'warning' : 'primary';
    }
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Schema $schema): Schema
    {
        return JobForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return JobInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return JobsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListJobs::route('/'),
            'create' => CreateJob::route('/create'),
            'view' => ViewJob::route('/{record}'),
            'edit' => EditJob::route('/{record}/edit'),
        ];
    }
}
