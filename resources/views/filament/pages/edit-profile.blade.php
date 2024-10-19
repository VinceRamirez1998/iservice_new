<!-- resources/views/filament/pages/edit-profile.blade.php -->

<x-filament::page>
    <style>
        /* Custom focus styles for input fields */
        input:focus {
            border-color: #fbbf24 !important; /* Tailwind's orange-800 color */
            box-shadow: 0 0 0 2px rgba(192, 86, 33, 0.5) !important; /* Optional glow effect */
            outline: none; /* Remove the default outline */
        }
    </style>

    <div class="prose max-w-full bg-white dark:bg-gray-800 text-black dark:text-white p-6 rounded-lg">
        <form wire:submit.prevent="submit" class="space-y-4">
            <div>
                <label for="name" class="block text-sm font-medium">Name</label>
                <input id="name" type="text" wire:model="formState.name" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 bg-white dark:bg-gray-800 text-black dark:text-white focus:border-orange-800 focus:ring-0">
                @error('formState.name') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="email" class="block text-sm font-medium">Email</label>
                <input id="email" type="email" wire:model="formState.email" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 bg-white dark:bg-gray-800 text-black dark:text-white focus:border-orange-800 focus:ring-0">
                @error('formState.email') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="phone" class="block text-sm font-medium">Phone</label>
                <input id="phone" type="text" wire:model="formState.phone" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 bg-white dark:bg-gray-800 text-black dark:text-white focus:border-orange-800 focus:ring-0">
                @error('formState.phone') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-medium">New Password</label>
                <input id="password" type="password" wire:model="formState.password" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 bg-white dark:bg-gray-800 text-black dark:text-white focus:border-orange-800 focus:ring-0">
                @error('formState.password') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>

            <div class="mt-4">
                <x-filament::button type="submit">Update Profile</x-filament::button>
            </div>
        </form>
    </div>
</x-filament::page>
