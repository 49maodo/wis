<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Application;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class ApplicationChart extends ChartWidget
{
    protected static ?int $sort = 3;
    protected ?string $heading = 'Application Chart';

    protected function getData(): array
    {
        $data = Trend::model(Application::class)
            ->between(
                start: now()->startOfYear(),
                end: now()->endOfYear(),
            )
            ->perMonth()
            ->count();

        return [
            'datasets' => [
                [
                    'label' => 'Blog posts',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => $value->date),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
