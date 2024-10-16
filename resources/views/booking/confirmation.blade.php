<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Service Provider</title>
    <style>
        body {
            background-color: black; /* Background color */
            color: black; /* Text color */
            height: 100vh; /* Full viewport height */
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
            padding: 0;
            position: relative; /* Ensure z-index works */
        }

        .booking-container {
            text-align: left; /* Align text to the left */
            max-width: 1200px; /* Wider for landscape view */
            width: 90%; /* Responsive width */
            background-color: white; /* Container background */
            padding: 20px; /* Reduced padding for better spacing */
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.5); /* More pronounced shadow */
            display: flex; /* Use flexbox for layout */
            flex-direction: row; /* Arrange items in a row for landscape */
            align-items: flex-start; /* Align items at the top */
            z-index: 99; /* Higher z-index to stay on top */
            position: relative; /* Needed for z-index to take effect */
        }

        .service-image {
            flex: 0 0 300px; /* Fixed width for the image */
            text-align: center; /* Center the image */
        }

        .booking-info {
            flex: 1; /* Take remaining space */
            max-width: 600px; /* Limit width for information */
        }

        .booking-container h1 {
            font-size: 2rem; /* Slightly smaller heading size */
            margin-bottom: 15px; /* Reduced margin */
            letter-spacing: 1px;
        }

        .booking-container img {
            width: 100%; /* Make image responsive */
            height: auto; /* Maintain aspect ratio */
            border-radius: 8px; /* Rounded corners for the image */
            border: 3px solid black; /* Border color matching the theme */
            object-fit: cover; /* Ensure the image covers the area */
            max-height: 300px; /* Max height for image */
        }

        .booking-container p {
            margin-bottom: 10px; /* Spacing between paragraphs */
            font-size: 1rem; /* Adjusted font size for better readability */
            line-height: 1.4; /* Improved line height */
            color: black; /* Text color for better contrast */
        }

        .booking-container .info-section {
            margin-bottom: 20px; /* Space before the button */
        }

        .booking-container button {
            background-color: black; /* Button color */
            color: white; /* Text color on the button */
            padding: 10px 25px; /* Button padding */
            border: none; /* No border */
            border-radius: 5px; /* Rounded corners */
            font-size: 1.1rem; /* Font size */
            font-weight: bold; /* Bold font */
            text-transform: uppercase; /* Uppercase text */
            cursor: pointer; /* Pointer cursor */
            transition: background-color 0.3s; /* Smooth transition */
            margin-top: 20px; /* Margin for button */
        }

        .booking-container button:hover {
            background-color: rgb(0, 122, 163); /* Darker shade on hover */
        }

        .certification-preview {
            margin-top: 20px; /* Space above the certification preview */
            background-color: rgba(37, 150, 190, 0.1); /* Light background for visibility */
            padding: 15px; /* Padding for the preview box */
            border-radius: 8px; /* Rounded corners for the preview box */
            width: 100%; /* Full width */
            text-align: left; /* Align text to the left */
        }
    </style>
</head>
<body>
    <div class="booking-container">
        <div class="service-image">
            <h1>Book Service Provider</h1>

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <!-- Display Service Provider's Image -->
            @if($serviceProvider->image)
            <img src="{{ asset('storage/' . $serviceProvider->image) }}" alt="{{ $serviceProvider->name }}'s Image">
            @else
                <img src="placeholder-image.jpg" alt="Placeholder Image"> <!-- Optional placeholder -->
            @endif
        </div>

        <div class="booking-info">
            <h2>{{ $serviceProvider->name }}</h2>
            <div class="info-section">
                <p><strong>Email:</strong> {{ $serviceProvider->email }}</p>
                <p><strong>Phone:</strong> {{ $serviceProvider->phone }}</p>
                <p><strong>Address:</strong> {{ $serviceProvider->complete_address }}</p>
                <p><strong>Gender:</strong> {{ $serviceProvider->gender }}</p>
                <p><strong>Role:</strong> {{ $role }}</p>
                <p><strong>Service:</strong> {{ $service }}</p>
                <p><strong>Subscription Plan:</strong> {{ $serviceProvider->subscription_plan }}</p>
                <p><strong>Status:</strong> {{ $serviceProvider->status }}</p>
                <p><strong>Rating:</strong> {{ $serviceProvider->rating }}</p>
            </div>

            <!-- Preview for IDs and Certification -->
            <div class="certification-preview">
                <h3>Preview</h3>
                <p><strong>Primary ID:</strong> {{ $serviceProvider->primary_id }}</p>
                <p><strong>Secondary ID:</strong> {{ $serviceProvider->secondary_id }}</p>
                <p><strong>Certification:</strong> {{ $serviceProvider->certification }}</p>
            </div>

            <!-- Form for Booking -->
            <form action="{{ route('service.book.confirm', $serviceProvider->id) }}" method="POST">
                @csrf
                <button type="submit">Book Now</button>
            </form>
        </div>
    </div>
</body>
</html>
