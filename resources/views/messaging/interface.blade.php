<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send Message</title>
    <style>
        /* Base styling */
        body {
            font-family: Arial, sans-serif;
            background-color: black;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 900px;
            margin: 50px auto;
            background-color: white;
            padding: 30px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        h2 {
            font-size: 26px;
            color: #333;
            margin-bottom: 30px;
            text-align: center;
        }

        .user-details {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 30px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 20px;
        }

        .user-details img {
            width: 120px;
            height: 120px;
            border-radius: 10px;
            object-fit: cover;
        }

        .user-info {
            flex: 1;
            margin-left: 30px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .user-info p {
            margin: 5px 0;
            font-size: 16px;
            color: #555;
        }

        .user-info strong {
            font-weight: bold;
            color: #333;
        }

        /* Form styling */
        .form-group {
            max-width: 870px; /* Limit form width */
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 10px;
            color: #333;
        }

        .form-group textarea {
            width: 100%;
            padding: 15px;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 5px;
            resize: vertical;
        }

        .form-group textarea:focus {
            outline: none;
            border-color: #FBBF24; /* Custom yellow color for focus */
        }

        /* Button styling */
        .btn-primary {
            background-color: #EA7B1B; /* Orange-400 color */
            color: white;
            padding: 12px 25px;
            font-size: 18px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-align: center;
            transition: background-color 0.3s ease;
            width: 100%;
            max-width: 200px;
            margin: 0 auto;
        }

        .btn-primary:hover {
            background-color: #C95A1B; /* Darker shade for hover */
        }

        .btn-primary:focus {
            outline: none;
            box-shadow: 0 0 5px #FBBF24;
        }

        /* Responsive design */
        @media (max-width: 768px) {
            .container {
                padding: 20px;
            }

            h2 {
                font-size: 22px;
            }

            .user-details {
                flex-direction: column;
                align-items: center;
                text-align: center;
            }

            .user-details img {
                margin-bottom: 15px;
            }

            .user-info {
                margin-left: 0;
            }

            .btn-primary {
                width: 100%;
            }
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Message: {{ $user->name }}</h2>

        <!-- Display user and booking details -->
        <div class="user-details">
            <img src="{{ asset('storage/' . $user->image) }}" alt="User Image"> <!-- User Image -->
            <div class="user-info">
                <p><strong>Complete Address:</strong> {{ $user->complete_address }}</p> <!-- Complete Address -->
                <p><strong>Contact:</strong> {{ $user->phone }}</p> <!-- Phone Number -->
                <p><strong>Email:</strong> {{ $user->email }}</p> <!-- Email -->
                <p><strong>Schedule:</strong> {{ \Carbon\Carbon::parse($booking->schedule)->format('d-M-Y g:i A') }}</p> <!-- Booking Schedule -->
            </div>
        </div>

        <!-- Message Form -->
        <form action="{{ route('message.send', ['userId' => $user->id, 'bookingId' => $booking->id]) }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="message">Your Message</label>
                <textarea name="message" id="message" rows="6" required></textarea>
            </div>

            <button type="submit" class="btn-primary">Send Message</button>
        </form>
    </div>

</body>
</html>
