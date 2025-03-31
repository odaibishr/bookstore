<?php

namespace App\Filament\Widgets;

use App\Models\Category;
use App\Models\Publisher;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AuthorStats extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('الناشرون', Publisher::count())
                ->description('عدد الناشرين المتوفرين في المكتبة')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('danger'),
            Stat::make('المستخدمين', User::count())
                ->description('عدد المستخدمين المتوفرين في المكتبة')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('gray'),
        ];
    }
}
