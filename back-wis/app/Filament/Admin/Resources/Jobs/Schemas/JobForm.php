<?php

namespace App\Filament\Admin\Resources\Jobs\Schemas;

use App\Enums\ExperienceLevel;
use App\Enums\JobType;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class JobForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required(),
                TextInput::make('description')
                    ->required(),
                Textarea::make('requirements')
                    ->columnSpanFull(),
                TextInput::make('salary')
                    ->numeric(),
                Select::make('experienceLevel')
                    ->options(ExperienceLevel::class)
                    ->required(),
                TextInput::make('location'),
                Select::make('jobtype')
                    ->options(JobType::class)
                    ->required(),
                TextInput::make('creatorId')
                    ->required()
                    ->numeric(),
                Select::make('compagny_id')
                    ->relationship('compagny', 'name')
                    ->required(),
            ]);
    }
}
