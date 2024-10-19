<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\MyBooking;
use App\Models\Message;
use App\Http\Resources\MessageResource;
use Illuminate\Http\Request;

class MessagingController extends Controller
{
    // Display the messaging form
    public function show($userId, $bookingId)
    {
        // Fetch the user and booking data
        $user = User::findOrFail($userId);
        $booking = MyBooking::findOrFail($bookingId);

       // Fetch all messages related to the booking and user in chronological order
            $messages = Message::where('booking_id', $bookingId)
            ->where(function($query) use ($userId) {
                $query->where('sender_id', $userId)
                    ->orWhere('receiver_id', $userId);
            })
            ->orderBy('created_at', 'asc') // Order by created_at in ascending order
            ->get();

        // Return the messaging view with the user, booking, and messages
        return view('messaging.interface', compact('user', 'booking', 'messages'));
    }

    // Handle sending the message
    public function send(Request $request, $userId, $bookingId)
    {
        // Validate the message input
        $request->validate([
            'message' => 'required|string',
        ]);

        // Create and save the new message
        $message = new Message();
        $message->sender_id = auth()->id();  // Assume the logged-in user is the sender
        $message->receiver_id = $userId;     // The recipient user
        $message->booking_id = $bookingId;   // The associated booking
        $message->content = $request->input('message');
        $message->save();

        // Respond with the newly created message using the resource
        return new MessageResource($message);
    }

    // Get all messages for a booking
    public function getMessages($bookingId)
    {
        $messages = Message::where('booking_id', $bookingId)
                           ->latest()
                           ->get();

        return MessageResource::collection($messages);
    }
}
