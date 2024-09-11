<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Candidate;
use App\Models\Employer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('login');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('register');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $employerCode = '123';
        $adminCode = '456';

        // Validate common fields
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|string|in:candidate,employer,admin',
            'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'contact_info' => 'nullable|string',
        ]);

        // Validate role-specific data
        if ($request->role === 'candidate') {
            $request->validate([
                'resume' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
                'skills' => 'nullable|string|max:255',
                'experience_level' => 'nullable|string|max:255',
                'location' => 'nullable|string|max:255',
            ]);
        } elseif ($request->role === 'employer') {
            $request->validate([
                'company_name' => 'required|string|max:255',
                'employer_code' => ['required', Rule::in([$employerCode])],
                'company_logo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
                'company_description' => 'nullable|string|max:1000',
                'website' => 'nullable|string|max:255|url',
            ]);
        } elseif ($request->role === 'admin') {
            $request->validate([
                'admin_code' => ['required', Rule::in([$adminCode])],
                'location' => 'nullable|string|max:255',
            ]);
        }

        // If validation passes, then handle profile picture upload
        $profilePicturePath = null;
        if ($request->hasFile('profile_picture')) {
            $profilePicturePath = $request->file('profile_picture')->store('user_images', 'public');
        }

        // Create a new user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'profile_picture' => $profilePicturePath,
        ]);

        // Handle role-specific data
        if ($request->role === 'candidate') {
            // Handle resume upload
            $resumePath = null;
            if ($request->hasFile('resume')) {
                $resumePath = $request->file('resume')->store('resume/', 'public');
            }

            Candidate::create([
                'user_id' => $user->id,
                'resume' => $resumePath,
                'skills' => $request->skills,
                'experience_level' => $request->experience_level,
                'location' => $request->location,
                'contact_info' => $request->contact_info,
            ]);
        } elseif ($request->role === 'employer') {
            // Handle company logo upload
            $companyLogoPath = null;
            if ($request->hasFile('company_logo')) {
                $companyLogoPath = $request->file('company_logo')->store('company_logos', 'public');
            }

            Employer::create([
                'user_id' => $user->id,
                'company_name' => $request->company_name,
                'company_logo' => $companyLogoPath,
                'company_description' => $request->company_description,
                'website' => $request->website,
                'contact_info' => $request->contact_info,
            ]);
        } elseif ($request->role === 'admin') {
            Admin::create([
                'user_id' => $user->id,
                'location' => $request->location,
                'contact_info' => $request->contact_info,
            ]);
        }

        return view('login');
    }

    public function showChangePasswordForm()
    {
        return view('change_password');
    }

    // Handle Password Change
    public function changePassword(Request $request)
{
    // Validate input
    $request->validate([
        'email' => 'required|string|email|max:255',
        'current_password' => 'required',
        'new_password' => 'required|min:8|confirmed',
    ]);

    // Find the user by email
    $user = User::where('email', $request->email)->first();

    // Check if the user exists
    if (!$user) {
        return back()->withErrors(['email' => 'The provided email does not match any account.']);
    }

    // Check if the current password is correct
    if (!Hash::check($request->current_password, $user->password)) {
        return back()->withErrors(['current_password' => 'The current password is incorrect.']);
    }

    // Update the password
    $user->password = Hash::make($request->new_password);
    $user->save();

    // Redirect to the login page with success message
    return redirect()->route('users.index')->with('success', 'Password changed successfully.');
}

}
