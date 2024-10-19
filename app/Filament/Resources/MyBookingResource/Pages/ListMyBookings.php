<?php

namespace App\Filament\Resources\MyBookingResource\Pages;

use App\Models\MyBooking;
use Filament\Actions;
use Illuminate\Support\Facades\Auth;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\MyBookingResource;
use Illuminate\Database\Eloquent\Builder;
use Filament\Notifications\Notification;

class ListMyBookings extends ListRecords
{
    protected static string $resource = MyBookingResource::class;

    // Optional: Disable the creation of new records if needed
    protected function getHeaderActions(): array
    {
        return [
            // Uncomment this if you need a Create action
            // Actions\CreateAction::make(),
        ];
    }

    public function mount(): void
    {
        parent::mount();

        // Display the success flash message (if any) using Filament's notification
        if (session('success')) {
            Notification::make()
                ->title(session('success'))
                ->success()
                ->send();
        }
    }

    // Override the getTableQuery to filter bookings for the authenticated user only
    protected function getTableQuery(): Builder
    {
        return MyBooking::query()
            ->where('user_id', Auth::id())  // Filter bookings by the logged-in user
            ->orderByDesc('created_at');    // Optionally order the bookings by the latest first
    }
}
