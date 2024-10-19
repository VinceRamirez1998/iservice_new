<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Filament\Notifications\Notification;

class EditProfile extends Page
{
    protected static ?string $navigationLabel = 'Profile';
    protected static string $view = 'filament.pages.edit-profile';
    protected static ?string $navigationIcon = 'heroicon-o-user';
    protected static ?int $navigationSort = 4;

    public static function shouldRegisterNavigation(): bool
    {
        $user = Auth::user();
    
        // If there is no authenticated user, return false
        if (!$user) {
            return false;
        }
    
        // Fetch the role of the authenticated user from the 'users' table
        $role = DB::table('users')
            ->where('id', $user->id)
            ->value('role'); // Get the role column value
    
        // Check if the role is '2' or '3', otherwise handle '1'
        if (in_array($role, ['2','3'])) {
            // Show navigation for roles '2' and '3'
            return true;
        } elseif ($role == '1') {
            // Perform action for role '1' (e.g., hide the navigation)
            return false;
        }
    
        // If role is not '1', '2', or '3', default to hiding navigation
        return false;
    }

    
    public array $formState = [
        'name' => '',
        'email' => '',
        'phone' => '',
        'password' => '',
    ];

    public function mount()
    {
        // Load current user data into the form state
        $user = Auth::user();
        $this->formState = [
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'password' => '', // Password field should be empty initially
        ];
    }

    public function submit()
    {
        // Validate inputs
        $this->validate([
            'formState.name' => 'required|string|max:255',
            'formState.email' => 'required|email|max:255',
            'formState.phone' => 'required|string|max:20',
            'formState.password' => 'nullable|string|min:8',
        ]);

        // Get the authenticated user
        $user = Auth::user();

        // Prepare the data for updating
        $data = [
            'name' => $this->formState['name'],
            'email' => $this->formState['email'],
            'phone' => $this->formState['phone'],
        ];

        // Check if password is being updated
        if (!empty($this->formState['password'])) {
            $data['password'] = Hash::make($this->formState['password']); // Hash the password
        }

        // Update the user profile using the DB facade
        try {
            DB::table('users')->where('id', $user->id)->update($data);

            // Send a success notification
            Notification::make()
                ->title('Profile updated successfully.')
                ->success()
                ->send();

            // Optionally reset the form state or redirect
            $this->formState = []; // Uncomment to reset the form state after saving

        } catch (\Exception $e) {
            // Log the error and notify the user
            \Log::error('Error updating profile: ' . $e->getMessage());
            Notification::make()
                ->title('Failed to update profile.')
                ->danger()
                ->send();
        }
    }
}
