<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Service Provider</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> <!-- Font Awesome CDN -->
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
            padding: 20px 30px; /* Increased padding for better spacing, left and right */
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
            margin-left: 50px; /* Add margin to the left */
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
            border: 1px solid black; /* Border color matching the theme */
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
            background-color: #222831; /* Button color */
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
            background-color: black; /* Darker shade on hover */
        }

        .certification-preview {
            margin-top: 20px; /* Space above the certification preview */
            background-color: #222831; /* Light background for visibility */
            padding: 15px; /* Padding for the preview box */
            border-radius: 8px; /* Rounded corners for the preview box */
            width: 100%; /* Full width */
            color:white;
            text-align: left; /* Align text to the left */
        }

        /* Align icon and text in preview */
        .preview {
            display: flex; /* Use flexbox */
            align-items: center; /* Center vertically */
            cursor: pointer; /* Change cursor to pointer */
            color:gray;
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
            background-color: rgba(0,0,0,0.8); /* Black with opacity */
            padding: 20px; /* Padding around modal content */
        }

        .modal-content {
            position: absolute; /* Use absolute positioning */
            top: 50%; /* Position from the top */
            left: 50%; /* Position from the left */
            transform: translate(-50%, -50%); /* Center the modal */
            margin: auto; /* Centering modal content */
            max-width: 500px; /* Maximum width of the modal */
            width: 100%; /* Full width */
            overflow: hidden; /* Hide overflow */
            border-radius: 10px; /* Rounded corners for modal */
        }

        .modal-content img {
            width: 100%; /* Make image responsive */
            height: auto; /* Maintain aspect ratio */
            border-radius: 10px; /* Rounded corners for the image */
            max-height: 300px; /* Set a maximum height */
        }

        .close {
            color: white;
            position: absolute; /* Position close button */
            top: 10px;
            right: 25px;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer; /* Pointer cursor */
        }

        .close:hover,
        .close:focus {
            color: #bbb;
            text-decoration: none;
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
                <h3 style="display: flex; justify-content: center;">UPLOADED ID's</h3>
                <p>
                    <strong style="color: white;">Primary ID:</strong>
                    <span class="preview" data-img="{{ asset('storage/' . $serviceProvider->primary_id) }}">
                        <i class="fas fa-eye"></i> View
                    </span>
                </p>
                <p>
                   <strong style="color: white;">Secondary ID:</strong>
                    <span class="preview" data-img="{{ asset('storage/' . $serviceProvider->secondary_id) }}">
                        <i class="fas fa-eye"></i> View
                    </span>
                </p>
                <p>
                   <strong style="color: white;">Certification:</strong>
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
            <img id="modalImage" style="width:100%;">
        </div>
    </div>

    <script>
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
