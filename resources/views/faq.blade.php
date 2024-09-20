<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Frequently Asked Questions - iService</title>
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

        .faq-item {
            background-color: rgb(24, 24, 27);
            border: 1px solid rgba(255, 255, 255, 0.1);
            overflow: hidden; /* Ensure overflow is hidden for sliding effect */
            display: flex;
            align-items: center;
            padding: 15px; /* Adjust padding as needed */
        }

        .faq-icon {
            color: wheat; /* Icon color */
            font-size: 1.5rem; /* Adjust size as needed */
            margin-right: 30px; /* Space between icon and text */
        }

        .faq-description {
            max-height: 0; /* Start with max-height of 0 */
            opacity: 0;
            transition: max-height 0.5s ease-out, opacity 0.5s ease-out; /* Transition for sliding and fading */
        }

        .faq-item:hover .faq-description {
            max-height: 100px; /* Set a max-height for expanded state */
            opacity: 1; /* Fully visible */
        }
    </style>
</head>
<body>

    @include('partials.header') <!-- Include your header here -->

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold text-white mb-6 text-center">Frequently Asked Questions</h2>
        
        <div class="space-y-4">
            <div class="faq-item rounded-lg glow">
                <i class="faq-icon fas fa-info-circle"></i>
                <div>
                    <h3 class="text-lg font-semibold text-orange-300">What is iService?</h3>
                    <p class="faq-description text-gray-300">iService is an online home service hub portal for Pampanga, connecting users with local service providers for various home services.</p>
                </div>
            </div>
            <div class="faq-item rounded-lg glow">
                <i class="faq-icon fas fa-calendar-check"></i>
                <div>
                    <h3 class="text-lg font-semibold text-orange-300">How can I book a service?</h3>
                    <p class="faq-description text-gray-300">You can book a service through our website by selecting the desired service and following the prompts to schedule an appointment.</p>
                </div>
            </div>
            <div class="faq-item rounded-lg glow">
                <i class="faq-icon fas fa-tools"></i>
                <div>
                    <h3 class="text-lg font-semibold text-orange-300">What types of services are available?</h3>
                    <p class="faq-description text-gray-300">We offer a wide range of services including cleaning, plumbing, electrical work, and more. Please check our services page for a complete list.</p>
                </div>
            </div>
            <div class="faq-item rounded-lg glow">
                <i class="faq-icon fas fa-headset"></i>
                <div>
                    <h3 class="text-lg font-semibold text-orange-300">How can I contact customer support?</h3>
                    <p class="faq-description text-gray-300">You can reach our customer support team via the contact form on our website or by emailing support@iservice.com.</p>
                </div>
            </div>
        </div>
    </div>

    @include('partials.footer') 

</body>
</html>
