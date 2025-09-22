<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Job;
use App\Models\User;
use Filament\Widgets\ChartWidget;

class JobExperienceChart extends ChartWidget
{
    protected static ?int $sort = 5;
    protected ?string $heading = 'Job Experience Chart';

    protected function getData(): array
    {
        $data = Job::query()
            ->selectRaw('experienceLevel, COUNT(*) as count')
            ->groupBy('experienceLevel')
            ->pluck('count', 'experienceLevel');

        return [
            'datasets' => [
                [
                    'label' => 'Jobs par niveau d\'expérience',
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
