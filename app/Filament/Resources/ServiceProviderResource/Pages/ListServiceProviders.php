<?php

namespace App\Filament\Resources\ServiceProviderResource\Pages;

use Filament\Actions;
use App\Filament\Resources\UserResource;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\ServiceProviderResource;
use App\Filament\Resources\ServiceProviderResource\Widgets\ProcessChart;

class ListServiceProviders extends ListRecords
{
    protected static string $resource = ServiceProviderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
    protected function getHeaderWidgets(): array
    {
        return [
            ProcessChart::class,
        ];
    }
}
