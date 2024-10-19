<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send Message</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        /* Overall container styling */
        body{
            background-color: black;
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: white;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        /* User details section styling */
        .user-details {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }

        .user-details img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin-right: 15px;
        }

        .user-info {
            flex-grow: 1;

        }

        .user-info p {
            margin: 5px 0;
            font-size: 14px;
            color: #555;
        }

        /* Messages display area */
        #messages {
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 10px;
            background-color: #f9f9f9;
            height: 300px; /* Fixed height for scroll */
            overflow-y: auto; /* Scroll when there are too many messages */
            margin-bottom: 20px;
        }

        .message {
            padding: 8px 0;
            border-bottom: 1px solid #eee;
            color: #555;
        }

        .message:last-child {
            border-bottom: none;
        }

        .message strong {
            font-weight: bold;
        }

        /* Styling the message form */
        .form-group {
            max-width: 780px;
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            font-size: 14px;
            color: #333;
            margin-bottom: 5px;
        }

        .form-group textarea {
            width: 100%;
            padding: 10px;
            font-size: 14px;
            border-radius: 5px;
            border: 3px solid #fbbf24;
            resize: none;
            min-height: 80px;
        }

        button {
            display: block;
            padding: 10px 20px;
            background-color: #e8a804;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            width: 100%;
            margin-top: 10px;
        }

        button:hover {
            background-color: #fbbf24;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Message</h2>

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
                    <strong>{{ $message->sender_id == auth()->id() ? 'You' : $user->name }}:</strong> {{ $message->content }}
                </div>
            @endforeach
        </div>

        <!-- Message Form -->
        <form id="messageForm">
            @csrf
            <div class="form-group">
                <label for="message">Your Message</label>
                <textarea name="message" id="message" rows="5" placeholder="Type your message here..." required></textarea>
            </div>

            <button type="submit" class="btn-primary">Send Message</button>
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

                $.ajax({
                    type: 'POST',
                    url: '{{ route("message.send", ["userId" => $user->id, "bookingId" => $booking->id]) }}',
                    data: $(this).serialize(), // Send the form data
                    success: function(message) {
                        // Append the new message to the messages div
                        $('#messages').append('<div class="message"><strong>You:</strong> ' + message.content + '</div>');

                        // Scroll to bottom after appending the message
                        scrollToBottom();

                        // Clear the textarea
                        $('#message').val('');
                    },
                    error: function(xhr) {
                        // Handle errors
                        console.error('Error:', xhr.responseText);
                    }
                });
            });
        });
    </script>
</body>
</html>
