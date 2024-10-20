<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Service Provider</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> <!-- Font Awesome CDN -->
    <style>
        body {
            background-color: #222831; /* Dark background */
            color: #333; /* Darker text color for better contrast */
            font-family: Arial, sans-serif; /* Clean sans-serif font */
            margin: 0;
            padding: 20px; /* Padding around the body */
            display: flex; /* Flexbox for centering */
            justify-content: center; /* Center horizontally */
            align-items: center; /* Center vertically */
            height: 100vh; /* Full viewport height */
        }

        .booking-container {
            max-width: 1200px; /* Wider for landscape view */
            width: 90%; /* Responsive width */
            background-color: white; /* Container background */
            padding: 30px; /* Padding for better spacing */
            border-radius: 12px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1); /* Softer shadow */
            display: flex; /* Use flex for layout */
            gap: 20px; /* Space between items */
        }

        .service-image {
            flex: 1; /* Allow the image section to take available space */
            text-align: center; /* Center the image */
        }

        .booking-info {
            flex: 1; /* Allow the booking info section to take available space */
            border: 1px solid #ddd; /* Border around the info */
            padding: 20px; /* Padding inside the booking info */
            border-radius: 8px; /* Rounded corners */
            display: flex; /* Use flexbox for layout */
            flex-direction: column; /* Stack items vertically */
            gap: 10px; /* Space between items */
        }

        .booking-container h1 {
            font-size: 2rem; /* Heading size */
            margin-bottom: 10px; /* Reduced margin */
            color: #222; /* Darker color for heading */
        }

        .booking-container img {
            width: 300px; /* Fixed width for the image */
            height: auto; /* Maintain aspect ratio */
            border-radius: 8px; /* Rounded corners for the image */
            border: 1px solid #ddd; /* Light border color */
            object-fit: cover; /* Ensure the image covers the area */
        }

        .booking-container p {
            margin-bottom: 8px; /* Spacing between paragraphs */
            font-size: 1rem; /* Adjusted font size for better readability */
            line-height: 1.5; /* Improved line height */
        }

        .certification-preview {
    margin-top: 30px;
    background-color: #f4f7fc;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    color: #333;
    font-family: 'Arial';
}

.certification-preview h3 {
    font-size: 1.5rem;
    font-weight: 600;
    margin-bottom: 20px;
    color: black;
    border-bottom: 2px solid #dfe3e8;
    padding-bottom: 10px;
}

.certification-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 0;
    border-bottom: 1px solid #eaecef;
}

.certification-item:last-child {
    border-bottom: none;
}

.certification-item strong {
    font-size: 1.1rem;
    color: rgb(48, 47, 47);
}

.certification-item .preview {
    display: flex;
    align-items: center;
    color: black;
    font-weight: 500;
    text-transform: uppercase;
    font-size: 0.9rem;
    cursor: pointer;
    transition: color 0.3s ease;
}

.certification-item .preview:hover {
    color: rgb(243, 143, 29);
}

.certification-item .preview i {
    margin-left: 6px;
}

.certification-item .id-thumbnail {
    max-width: 40px; /* Set a max width for the thumbnails */
    max-height: 40px; /* Set a max height for the thumbnails */
    object-fit: cover; /* Maintain the aspect ratio of the image */
    margin-right: 10px; /* Add space between the image and the text */
    border-radius: 4px; /* Optional: Add rounded corners for a refined look */
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1); /* Add a subtle shadow */
}




        .booking-container button {
            background-color: #222831; /* Button color */
            color: white; /* Text color */
            padding: 12px 30px; /* Button padding */
            border: none; /* No border */
            border-radius: 5px; /* Rounded corners */
            font-size: 1.1rem; /* Font size */
            font-weight: bold; /* Bold font */
            text-transform: uppercase; /* Uppercase text */
            cursor: pointer; /* Pointer cursor */
            transition: background-color 0.3s, transform 0.2s; /* Smooth transition */
            margin-top: 20px; /* Margin for button */
            width: 100%; /* Full width for button */
        }

        .booking-container button:hover {
            background-color: black; /* Darker shade on hover */
            transform: scale(1.05); /* Slight zoom effect */
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
            background-color: #222831; /* Dark background */
            border: solid 1px white;
            color: white; /* White text */
            padding: 15px; /* Padding for alert */
            border-radius: 10px; /* Rounded corners */
            z-index: 10; /* Sit on top */
            display: none; /* Hidden by default */
        }

        .alert.show {
            display: block; /* Show alert */
        }

        /* Schedule selection styles */
        .schedule-selection {
            margin-top: 20px; /* Space above schedule selection */
            display: flex; /* Use flexbox */
            flex-direction: column; /* Stack items vertically */
            gap: 10px; /* Space between items */
        }

        .schedule-selection label {
            font-weight: bold; /* Bold label */
        }

        .schedule-selection input[type="datetime-local"] {
            padding: 10px; /* Padding for input */
            border-radius: 5px; /* Rounded corners for input */
            border: 1px solid #ddd; /* Border color */
            font-size: 1rem; /* Font size */
        }
    </style>
</head>
<body>
    <div class="booking-container">
        <!-- Success Alert -->
        @if (session('success'))
            <div class="alert show">
                <i class="fas fa-paper-plane" style="margin-right: 5px;"></i> <!-- Airplane icon -->
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
            
            <!-- Preview for IDs and Certification -->
            <div class="certification-preview">
                <h3>Uploaded IDs</h3>
                <div class="certification-item">
                    <strong>Primary ID:</strong>
                    <span class="preview" data-img="{{ asset('storage/' . $serviceProvider->primary_id) }}">
                        <img src="{{ asset('storage/' . $serviceProvider->primary_id) }}" alt="Primary ID" class="id-thumbnail">
                        <i class="fas fa-eye"></i> View
                    </span>
                </div>
                <div class="certification-item">
                    <strong>Secondary ID:</strong>
                    <span class="preview" data-img="{{ asset('storage/' . $serviceProvider->secondary_id) }}">
                        <img src="{{ asset('storage/' . $serviceProvider->secondary_id) }}" alt="Secondary ID" class="id-thumbnail">
                        <i class="fas fa-eye"></i> View
                    </span>
                </div>
                <div class="certification-item">
                    <strong>Certification:</strong>
                    <span class="preview" data-img="{{ asset('storage/' . $serviceProvider->certification) }}">
                        <img src="{{ asset('storage/' . $serviceProvider->certification) }}" alt="Certification" class="id-thumbnail">
                        <i class="fas fa-eye"></i> View
                    </span>
                </div>
            </div>
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
            

                 <!-- Form for Booking -->
                <form action="{{ route('service.book.confirm', $serviceProvider->id) }}" method="POST">
                    @csrf
                    <!-- Schedule Selection -->
                    <div class="schedule-selection">
                        <label for="schedule">Select Schedule:</label>
                        <input type="datetime-local" id="schedule" name="schedule" required>
                    </div>
                    <button type="submit">Confirm Booking</button>
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
