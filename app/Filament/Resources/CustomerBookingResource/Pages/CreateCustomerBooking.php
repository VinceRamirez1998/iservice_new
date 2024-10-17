<?php

namespace App\Filament\Resources\CustomerBookingResource\Pages;

use App\Filament\Resources\CustomerBookingResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCustomerBooking extends CreateRecord
{
    protected static string $resource = CustomerBookingResource::class;
}
