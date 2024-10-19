<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\MyBooking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MessagingController extends Controller
{
    // Display the messaging form
    public function show($userId, $bookingId)
    {
        $user = User::findOrFail($userId);
        $booking = MyBooking::findOrFail($bookingId);

        return view('messaging.interface', compact('user', 'booking'));
    }

    // Handle sending the message
    public function send(Request $request, $userId, $bookingId)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $user = User::findOrFail($userId);
        $messageContent = $request->input('message');

        // Example: Send an email (you can customize this as needed)
        Mail::raw($messageContent, function ($message) use ($user) {
            $message->to($user->email)
                    ->subject('New Message Regarding Your Booking');
        });

        return redirect()->route('filament.admin.resources.my-bookings.index')
                         ->with('success', 'Message sent to: ' . $user->name);
    }
}
