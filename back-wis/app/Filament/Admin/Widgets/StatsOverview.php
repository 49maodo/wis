<?php

namespace App\Filament\Admin\Widgets;

use App\Enums\VerificationStatus;
use App\Models\Compagny;
use App\Models\CompagnyVerifications;
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
            Stat::make('Taux de compagnies vérifiées', CompagnyVerifications::where('status', VerificationStatus::APPROVED)->count() . ' / ' . Compagny::count())
                ->description('Pourcentage de compagnies vérifiées')
                ->descriptionIcon('heroicon-m-check-badge')
                ->chart([CompagnyVerifications::where('status', VerificationStatus::APPROVED)->count(), CompagnyVerifications::where('status', '!==', VerificationStatus::APPROVED)->count()])
                ->color('info'),
            Stat::make('Candidatures', \App\Models\Application::count())
                ->description('Nombre total de candidatures')
                ->descriptionIcon('heroicon-m-document-text')
                ->chart(\App\Models\Application::query()->latest()->take(7)->pluck('id')->toArray())
                ->color('warning'),
        ];
    }
}
