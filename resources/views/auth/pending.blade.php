<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Pending</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            background-color: rgb(9, 9, 11);
        }
        .glow {
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.5);
            transition: box-shadow 0.3s ease-in-out;
        }
        .glow:hover {
            box-shadow: 0 0 20px rgba(255, 255, 255, 0.8);
        }
        .shine {
            background: linear-gradient(45deg, rgb(245, 158, 11), rgb(247, 192, 98));
            background-size: 200% 200%;
            animation: shine 3.5s infinite;
        }
        @keyframes shine {
            0% {
                background-position: -200% 0;
            }
            100% {
                background-position: 200% 0;
            }
        }
    </style>
</head>
<body class="flex items-center justify-center h-screen">
    <div style="background-color:rgb(24 24 27);" class="w-full max-w-md p-10 rounded-lg shadow-lg glow relative">
        <div class="absolute top-4 right-4">
            <button onclick="location.reload();" class="text-white hover:text-gray-400">
                <i class="fa-solid fa-rotate-right fa-lg"></i>
            </button>
        </div>
        <h2 class="text-3xl font-extrabold mb-8 text-center text-white shine mt-4">Account Pending</h2>
        <div class="text-center text-white mb-6">
            <p class="text-lg font-semibold">Account Details</p>
            <p class="mt-2">Name: {{ $user->name }}</p>
            <p>Email: {{ $user->email }}</p>
            <p>Phone: {{ $user->phone }}</p>
            <p>Role: 
    @switch($user->role)
        @case(1)
            {{ 'Admin' }}
            @break
        @case(2)
            {{ 'Provider' }}
            @break
        @case(3)
            {{ 'Customer' }}
            @break
        @default
            {{ 'Unknown Service' }}
    @endswitch
</p>
<p>Service: 
    @switch($user->service)
        @case(1)
            {{ 'Not Applicable' }}
            @break
        @case(2)
            {{ 'Appliances Services' }}
            @break
        @case(3)
            {{ 'Electrical Services' }}
            @break
        @case(4)
            {{ 'Plumbing Services' }} 
            @break
        @case(5)
            {{ 'Mechanic Services' }} 
            @break
        @default
            {{ 'Not Applicable' }}
    @endswitch
</p>




            <p>Status: 
                <span class="{{ $user->status === 'approved' ? 'text-green-400' : 'text-yellow-400' }}">
                    {{ $user->status }}
                </span>
            </p>
        </div>
        <p class="text-center text-gray-400">
            Your account is currently under review. 
        </p>
        <p class="text-center text-gray-400 mb-6">
            Please allow 1-2 days for confirmation.
        </p>
        @if($user->status === 'approved')
            <script>
                window.location.href = 'http://127.0.0.1:8000/admin/login';
            </script>
        @else
            <div class="text-center">
                <a href="{{ url()->current() }}" class="text-white hover:text-gray-400 text-sm">
                    Go Back to Homepage
                </a>
            </div>
        @endif
    </div>
</body>
</html>
