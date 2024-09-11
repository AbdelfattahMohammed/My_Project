<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\Employer;
use App\Models\Notification;
use App\Models\Posting;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;



class EmployerController extends Controller
{

    public function edit()
    {

        return view('employer.edit');
    }

    public function show($employer)
    {

        $employer = Auth::user()->employer;

        if (!$employer) {
            return redirect()->back();
        }
        $jobs = Posting::where('employer_id', $employer->id)
        ->where('status', 'accepted')
        ->get();

        $notifications = Notification::where('notifiable_id', $employer->id)
            ->where('notifiable_type', Employer::class)
            ->get();

        $unreadCount = Auth::user()->employer->unreadNotifications()->count();

        return view('jobs.postingshow', compact('jobs','unreadCount','notifications'));
    }

    public function index()
{
    // Get the current authenticated employer's ID
    $employer = Auth::user()->employer;
    $employerId = $employer->id;

    // Retrieve job postings that are accepted and not posted by the current employer
    $jobPostings = Posting::where('employer_id', '!=', $employerId)
        ->where('status', 'accepted')
        ->get();

    // Retrieve notifications for the current employer
    $notifications = Notification::where('notifiable_id', $employerId)
        ->where('notifiable_type', Employer::class)
        ->latest() // Retrieve the most recent notifications first
        ->get();

    // Count unread notifications
    $unreadCount = $employer->unreadNotifications()->count();

    // Pass data to the view
    return view('employer.index', compact('jobPostings', 'unreadCount', 'notifications'));
}


    public function create()
    {

        return view('employer.create');
    }

    public function logout(Request $request)
    {

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('users.index');
    }

    public function update(Request $request)
    {

        /** @var \App\Models\User $user */
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'company_name' => 'nullable|string|max:255',
            'company_description' => 'nullable|string|max:1000',
            'website' => 'nullable|url|max:255',
            'contact_info' => 'nullable|string|max:1000',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'company_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user->name = $request->input('name');
        if ($request->hasFile('profile_picture')) {
            if ($user->profile_picture) {
                Storage::delete('public/' .$user->profile_picture);
            }

            $path = $request->file('profile_picture')->store('user_images', 'public');
            $user->profile_picture = $path;
        }
        $user->save();

        $user->employer->contact_info = $request->input('contact_info');
        $user->employer->company_name = $request->input('company_name');
        $user->employer->company_description = $request->input('company_description');
        $user->employer->website = $request->input('website');


        if ($request->hasFile('company_logo')) {
            if ($user->employer->company_logo) {
                Storage::delete('public/' .$user->employer->company_logo);
            }

            $path = $request->file('company_logo')->store('company_logos', 'public');
            $user->employer->company_logo = $path;
        }

        $user->employer->save();
        return redirect()->route('portfolio',Auth::user()->id)->with('success', 'Profile updated successfully.');
    }

    public function showChangePasswordForm()
    {
        return view('employer.change_password');
    }

    // Handle Password Change
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();

        // Check if the current password is correct
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'The current password is incorrect.']);
        }

        // Update the password
        /** @var \App\Models\User $user */
        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->route('employer.index')->with('success', 'Password changed successfully.');
    }

    public function notifyAcceptance($id,$id2)
    {
        $job=Posting::find($id);
        if(Auth::user()->role == 'employer'){
            $notification = DatabaseNotification::where('id', $id2)
                ->where('notifiable_type', Employer::class)
                ->firstOrFail();
            $notification->markAsRead();
            return view('employer.postingAcceptance',compact('job'));
        }
        else{
            $notification = DatabaseNotification::where('id', $id2)
                ->where('notifiable_type', Candidate::class)
                ->firstOrFail();
            $notification->markAsRead();
            return view('candidate.postingAcceptance',compact('job'));
        }
    }
}
