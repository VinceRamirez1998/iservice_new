<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <h1 class="text-2xl font-bold">Contact Us</h1>
                <nav class="space-x-4">
                    <a href="{{ route('contact') }}" class="text-gray-700 hover:text-blue-500">Contact Us</a>
                    <a href="{{ route('faq') }}" class="text-gray-700 hover:text-blue-500">FAQ</a>
                    <a href="{{ route('about') }}" class="text-gray-700 hover:text-blue-500">About Us</a>
                </nav>
            </div>
        </div>
    </header>

    <main class="py-10">
        @yield('content')
    </main>
</body>
</html>
