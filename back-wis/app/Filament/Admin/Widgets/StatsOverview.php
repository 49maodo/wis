<?php

namespace App\Filament\Admin\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends StatsOverviewWidget
{
    protected static ?int $sort = 2;
    protected function getStats(): array
    {
        return [
            Stat::make('Utilisateurs', \App\Models\User::count())
                ->description('Nombre total d\'utilisateurs')
                ->descriptionIcon('heroicon-m-user-group')
                ->chart(\App\Models\User::query()->latest()->take(7)->pluck('id')->toArray())
                ->color('success'),
            Stat::make('Jobs', \App\Models\Job::count())
                ->description('Nombre total de jobs')
                ->descriptionIcon('heroicon-m-briefcase')
                ->chart(\App\Models\Job::query()->latest()->take(7)->pluck('id')->toArray())
                ->color('primary'),
            Stat::make('Candidatures', \App\Models\Application::count())
                ->description('Nombre total de candidatures')
                ->descriptionIcon('heroicon-m-document-text')
                ->chart(\App\Models\Application::query()->latest()->take(7)->pluck('id')->toArray())
                ->color('warning'),
        ];
    }
}
