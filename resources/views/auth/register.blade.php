<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Custom Glowing and Shining Effects */
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

        .hidden {
            display: none;
        }

        /* Style for asterisks */
        .required:after {
            content: '*';
            color: red;
            margin-left: 4px;
            display: none; /* Initially hidden */
        }

        .required.invalid:after {
            display: inline; /* Show asterisk when invalid */
        }
    </style>
</head>
<body class="flex flex-col items-center">
    <!-- Include Header -->
    @include('partials.header')
    <div style="background-color:rgb(24 24 27);" class="w-full max-w-4xl p-10 rounded-lg shadow-lg glow">
        <h2 class="text-3xl font-extrabold mb-8 text-center text-white shine">Create Your Account</h2>
        <form id="registration-form" method="post" action="{{ route('register.post') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Role Selection -->
            <div class="mb-6">
                <label class="block text-xl font-bold text-white mb-4">Register as</label>
                <div class="flex gap-6">
                    <!-- Customer Radio Button -->
                    <label for="customer" class="flex items-center cursor-pointer p-4 border rounded-lg shadow-lg transition-transform transform hover:scale-105 hover:shadow-xl">
                        <input id="customer" type="radio" name="role" value="customer" checked
                               class="hidden peer"
                               onclick="toggleFormFields('customer')" required>
                        <div class="w-6 h-6 flex items-center justify-center border rounded-full bg-black peer-checked:bg-orange-500 peer-checked:border-orange-300">
                            <i class="fas fa-user text-gray-800 peer-checked:text-white"></i>
                        </div>
                        <span class="ml-3 text-gray-800 peer-checked:text-white">Customer</span>
                    </label>
        
                    <!-- Services Provider Radio Button -->
                    <label for="provider" class="flex items-center cursor-pointer p-4 border rounded-lg shadow-lg transition-transform transform hover:scale-105 hover:shadow-xl">
                        <input id="provider" type="radio" name="role" value="provider"
                               class="hidden peer"
                               onclick="toggleFormFields('provider')" required>
                        <div class="w-6 h-6 flex items-center justify-center border rounded-full bg-black peer-checked:bg-orange-500 peer-checked:border-orange-300">
                            <i class="fas fa-cogs text-gray-800 peer-checked:text-white"></i>
                        </div>
                        <span class="ml-3 text-gray-800 peer-checked:text-white">Services Provider</span>
                    </label>
                </div>
            </div>

            <!-- Common Fields for Both Roles -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-300 required">Full Name</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                       autocomplete="name"
                       class="mt-1 block w-full px-4 py-2 border border-gray-600 rounded-md bg-gray-700 text-white shadow-sm glow focus:outline-none focus:ring-2 focus:ring-white focus:border-white">
                @error('name')
                    <span class="text-red-400 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-300 required">Email Address</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required
                       autocomplete="email"
                       class="mt-1 block w-full px-4 py-2 border border-gray-600 rounded-md bg-gray-700 text-white shadow-sm glow focus:outline-none focus:ring-2 focus:ring-white focus:border-white">
                @error('email')
                    <span class="text-red-400 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div id="customer-fields" class="hidden space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-300 required">Contact No.</label>
                        <input id="phone" type="tel" name="phone" value="{{ old('phone') }}" required
                               autocomplete="tel"
                               class="mt-1 block w-full px-4 py-2 border border-gray-600 rounded-md bg-gray-700 text-white shadow-sm glow focus:outline-none focus:ring-2 focus:ring-white focus:border-white">
                        @error('phone')
                            <span class="text-red-400 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="gender" class="block text-sm font-medium text-gray-300 required">Gender</label>
                        <select id="gender" name="gender" required
                                autocomplete="gender"
                                class="mt-1 block w-full px-2 py-2 border border-gray-600 rounded-md bg-gray-700 text-white shadow-sm glow focus:outline-none focus:ring-2 focus:ring-white focus:border-white">
                            <option value="" disabled selected>Select a gender</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-300 required">Password</label>
                        <input id="password" type="password" name="password" required
                               autocomplete="new-password"
                               class="mt-1 block w-full px-4 py-2 border border-gray-600 rounded-md bg-gray-700 text-white shadow-sm glow focus:outline-none focus:ring-2 focus:ring-white focus:border-white">
                        @error('password')
                            <span class="text-red-400 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-300 required">Confirm Password</label>
                        <input id="password_confirmation" type="password" name="password_confirmation" required
                               autocomplete="new-password"
                               class="mt-1 block w-full px-4 py-2 border border-gray-600 rounded-md bg-gray-700 text-white shadow-sm glow focus:outline-none focus:ring-2 focus:ring-white focus:border-white">
                    </div>
                </div>
            </div>

            <div id="provider-fields" class="hidden space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="service" class="block text-sm font-medium text-gray-300">Service Role</label>
                        <select id="service" name="service" 
                                autocomplete="organization"
                                class="mt-1 block w-full px-2 py-2 border border-gray-600 rounded-md bg-gray-700 text-white shadow-sm glow focus:outline-none focus:ring-2 focus:ring-white focus:border-white">
                            <option value="" disabled selected>Select a service role</option>
                            <option value="appliances">Appliances Services</option>
                            <option value="electrical">Electrical Services</option>
                            <option value="plumbing">Plumbing Services</option>
                            <option value="mechanic">Mechanic Services</option>
                        </select>
                    </div>

                    <div>
                        <label for="complete_address" class="block text-sm font-medium text-gray-300">Complete Address</label>
                        <input id="complete_address" type="text" name="complete_address" value="{{ old('complete_address') }}"
                               autocomplete="address"
                               class="mt-1 block w-full px-4 py-2 border border-gray-600 rounded-md bg-gray-700 text-white shadow-sm glow focus:outline-none focus:ring-2 focus:ring-white focus:border-white">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label for="primary_id" class="block text-sm font-medium text-gray-300">Upload Primary ID</label>
                        <input id="primary_id" type="file" name="primary_id" accept="image/*"
                               class="mt-1 block w-full px-4 py-2 border border-gray-600 rounded-md bg-gray-700 text-white shadow-sm glow focus:outline-none focus:ring-2 focus:ring-white focus:border-white">
                    </div>

                    <div>
                        <label for="secondary_id" class="block text-sm font-medium text-gray-300">Upload Secondary ID</label>
                        <input id="secondary_id" type="file" name="secondary_id" accept="image/*"
                               class="mt-1 block w-full px-4 py-2 border border-gray-600 rounded-md bg-gray-700 text-white shadow-sm glow focus:outline-none focus:ring-2 focus:ring-white focus:border-white">
                    </div>

                    <div>
                        <label for="certification" class="block text-sm font-medium text-gray-300">Upload Certification</label>
                        <input id="certification" type="file" name="certification" accept="image/*"
                               class="mt-1 block w-full px-4 py-2 border border-gray-600 rounded-md bg-gray-700 text-white shadow-sm glow focus:outline-none focus:ring-2 focus:ring-white focus:border-white">
                    </div>
                </div>
            </div>

            <!-- Register Button -->
            <div class="flex items-center justify-center">
                <button type="submit" style="background-color: rgb(245, 158, 11);" class="w-full text-white px-4 py-3 rounded-md shadow-md hover:bg-blue-700 transition duration-300 glow">Register</button>
            </div>

            <!-- Redirect to Login -->
            <div class="text-center">
                <a href="{{ url('/admin/login') }}" class="text-gray-400 hover:text-orange-300 text-sm">
                    Already have an account? Login
                </a>
            </div>
        </form>
    </div>

    <script>
    function toggleFormFields(role) {
        const providerFields = document.getElementById('provider-fields');
        const customerFields = document.getElementById('customer-fields');
        if (role === 'provider') {
            providerFields.classList.remove('hidden');
            customerFields.classList.add('hidden');
        } else if (role === 'customer') {
            providerFields.classList.add('hidden');
            customerFields.classList.remove('hidden');
        } else {
            providerFields.classList.add('hidden');
            customerFields.classList.add('hidden');
        }
    }

    document.getElementById('registration-form').addEventListener('submit', function(event) {
        if (!validateForm()) {
            event.preventDefault(); // Prevent form submission if validation fails
        }
    });

    // Initialize form based on default selection
    toggleFormFields(document.querySelector('input[name="role"]:checked').value);
</script>
</body>
</html>
