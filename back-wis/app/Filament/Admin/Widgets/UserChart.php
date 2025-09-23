<?php

namespace App\Filament\Admin\Widgets;

use App\Models\User;
use Filament\Widgets\ChartWidget;

class UserChart extends ChartWidget
{
    protected static ?int $sort = 4;
    protected ?string $heading = 'User Chart';

    protected function getData(): array
    {
        $data = User::query()
            ->selectRaw('role, COUNT(*) as count')
            ->groupBy('role')
            ->pluck('count', 'role');

        return [
            'datasets' => [
                [
                    'label' => 'Utilisateurs par rôle',
                    'data' => $data->values(),
                    'backgroundColor' =>  ['rgb(255, 99, 132)', 'rgb(54, 162, 235)', 'rgb(255, 205, 86)'],
                ],
            ],
            'labels' => $data->keys(),
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
