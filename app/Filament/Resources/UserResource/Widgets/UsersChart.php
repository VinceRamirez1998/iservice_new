<?php

namespace App\Filament\Resources\UserResource\Widgets;

use App\Models\Service;
use App\Models\Subscription;
use App\Models\ServiceProvider;
use App\Models\User; // Import the User model
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class UsersChart extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Users', User::count()) // Total Users stat
                ->icon('heroicon-o-users') // User icon
                ->color('primary') // Green color for success
                ->description('The total number of registered users'), // Optional description
            
            Stat::make('Providers', ServiceProvider::count()) // Active Providers stat
                ->icon('heroicon-o-briefcase') // Briefcase icon
                ->color('primary') // Blue color for primary
                ->description('Active providers offering services'),

            Stat::make('Service Categories', Service::count()) // Total Service Categories stat
                ->icon('heroicon-o-tag') // Tag icon for categories
                ->color('primary') // Yellow color for warning
                ->description('Total categories of services available'),

            Stat::make('Active Subscriptions', Subscription::count()) // Active Subscriptions stat
                ->icon('heroicon-o-check-circle') // Check circle icon for subscriptions
                ->color('primary') // Info color
                ->description('Subscriptions currently active'),
        ];
    }
}
