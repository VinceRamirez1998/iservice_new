<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class RegistrationController extends Controller
{
    // Method to show the registration form
    public function showRegistrationForm()
    {
        return view('auth.register'); // Adjust to your Blade template path
    }

    // Method to handle form submission
    public function register(Request $request)
    {
        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:20',
            'gender' => 'required|string',
            'role' => 'required|string',
            'service' => 'nullable|string',
            'complete_address' => 'nullable|string',
            'primary_id' => 'nullable|file|image|max:2048',
            'secondary_id' => 'nullable|file|image|max:2048',
            'certification' => 'nullable|file|image|max:2048',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Handle file uploads
        $primaryIdPath = $request->file('primary_id') ? $request->file('primary_id')->store('uploads') : null;
        $secondaryIdPath = $request->file('secondary_id') ? $request->file('secondary_id')->store('uploads') : null;
        $certificationPath = $request->file('certification') ? $request->file('certification')->store('uploads') : null;

        // Create user
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'gender' => $request->gender,
            'role' => $request->role,
            'service' => $request->service,
            'complete_address' => $request->complete_address,
            'primary_id' => $primaryIdPath,
            'secondary_id' => $secondaryIdPath,
            'certification' => $certificationPath,
            'password' => Hash::make($request->password),
        ]);

        // Redirect or respond
        return redirect()->to('http://127.0.0.1:8000/admin/login')->with('success', 'Registration successful!');
    }
}
