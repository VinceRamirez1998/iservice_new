<?php

namespace App\Http\Controllers;

use App\Models\MyBooking;
use Illuminate\Http\Request;
use App\Models\ServiceProvider;
use Illuminate\Support\Facades\Auth;

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

        $booking = MyBooking::create([
            'user_id' => Auth::id(), // Authenticated user's ID
            'name' => $serviceProvider->name,  // Name from the request
            'image' => $serviceProvider->image,  // Name from the request
            'email' => $serviceProvider->email,  // Email from the request
            'phone' => $serviceProvider->phone, // Phone from the request
            'gender' => $serviceProvider->gender,  // Gender from the request
            'primary_id' => $serviceProvider->primary_id,
            'secondary_id' => $serviceProvider->secondary_id,  
            'certification' => $serviceProvider->certification,  
            'subscription_plan' => $serviceProvider->subscription_plan, 
            'subscription_duration' => $serviceProvider->subscription_duration,  
            'rating' => $serviceProvider->rating,
            'complete_address' => $serviceProvider->complete_address,  // Address from the request
            'role' => $serviceProvider->role, // The role of the service provider
            'service' => $serviceProvider->service, // The service being booked
            'approval' => $serviceProvider->approval, // Default status for new bookings
        ]);

        // Redirect the user with a success message
        // return redirect()->route('/dashboard', $id)->with('success', 'Booking sent to: ' . $serviceProvider->name);

        return redirect()->route('filament.admin.resources.my-bookings.index')->with('success', 'Booking sent to: ' . $serviceProvider->name);

    }

}
