<?php

namespace App\Filament\Widgets;

use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use App\Models\Publisher;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class BookStats extends BaseWidget
{
    protected static ?int $sort = -3;


    protected static bool $isLazy = false;
    
    protected function getStats(): array
    {
        return [
            Stat::make('الكتب', Book::count())
                ->description('عدد الكتب المتوفرة في المكتبة')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('primary'),
            Stat::make('المؤلفين', Author::count())
                ->description('عدد المؤلفين المتوفرين في المكتبة')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('gray'),
            Stat::make('الاصناف', Category::count())
                ->description('عدد التصنيفات المتوفرة في المكتبة')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('warning'),
            // Stat::make('الناشرون', Publisher::count())
            //     ->description('عدد الناشرين المتوفرين في المكتبة')
            //     ->chart([7, 2, 10, 3, 15, 4, 17])
            //     ->color('danger'),
        ];
    }
}
