<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\MyBooking;
use Illuminate\Http\Request;
use App\Models\CustomerBooking;
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
        // Validate incoming request data
        $request->validate([
            'schedule' => 'required|date', // Validate schedule as required date
        ]);
    
        // Fetch the service provider
        $serviceProvider = ServiceProvider::findOrFail($id);
        $user = Auth::user(); // Get the authenticated user
    
        // Get the service provider ID to avoid passing null
        $service_provider_id = $serviceProvider->id;
    
        // Fetch the user_id from the service provider (this links the provider to a user)
        $service_provider_user_id = $serviceProvider->user_id; // This is the user_id of the provider
    
        // Create the booking in MyBooking ONLY for the customer (authenticated user)
        $myBooking = MyBooking::create([
            'user_id' => Auth::id(), // Authenticated user's ID (customer)
            'service_provider_id' => $service_provider_id,  // Use the actual service provider ID
            'name' => $serviceProvider->name,  // Name from the service provider
            'image' => $serviceProvider->image,  // Image from the service provider
            'email' => $serviceProvider->email,  // Email from the service provider
            'phone' => $serviceProvider->phone, // Phone from the service provider
            'gender' => $serviceProvider->gender,  // Gender from the service provider
            'primary_id' => $serviceProvider->primary_id,
            'secondary_id' => $serviceProvider->secondary_id,  
            'certification' => $serviceProvider->certification,  
            'subscription_plan' => $serviceProvider->subscription_plan, 
            'subscription_duration' => $serviceProvider->subscription_duration,  
            'rating' => $serviceProvider->rating,
            'complete_address' => $serviceProvider->complete_address,  // Address from the service provider
            'role' => $serviceProvider->role, // The role of the service provider
            'service' => $serviceProvider->service, // The service being booked
            'approval' => 'pending', // Set default status for new bookings
            'schedule' => $request->schedule, // The schedule for the booking
        ]);
    
        // Create the customer booking for the provider's user in the CustomerBooking table
        $customerBooking = CustomerBooking::create([
            'user_id' => $service_provider_user_id, // Use the service provider's user_id (linked to provider's user)
            'service_provider_id' => $service_provider_id,  // Use the actual service provider ID
            'name' => $user->name,  // Name of the authenticated user (customer)
            'image' => $user->image ?? 'default_image_path.png',  // Fallback to a default image if user doesn't have one
            'email' => $user->email,  // Use the authenticated user's email
            'phone' => $user->phone, // Use the authenticated user's phone
            'gender' => $user->gender,  // Use the authenticated user's gender
            'complete_address' => $user->complete_address,  // Use the user's complete address
            'role' => 'Customer', // Set role to Customer
            'service' => $serviceProvider->service, // The service being booked (related to provider)
            'approval' => 'pending', // Set default status for new bookings
            'schedule' => $request->schedule, // The schedule for the booking
        ]);
    
        // Redirect the user with a success message
        return redirect()->route('filament.admin.resources.my-bookings.index')->with('success', 'Booking sent to: ' . $serviceProvider->name);
    }
    
    public function getTableQuery(): Builder
    {
        // Ensure that only the bookings for the authenticated user are visible
        return MyBooking::query()
            ->where('user_id', Auth::id()) // Filter by authenticated user
            ->orderByDesc('created_at'); // Optional: Order by the most recent booking
    }
}
