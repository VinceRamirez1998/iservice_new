<?php

namespace App\Http\Controllers;

use App\Models\ServiceProvider;
use Illuminate\Http\Request;

class ServiceBookingController extends Controller
{
    public function book($id)
    {
        $serviceProvider = ServiceProvider::findOrFail($id);
    
        // Map the role to a human-readable format
        $role = match ($serviceProvider->role) {
            '1' => 'Admin',
            '2' => 'Provider',
            '3' => 'Customer',
            default => 'Unknown',
        };
    
        // Map the service to a human-readable format
        $service = match ($serviceProvider->service) {
            '1' => 'N/A',
            '2' => 'Appliances Services',
            '3' => 'Electrical Services',
            '4' => 'Plumbing Services',
            '5' => 'Mechanic Services',
            default => 'Unknown',
        };
    
        return view('booking.confirmation', [
            'serviceProvider' => $serviceProvider,
            'role' => $role, // Pass the evaluated role
            'service' => $service, // Pass the evaluated service
        ]);
    }
    

        public function confirmBooking(Request $request, $id)
    {
        // Fetch the service provider
        $serviceProvider = ServiceProvider::findOrFail($id);

        // Here you can handle the actual booking logic
        // For example, you can save a booking record to the database

        // Redirect the user with a success message
        return redirect()->route('book.service', $id)->with('success', 'Booking sent to: ' . $serviceProvider->name);
    }

}
