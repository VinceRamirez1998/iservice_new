<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - iService</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Custom Glowing and Shining Effects */
        body {
            background-color: rgb(9, 9, 11);
        }

        .glow {
            box-shadow: 
                0 4px 30px rgba(255, 255, 255, 0.4), 
                0 8px 40px rgba(255, 255, 255, 0.3);
            transition: box-shadow 0.3s ease-in-out;
        }

        .glow:hover {
            box-shadow: 
                0 6px 40px rgba(255, 255, 255, 0.6), 
                0 12px 50px rgba(255, 255, 255, 0.5);
        }

        .about-item {
            background-color: rgb(24, 24, 27);
            border: 1px solid rgba(255, 255, 255, 0.1);
            padding: 20px;
            border-radius: 8px;
            transition: transform 0.2s, opacity 0.5s;
            opacity: 0; /* Start hidden */
            transform: translateX(-20px); /* Start slightly to the left */
            display: flex;
            align-items: center; /* Align items vertically */
        }

        .about-icon {
            margin-right: 40px;
            color: wheat; /* Icon color */
            font-size: 1.5rem; /* Adjust size as needed */
        }

        .about-item.visible {
            opacity: 1; /* Fully visible */
            transform: translateX(0); /* Move to original position */
        }

        .about-item:hover {
            transform: scale(1.05);
        }
    </style>
</head>
<body>

    @include('partials.header') <!-- Include your header here -->

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold text-white mb-6 text-center">About Us</h2>
        
        <div class="space-y-6">
            <div class="about-item glow">
                <i class="about-icon fas fa-bullseye"></i>
                <div>
                    <h3 class="text-lg font-semibold text-orange-300">Our Mission</h3>
                    <p class="text-gray-300">At iService, our mission is to connect residents of Pampanga with reliable and efficient home service providers. We strive to create a seamless experience for users, ensuring they receive top-notch service at their convenience.</p>
                </div>
            </div>
            <div class="about-item glow">
                <i class="about-icon fas fa-eye"></i>
                <div>
                    <h3 class="text-lg font-semibold text-orange-300">Our Vision</h3>
                    <p class="text-gray-300">We envision a community where every household has easy access to quality home services. By leveraging technology, we aim to make these services more accessible and efficient.</p>
                </div>
            </div>
            <div class="about-item glow">
                <i class="about-icon fas fa-thumbs-up"></i>
                <div>
                    <h3 class="text-lg font-semibold text-orange-300">Our Values</h3>
                    <p class="text-gray-300">Integrity, reliability, and customer satisfaction are the core values that guide our operations. We are committed to providing a platform where users can trust the services they receive.</p>
                </div>
            </div>
            <div class="about-item glow">
                <i class="about-icon fas fa-users"></i>
                <div>
                    <h3 class="text-lg font-semibold text-orange-300">Our Team</h3>
                    <p class="text-gray-300">Our dedicated team is composed of experienced professionals who are passionate about delivering exceptional service. We work tirelessly to ensure that both service providers and users have a positive experience on our platform.</p>
                </div>
            </div>
        </div>
    </div>

    @include('partials.footer') 

    <script>
        // JavaScript to add 'visible' class to each item in sequence
        const aboutItems = document.querySelectorAll('.about-item');
        aboutItems.forEach((item, index) => {
            setTimeout(() => {
                item.classList.add('visible');
            }, index * 450); // Adjust delay as needed
        });
    </script>
</body>
</html>
