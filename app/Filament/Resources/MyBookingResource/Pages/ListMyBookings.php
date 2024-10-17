<?php

namespace App\Filament\Resources\MyBookingResource\Pages;

use App\Filament\Resources\MyBookingResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Notifications\Notification; // Make sure to import Notification

class ListMyBookings extends ListRecords
{
    protected static string $resource = MyBookingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }

    public function mount(): void // Change this to public
    {
        parent::mount();

        // Display the flash message if it exists
        if (session('success')) {
            Notification::make()
                ->title(session('success'))
                ->success()
                ->send();
        }
    }
}
