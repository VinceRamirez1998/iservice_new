<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <script src="https://cdn.tailwindcss.com"></script>
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

        .required:after {
            content: '*';
            color: red;
            margin-left: 4px;
        }
    </style>
</head>
<body>

    @include('partials.header') <!-- Include your header here -->

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <form method="POST" action="" style="background-color: rgb(24, 24, 27);" class="w-full p-10 rounded-lg shadow-lg glow">
            @csrf
            <h2 class="text-3xl font-bold text-white mb-6 text-center pb-2">Get in Touch</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-300 required">Full Name</label>
                    <input id="name" type="text" name="name" required style="background-color: rgb(24, 24, 27);" class="mt-1 block w-full px-4 py-2 border border-gray-600 rounded-md text-white shadow-sm focus:outline-none focus:ring-2 focus:ring-white glow">
                </div>
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-300 required">Email Address</label>
                    <input id="email" type="email" name="email" required style="background-color: rgb(24, 24, 27);" class="mt-1 block w-full px-4 py-2 border border-gray-600 rounded-md text-white shadow-sm focus:outline-none focus:ring-2 focus:ring-white glow">
                </div>
            </div>
            <div class="mb-4">
                <label for="message" class="block text-sm font-medium text-gray-300 required">Message</label>
                <textarea id="message" name="message" rows="4" required style="background-color: rgb(24, 24, 27);" class="mt-1 block w-full px-4 py-2 border border-gray-600 rounded-md text-white shadow-sm focus:outline-none focus:ring-2 focus:ring-white glow"></textarea>
            </div>
            <div class="flex items-center justify-center">
                <button type="submit" style="background-color: rgb(245, 158, 11);" class="w-full text-white px-4 py-3 rounded-md shadow-md hover:bg-blue-700 transition duration-300 glow">Send Message</button>
            </div>
        </form>
    </div>

    @include('partials.footer') 

</body>
</html>
