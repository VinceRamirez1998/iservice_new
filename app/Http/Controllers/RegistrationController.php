<?php


namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Role; // Add this line
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegistrationController extends Controller
{
    // Method to show the registration form
    public function showRegistrationForm()
    {
        return view('auth.register'); // Adjust to your Blade template path
    }   

    public function pending()
    {
        $user = Auth::user(); // Retrieve the authenticated user
    
        // Ensure the user is authenticated and has a pending status
        if ($user->status === 'pending' || $user->status === 'approved') {
            return view('auth.pending', ['user' => $user]);
        }
    
        // Redirect to home or show an error if not pending
        return redirect('/')->with('error', 'Account status not pending or user not authenticated.');
    }
    

    public function register(Request $request)
    {
        // Debugging: Log the incoming request data
        Log::info('Incoming registration request:', $request->all());

        // Define default validation rules
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:20',
            'gender' => 'required|string',
            'role' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ];

        // Add conditional rules based on the role
        if ($request->role === 'provider') {
            $rules['service'] = 'required|string';
            $rules['complete_address'] = 'required|string';
            $rules['primary_id'] = 'required|file|image|max:2048';
            $rules['secondary_id'] = 'required|file|image|max:2048';
            $rules['certification'] = 'required|file|image|max:2048';
        } else {
            $rules['service'] = 'nullable|string';
            $rules['complete_address'] = 'nullable|string'; 
            $rules['primary_id'] = 'nullable|file|image|max:2048';
            $rules['secondary_id'] = 'nullable|file|image|max:2048';
            $rules['certification'] = 'nullable|file|image|max:2048';
        }


        // Validate the request
        $validatedData = $request->validate($rules);

        // Retrieve the role ID from the roles table
        $role = Role::where('id', $request->role)->first();
        if (!$role) {
            return redirect()->back()->withErrors(['role' => 'Invalid role selected.']);
        }

        // Debugging: Log validation success and processed data
        Log::info('Validated data:', $validatedData);
                                            
        // Handle file uploads             
        $primaryIdPath = $request->file('primary_id') ? $request->file('primary_id')->store('', 'public') : null;
        $secondaryIdPath = $request->file('secondary_id') ? $request->file('secondary_id')->store('', 'public') : null;
        $certificationPath = $request->file('certification') ? $request->file('certification')->store('', 'public') : null;
        

        // Debugging: Log file paths
        Log::info('File paths:', [
            'primary_id' => $primaryIdPath,
            'secondary_id' => $secondaryIdPath,
            'certification' => $certificationPath
        ]);

        // Create user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'gender' => $request->gender,
            'role' => $request->role,
            'service' => $request->role === '3' ? '1' : ($request->input('service') ?? 'Not Applicable'),
            'complete_address' => $request->role === '2' ? $request->complete_address : ($request->role === '3' ? $request->complete_address : null),
            'primary_id' => $primaryIdPath,
            'secondary_id' => $secondaryIdPath,
            'certification' => $certificationPath,
            'password' => Hash::make($request->password),
        ]);

        // Attach selected services if the user is a provider
        if ($request->role === '2' && $request->has('service')) {
            Log::info('Services to attach:', ['services' => $request->input('service')]);
            $user->services()->attach($request->input('service'));
        }
        
        

        // Redirect or respond
        // return redirect()->to('http://127.0.0.1:8000/pending')->with('success', 'Registration successful!');
        Auth::login($user);

        return redirect()->route('auth.pending');
    }

}
