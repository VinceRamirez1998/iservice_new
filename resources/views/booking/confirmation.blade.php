<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Service Provider</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> <!-- Font Awesome CDN -->
    <style>
        body {
            background-color: #222831; /* Light gray background */
            color: #333; /* Darker text color for better contrast */
            font-family: Arial, sans-serif; /* Clean sans-serif font */
            height: 100vh; /* Full viewport height */
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
            padding: 0;
        }

        .booking-container {
            text-align: left; /* Align text to the left */
            max-width: 1200px; /* Wider for landscape view */
            width: 90%; /* Responsive width */
            background-color: white; /* Container background */
            padding: 30px 40px; /* Increased padding for better spacing */
            border-radius: 12px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1); /* Softer shadow */
            display: flex; /* Use flexbox for layout */
            flex-direction: row; /* Arrange items in a row for landscape */
            align-items: flex-start; /* Align items at the top */
            position: relative; /* Needed for z-index to take effect */
        }

        .service-image {
            flex: 0 0 350px; /* Fixed width for the image */
            text-align: center; /* Center the image */
            margin-right: 20px; /* Space between image and info */
        }

        .booking-info {
            flex: 1; /* Take remaining space */
            max-width: 600px; /* Limit width for information */
        }

        .booking-container h1 {
            font-size: 2rem; /* Slightly smaller heading size */
            margin-bottom: 10px; /* Reduced margin */
            color: #222; /* Darker color for heading */
        }

        .booking-container img {
            width: 100%; /* Make image responsive */
            height: auto; /* Maintain aspect ratio */
            border-radius: 8px; /* Rounded corners for the image */
            border: 1px solid #ddd; /* Light border color */
            object-fit: cover; /* Ensure the image covers the area */
            max-height: 300px; /* Max height for image */
        }

        .booking-container p {
            margin-bottom: 8px; /* Spacing between paragraphs */
            font-size: 1rem; /* Adjusted font size for better readability */
            line-height: 1.5; /* Improved line height */
        }

        .booking-container .info-section {
            margin-bottom: 20px; /* Space before the button */
        }

        .booking-container button {
            background-color: #222831; /* LinkedIn blue */
            color: white; /* Text color on the button */
            padding: 12px 30px; /* Button padding */
            border: none; /* No border */
            border-radius: 5px; /* Rounded corners */
            font-size: 1.1rem; /* Font size */
            font-weight: bold; /* Bold font */
            text-transform: uppercase; /* Uppercase text */
            cursor: pointer; /* Pointer cursor */
            transition: background-color 0.3s, transform 0.2s; /* Smooth transition */
            margin-top: 20px; /* Margin for button */
        }

        .booking-container button:hover {
            background-color: black; /* Darker shade on hover */
            transform: scale(1.05); /* Slight zoom effect */
        }

        .certification-preview {
            margin-top: 20px; /* Space above the certification preview */
            background-color: #e7f1fa; /* Light background for visibility */
            padding: 15px; /* Padding for the preview box */
            border-radius: 8px; /* Rounded corners for the preview box */
            width: 100%; /* Full width */
            color: black; /* Text color */
        }

        /* Align icon and text in preview */
        .preview {
            display: flex; /* Use flexbox */
            align-items: center; /* Center vertically */
            cursor: pointer; /* Change cursor to pointer */
            color: #385170; /* LinkedIn blue for icons */
        }

        .preview i {
            margin-right: 5px; /* Space between icon and text */
        }

        /* Modal styles */
        .modal {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 100; /* Sit on top */
            left: 0;
            top: 0;
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            background-color: rgba(0, 0, 0, 0.8); /* Black with opacity */
            padding: 20px; /* Padding around modal content */
        }

        .modal-content {
            position: absolute; /* Use absolute positioning */
            top: 50%; /* Position from the top */
            left: 50%; /* Position from the left */
            transform: translate(-50%, -50%); /* Center the modal */
            max-width: 500px; /* Maximum width of the modal */
            width: 100%; /* Full width */
            overflow: hidden; /* Hide overflow */
            border-radius: 10px; /* Rounded corners for modal */
            background-color: white; /* White background for modal */
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.2); /* Modal shadow */
        }

        .modal-content img {
            width: 100%; /* Make image responsive */
            height: auto; /* Maintain aspect ratio */
            border-radius: 10px; /* Rounded corners for the image */
        }

        .close {
            color: #333; /* Dark text for the close button */
            position: absolute; /* Position close button */
            top: 10px;
            right: 25px;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer; /* Pointer cursor */
        }

        .close:hover,
        .close:focus {
            color: #0077b5; /* Change color on hover */
            text-decoration: none;
        }

        /* Success notification styles */
        .alert {
            position: absolute; /* Position the alert absolutely */
            top: 20px; /* Space from the top */
            right: 20px; /* Space from the right */
            background-color: #4caf50; /* Green background */
            color: white; /* White text */
            padding: 15px; /* Padding for alert */
            border-radius: 5px; /* Rounded corners */
            z-index: 10; /* Sit on top */
            display: none; /* Hidden by default */
        }

        .alert.show {
            display: block; /* Show alert */
        }
    </style>
</head>
<body>
    <div class="booking-container">
        <!-- Success Alert -->
        @if (session('success'))
            <div class="alert show">
                {{ session('success') }}
            </div>
        @endif

        <div class="service-image">
            <h1>Book Service Provider</h1>
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
                <h3 style="text-align: center;">Uploaded IDs</h3>
                <p>
                    <strong>Primary ID:</strong>
                    <span class="preview" data-img="{{ asset('storage/' . $serviceProvider->primary_id) }}">
                        <i class="fas fa-eye"></i> View
                    </span>
                </p>
                <p>
                    <strong>Secondary ID:</strong>
                    <span class="preview" data-img="{{ asset('storage/' . $serviceProvider->secondary_id) }}">
                        <i class="fas fa-eye"></i> View
                    </span>
                </p>
                <p>
                    <strong>Certification:</strong>
                    <span class="preview" data-img="{{ asset('storage/' . $serviceProvider->certification) }}">
                        <i class="fas fa-eye"></i> View
                    </span>
                </p>
            </div>

            <!-- Form for Booking -->
            <form action="{{ route('service.book.confirm', $serviceProvider->id) }}" method="POST">
                @csrf
                <button type="submit">Book Now</button>
            </form>
        </div>
    </div>

    <!-- Modal for Image Preview -->
    <div id="myModal" class="modal">
        <span class="close">&times;</span>
        <div class="modal-content">
            <img id="modalImage">
        </div>
    </div>

    <script>
        // Show alert if session success is present
        const alert = document.querySelector('.alert');
        if (alert) {
            alert.classList.add('show');
            setTimeout(() => {
                alert.classList.remove('show'); // Hide after some time
            }, 3000); // Adjust time in milliseconds
        }

        // Get the modal
        var modal = document.getElementById("myModal");

        // Get the image and insert it inside the modal
        var previews = document.querySelectorAll(".preview");
        previews.forEach(function(preview) {
            preview.onclick = function() {
                var imgSrc = this.getAttribute("data-img");
                document.getElementById("modalImage").src = imgSrc;
                modal.style.display = "block"; // Show the modal
            }
        });

        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close")[0];

        // When the user clicks on <span> (x), close the modal
        span.onclick = function() {
            modal.style.display = "none"; // Hide the modal
        }

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none"; // Hide the modal
            }
        }
    </script>
</body>
</html>
