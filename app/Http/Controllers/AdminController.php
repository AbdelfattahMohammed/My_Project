<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Application;
use App\Models\Candidate;
use App\Models\Employer;
use App\Models\Notification;
use App\Models\PostAction;
use App\Models\Posting;
use App\Models\User;
use App\Notifications\NotifyCandidateAboutNewPost;
use App\Notifications\NotifyEmployerAboutAcceptance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    //
    public function index()
    {

        $adminId = Auth::user()->admin->id;

        $jobPostings = Posting::where('status', 'accepted')->get();

        $notifications = Notification::where('notifiable_id', $adminId)
            ->where('notifiable_type', Admin::class)
            ->get();

        $unreadCount = Auth::user()->admin->unreadNotifications()->count();

        return view('admin.index', compact('jobPostings', 'unreadCount', 'notifications'));
    }

    public function portfolio($id)
    {
        $user = User::find($id);
        if ($user->role === 'employer') {
            $employerId = $user->employer->id;
            $employer = Employer::find($employerId);
            return view('admin.employerPortfolio', compact('user', 'employer'));
        }

        if ($user->role === 'candidate') {
            $candidateId = $user->candidates->id;
            $candidate = Candidate::find($candidateId);
            return view('admin.candidatePortfolio', compact('user', 'candidate'));
        }

        if ($user->role === 'admin') {
            $adminId = $user->admin->id;
            $admin = admin::find($adminId);
            return view('admin.adminPortfolio', compact('user', 'admin'));
        }
    }

    public function specificPortfolio($id)
    {
        $user = User::find($id);
        $adminId = $user->admin->id;
        $admin = admin::find($adminId);
        return view('admin.portfolio', compact('user', 'admin'));
    }

    public function accept($id)
    {
        $post = Posting::find($id);

        if ($post) {
            // Set the post status to 'accepted'
            $post->status = 'accepted';
            $post->posted_at = now();
            $post->save();

            // Notify the employer
            $employer = $post->employer; // Assuming the 'user' relation is defined for Posting -> User (Employer)
            if ($employer) {
                $employer->notify(new NotifyEmployerAboutAcceptance($post));
            }

            // Notify all candidates about the new job posting
            $candidates = Candidate::all(); // Assuming you have a 'role' field for candidates
            foreach ($candidates as $candidate) {
                $candidate->notify(new NotifyCandidateAboutNewPost($post,$candidate));
            }

            return redirect()->back()->with('success', 'Post has been accepted and notifications sent.');
        }

        return redirect()->back()->with('error', 'Post not found.');
    }

    public function refuse($id)
    {
        $post = Posting::find($id);
        if ($post) {
            $post->status = 'refused';
            $post->save();
        }
        return redirect()->back()->with('success', 'Post has been refused.');
    }

    public function block($id)
    {
        $user = User::find($id);
        if ($user->role === 'admin') {
            return redirect()->back()->with('error', 'You cannot block an admin.');
        } else {

            if ($user->role === 'employer') {

                $notifications = Notification::where('notifiable_type', Admin::class)->get();
                foreach ($notifications as $notification) {
                    $data = json_decode($notification->data, true);

                    if (isset($data['post_id'])) {
                        $postId = $data['post_id'];
                        $post = Posting::find($postId);
                        if ($post->employer->id === $user->employer->id) {
                            $notification->delete();
                        }
                    }
                }

                $notifications = Notification::where('notifiable_type', Candidate::class)->get();
                foreach ($notifications as $notification) {
                    $data = json_decode($notification->data, true);

                    if (isset($data['post_id'])) {
                        $postId = $data['post_id'];
                        $post = Posting::find($postId);
                        if ($post->employer->id === $user->employer->id) {
                            $notification->delete();
                        }
                    }
                }

                $notifications = Notification::where('notifiable_type', Employer::class)->get();
                foreach ($notifications as $notification) {
                    $data = json_decode($notification->data, true);
                    $type = $data['type'];

                    if (isset($data['post_id'])) {
                        $postId = $data['post_id'];
                        $post = Posting::find($postId);
                        if ($post->employer->id === $user->employer->id) {
                                $notification->delete();
                        }
                    }
                }

                if ($user->profile_picture) {
                    Storage::delete('public/' . $user->profile_picture);
                }

                if ($user->employer->company_logo) {
                    Storage::delete('public/' . $user->employer->company_logo);
                }
                $posts = Posting::where('employer_id', $user->employer->id)->get();
                foreach ($posts as $post) {
                    if ($post->image) {
                        Storage::delete('public/' . $post->image);
                    }
                }
            }

            if ($user->role === 'candidate') {
                $candidate = $user->candidates;

                $notifications = Notification::where('notifiable_type', Employer::class)->get();
                foreach ($notifications as $notification) {
                    $data = json_decode($notification->data, true);

                    if (isset($data['application_id'])) {
                        $applicationId = $data['application_id'];
                        $application = Application::find($applicationId);
                        if ($application->candidate->id === $user->candidates->id) {
                            $notification->delete();
                        }
                    }
                }

                $notifications = Notification::where('notifiable_type', Candidate::class)->get();
                foreach ($notifications as $notification) {
                    $data = json_decode($notification->data, true);
                    $candidateID=$data['candidate_id'];

                    if ($candidateID === $user->candidates->id) {
                        $notification->delete();
                    }
                }

                if ($user->profile_picture) {
                    Storage::delete('public/' . $user->profile_picture);
                }

                if ($candidate->resume) {
                    Storage::delete('public/' . $user->candidates->resume);
                }
                // dd($candidate);
                $applications = Application::where('candidate_id', $candidate->id)->get();
                foreach ($applications as $application)
                    if ($application->resume) {
                        Storage::delete('public/' . $application->resume);
                    }
            }
            $user->delete();
            return redirect()->back()->with('success', 'User has been blocked.');
        }
    }

    public function delete_comment($id)
    {
        $comment = PostAction::find($id);
        $comment->delete();
        return redirect()->back();
    }

    public function edit()
    {
        $user = Auth::user();
        $admin = $user->admin; // Assuming there is a relationship
        return view('admin.edit', compact('user', 'admin'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'contact_info' => 'nullable|string|max:255',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Auth::user();
        $admin = $user->admin; // Assuming there is a relationship

        /** @var \App\Models\User $user */
        $user->name = $request->input('name');
        $user->save();

        // Update admin profile details
        $admin->location = $request->input('location');
        $admin->contact_info = $request->input('contact_info');
        $admin->save();

        // Handle profile picture update
        if ($request->hasFile('profile_picture')) {
            // Delete the old picture if exists
            if ($user->profile_picture) {
                Storage::delete('public/' . $user->profile_picture);
            }

            // Store new profile picture
            $path = $request->file('profile_picture')->store('user_images', 'public');
            $user->profile_picture = $path;
            $user->save();
        }

        return redirect()->route('admin.index')->with('success', 'Profile updated successfully.');
    }

    public function showChangePasswordForm()
    {
        return view('admin.change_password');
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

        return redirect()->route('admin.index')->with('success', 'Password changed successfully.');
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

        $notifications = Notification::where('notifiable_id', Auth::user()->admin->id)
            ->where('notifiable_type', Admin::class)
            ->get();

        $unreadCount = Auth::user()->admin->unreadNotifications()->count();


        return view('admin.search', compact('postings', 'unreadCount', 'notifications'));
    }

    public function post_edit($id)
    {
        $job = Posting::find($id);
        return view('admin.update', compact('job'));
    }

    public function post_update(Request $request, $id)
    {
        // Find the job posting by ID
        $job = Posting::find($id);

        // Validate the request data
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'responsibilities' => 'required|string',
            'required_skills' => 'required|string',
            'qualifications' => 'required|string',
            'salary_range' => 'nullable|string|max:255',
            'benefits' => 'nullable|string',
            'location' => 'required|string|max:255',
            'work_type' => 'required|in:remote,on-site,hybrid',
            'application_deadline' => 'required|date',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete the old image if it exists
            if ($job->image && file_exists(storage_path('app/public/' . $job->image))) {
                unlink(storage_path('app/public/' . $job->image));
            }

            // Store the new image in the 'public/postings' directory
            $imagePath = $request->file('image')->store('postings', 'public');

            // Update the job posting with the new image path
            $job->image = $imagePath;
        }

        // Update the job posting
        $job->update([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'responsibilities' => $request->input('responsibilities'),
            'required_skills' => $request->input('required_skills'),
            'qualifications' => $request->input('qualifications'),
            'salary_range' => $request->input('salary_range'),
            'benefits' => $request->input('benefits'),
            'location' => $request->input('location'),
            'work_type' => $request->input('work_type'),
            'application_deadline' => $request->input('application_deadline'),
            'image' => $job->image ?? $job->image, // Keep existing image if not updated
        ]);

        // Redirect back with a success message
        return redirect()->route('admin.index', Auth::user()->admin->id)
            ->with('success', 'Job posting updated successfully.');
    }
}
