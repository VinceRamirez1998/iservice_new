<?php

namespace App\Filament\Resources\ServiceProviderResource\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ProcessChart extends BaseWidget
{
    protected function getStats(): array
    {return [
        Stat::make('View Services', 'Step 1')
        ->color('primary') // Primary color (e.g., blue) for this step
        ->description('Start by browsing services'), // Optional description for more clarity
    
    Stat::make('Find Freelancer', 'Step 2')
        ->color('primary') // Maintain color consistency for each step
        ->description('Choose the right freelancer for the job'),
    
    Stat::make('Book Now', 'Step 3')
        ->color('primary') // Continue using the primary color
        ->description('Finalize and confirm your booking'),
    ];
    }
}
