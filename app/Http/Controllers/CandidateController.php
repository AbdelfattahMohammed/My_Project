<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\Employer;
use App\Models\Notification;
use App\Models\Posting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class CandidateController extends Controller
{
    public function index()
    {
        $jobPostings = Posting::where('status', 'accepted')->get();

        $candidateId = Auth::user()->candidates->id;
        $notifications = Notification::where('notifiable_id', $candidateId)
            ->where('notifiable_type', Candidate::class) // Ensure the type is Candidate::class
            ->get();

        // $notifications = Auth::user()->candidates->notifications; // Fetch notifications
        $unreadCount = Auth::user()->candidates->unreadNotifications()->count();

        return view('candidate.index', compact('jobPostings', 'notifications', 'unreadCount'));
    }

    // public function markAsRead($id)
    // {
    //     $notification = Auth::user()->candidates->notification()->find($id);

    //     if ($notification) {
    //         $notification->markAsRead();
    //         return response()->json(['success' => true]);
    //     }

    //     return response()->json(['success' => false], 404);
    // }

    public function count()
    {
        $count = Auth::user()->candidates->unreadNotifications()->count();
        dd($count);
        return response()->json(['count' => $count]);
    }




    public function portfolio($id)
    {
        $user = User::find($id);
        if ($user->role === 'employer') {
            // Get the employer details
            $employer = $user->employer->id;

            // Fetch the job postings count for the employer
            $jobPostingsCount = Posting::where('employer_id', $employer)->where('status', 'accepted')
                ->selectRaw('DATE(posted_at) as date, COUNT(*) as count')
                ->groupBy('date')
                ->orderBy('date', 'asc')
                ->get();

            $postActions = DB::table('post_actions')
                ->join('postings', 'post_actions.posting_id', '=', 'postings.id') // Join the postings table
                ->select(
                    'postings.title',
                    DB::raw('SUM(action_type = "like") as total_likes'),
                    DB::raw('SUM(action_type = "comment") as total_comments'),
                    DB::raw('SUM(action_type = "share") as total_shares')
                )
                ->where('postings.employer_id', $employer) // Filter by authenticated user's postings
                ->groupBy('postings.id', 'postings.title')
                ->get();
            $employerId = $user->employer->id;
            $employer = Employer::find($employerId);
            return view('portfolio.index', compact('user', 'employer', 'jobPostingsCount', 'postActions'));
        }

        if ($user->role === 'candidate') {
            $candidateId = $user->candidates->id;
            $candidate = Candidate::find($candidateId);
            return view('candidate.portfolio', compact('user', 'candidate'));
        }
    }

    public function employer($id)
    {
        $user = User::find($id);
        $candidateId = $user->employer->id;
        // dd($candidateId);
        $candidate = Candidate::find($candidateId);
        return view('candidate.portfolio', compact('user', 'candidate'));
    }

    // public function show($jobId)
    // {

    //     $user = User::find($jobId);

    //     if ($user->role === 'employer') {
    //         // Generate the route for employers
    //         return to_route('portfolio', $user->id);
    //     } elseif ($user->role === 'candidate') {
    //         // Generate the route for candidates
    //         return to_route('portfolio', $user->id);
    //     }
    // }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('employer.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        // Optional: invalidate the session and regenerate CSRF token
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect to a specific route after logout
        return redirect()->route('users.index');
    }

    public function search(Request $request)
    {
        $queryTerm = $request->input('query');

        // Check if query term is empty
        if (empty($queryTerm)) {
            return view('candidate.search', ['postings' => collect()]);
        }

        $postings = Posting::query()
        ->where('status', 'accepted') // Add this line to filter by status
        ->where(function ($query) use ($queryTerm) {
            $query->where('title', 'LIKE', "%{$queryTerm}%")
                ->orWhere('description', 'LIKE', "%{$queryTerm}%")
                ->orWhere('responsibilities', 'LIKE', "%{$queryTerm}%")
                ->orWhere('required_skills', 'LIKE', "%{$queryTerm}%")
                ->orWhere('location', 'LIKE', "%{$queryTerm}%")
                ->orWhere('qualifications', 'LIKE', "%{$queryTerm}%")
                ->orWhere('salary_range', 'LIKE', "%{$queryTerm}%")
                ->orWhere('work_type', 'LIKE', "%{$queryTerm}%")
                ->orWhere('benefits', 'LIKE', "%{$queryTerm}%");
        })
        ->get();

        return view('candidate.search', compact('postings'));
    }


    public function edit()
    {

        $user = Auth::user();
        $candidate = $user->candidates;

        return view('candidate.editPort', compact('user', 'candidate'));
    }

    public function update_profile(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $candidate = $user->candidates;

        $request->validate([
            'name' => 'required|string|max:255',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'resume' => 'nullable|file',
            'skills' => 'nullable|string',
            'experience_level' => 'nullable|string',
            'location' => 'nullable|string',
            'contact_info' => 'nullable|string',
        ]);

        $user->name = $request->input('name');

        if ($request->hasFile('profile_picture')) {
            if ($user->profile_picture) {
                Storage::delete('public/' . $user->profile_picture);
            }
            $path = $request->file('profile_picture')->store('user_images', 'public');
            $user->profile_picture = $path;
        }

        $user->save();

        if ($request->hasFile('resume')) {
            if ($candidate->resume) {
                Storage::delete('public/' . $candidate->resume);
            }
            $path = $request->file('resume')->store('resume', 'public');
            $candidate->resume = $path;
        }

        $candidate->skills  = $request->input('skills');
        $candidate->experience_level = $request->input('experience_level');
        $candidate->location = $request->input('location');
        $contactInfo = $request->input('contact_info');
        $contactInfo = str_replace([',', ' '], "\n", $contactInfo);
        $candidate->contact_info = $contactInfo;

        $candidate->save();

        return redirect()->route('portfolio', $user->id)->with('success', 'Profile updated successfully');
    }

    public function showChangePasswordForm()
    {
        return view('candidate.change_password');
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

        return redirect()->route('candidate.index')->with('success', 'Password changed successfully.');
    }

    public function about()
    {
        return view('about');
    }
}
