<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send Message</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        /* Body and container styling */
        body {
            background-color: #202020;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
        }

        .container {
            max-width: 800px;
            margin: 40px auto;
            padding: 30px;
            border: 1px solid #ddd;
            border-radius: 10px;
            background-color: white;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
        }

        /* Header styling */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .header h2 {
            font-size: 1.75rem;
            font-weight: 600;
            color: #333;
        }

        .close-button {
            background-color: #e8a804;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            color: white;
            font-size: 14px;
            cursor: pointer;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .close-button:hover {
            background-color: #fbbf24;
        }

        /* User details styling */
        .user-details {
            display: flex;
            align-items: center;
            margin-bottom: 30px;
            border-bottom: 1px solid #eee;
            padding-bottom: 20px;
        }

        .user-details img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            margin-right: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .user-info p {
            margin: 5px 0;
            font-size: 14px;
            color: #555;
        }

        /* Messages display */
        #messages {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            background-color: #f9f9f9;
            height: 300px;
            overflow-y: auto;
            margin-bottom: 20px;
        }

        /* Individual message styling */
        .message {
            padding: 10px 0;
            border-bottom: 1px solid #eee;
            color: #555;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .message:last-child {
            border-bottom: none;
        }

        .message strong {
            font-weight: bold;
        }

        /* Message status */
        .message-status {
            font-size: 13px;
            color: #888;
            margin-left: 10px;
        }

        .message-status.read {
            color: green;
        }

        .message-status.unread {
            color: red;
        }

        .message-status.sending {
            color: orange;
        }

        .message-status.sent {
            color: orange;
        }

        .message-status.delivered {
            color: purple;
        }

        /* Message form styling */
        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            font-size: 14px;
            color: #333;
            margin-bottom: 10px;
            display: block;
        }

        .form-group textarea {
            width: 100%;
            max-width: 100%; /* Ensures textarea doesn't extend beyond the container */
            padding: 15px;
            font-size: 14px;
            border-radius: 8px;
            border: 3px solid #fbbf24;
            min-height: 100px;
            box-sizing: border-box; /* Ensures padding is included in width calculation */
        }


        button {
            display: block;
            width: 100%;
            padding: 12px;
            background-color: #e8a804;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background-color: #fbbf24;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header with close button -->
        <div class="header">
            <h2>Message</h2>
        
            @if(auth()->user()->role == 2)
                <!-- If the user has role 2, use customer bookings route -->
                <a href="{{ route('filament.admin.resources.customer-bookings.index') }}" class="close-button">Close</a>
            @else
                <!-- For other roles, use my bookings route -->
                <a href="{{ route('filament.admin.resources.my-bookings.index') }}" class="close-button">Close</a>
            @endif
        </div>
        

        <!-- User details section -->
        <div class="user-details">
            <img src="{{ asset('storage/' . $user->image) }}" alt="User Image">
            <div class="user-info">
                <p><strong>Complete Address:</strong> {{ $user->complete_address }}</p>
                <p><strong>Contact:</strong> {{ $user->phone }}</p>
                <p><strong>Email:</strong> {{ $user->email }}</p>
                <p><strong>Schedule:</strong> {{ \Carbon\Carbon::parse($booking->schedule)->format('d-M-Y g:i A') }}</p>
            </div>
        </div>

        <!-- Messages display -->
        <div id="messages">
            @foreach($messages as $message)
                <div class="message">
                    <div>
                        <strong>{{ $message->sender_id == auth()->id() ? 'You' : $user->name }}:</strong> {{ $message->content }}
                    </div>
                    <div class="message-status {{ $message->status }}">{{ ucfirst($message->status) }}</div>
                </div>
            @endforeach
        </div>

        <!-- Message form -->
        <form id="messageForm">
            @csrf
            <div class="form-group">
                <label for="message">Your Message</label>
                <textarea name="message" id="message" rows="5" placeholder="Type your message here..." required></textarea>
            </div>

            <button type="submit">Send Message</button>
        </form>
    </div>

    <script>
        $(document).ready(function() {
            // Scroll to the bottom of the messages container
            function scrollToBottom() {
                $('#messages').scrollTop($('#messages')[0].scrollHeight);
            }

            // Initial scroll to bottom when page loads
            scrollToBottom();

            $('#messageForm').on('submit', function(e) {
                e.preventDefault(); // Prevent the default form submission

                // Append the message with "sending" status before the message is actually sent
                var messageContent = $('#message').val();
                $('#messages').append('<div class="message"><div><strong>You:</strong> ' + messageContent + '</div><div class="message-status sending">Sending...</div></div>');

                // Scroll to bottom after appending the message
                scrollToBottom();

                $.ajax({
                    type: 'POST',
                    url: '{{ route("message.send", ["userId" => $user->id, "bookingId" => $booking->id]) }}',
                    data: $(this).serialize(), // Send the form data
                    success: function(response) {
                        // Update the message status to 'sent' once the message is successfully sent
                        $('#messages').find('.message:last-child .message-status').text('Sent').removeClass('sending').addClass('sent');

                        // Scroll to bottom after updating the message status
                        scrollToBottom();

                        // Clear the textarea
                        $('#message').val('');
                    },
                    error: function(xhr) {
                        // Handle errors
                        console.error('Error:', xhr.responseText);

                        // Update status to error
                        $('#messages').find('.message:last-child .message-status').text('Failed').removeClass('sending').addClass('unread');
                    }
                });
            });
        });
    </script>
</body>
</html>
