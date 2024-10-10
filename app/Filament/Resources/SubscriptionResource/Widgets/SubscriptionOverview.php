<?php

namespace App\Filament\Resources\SubscriptionResource\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class SubscriptionOverview extends BaseWidget
{
    protected function getStats(): array
    {return [
        Stat::make('1 Month Plan', '₱459')
        ->color('primary') // Green color for success
            ->description('Basic subscription for 1 month'),
        Stat::make('3 Month Plan', '₱1299')
        ->color('primary') // Green color for success
            ->description('Save 10% with a 3-month subscription'),
        Stat::make('6 Month Plan', '₱2399')
        ->color('primary') // Green color for success
            ->description('Best value for 6 months'),
        Stat::make('1 Year Plan', '₱3499')
        ->color('primary') // Green color for success
            ->description('Ultimate savings with a 1-year subscription'),
    ];
    }
}
