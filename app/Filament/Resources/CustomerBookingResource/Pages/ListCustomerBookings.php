<?php

namespace App\Filament\Resources\CustomerBookingResource\Pages;
use App\Models\CustomerBooking;
use App\Filament\Resources\CustomerBookingResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Auth; // Add this import
use Illuminate\Database\Eloquent\Builder; // Add this import

class ListCustomerBookings extends ListRecords
{
    protected static string $resource = CustomerBookingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(), // Uncomment if you want to add create button
        ];
    }

    public function getTableQuery(): Builder
    {
        return CustomerBooking::query()
            ->where('user_id', Auth::id()) // Filter by authenticated user
            ->orderByDesc('created_at'); // Optional: Order by the most recent booking
    }
}
