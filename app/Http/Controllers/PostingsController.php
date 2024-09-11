<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Application;
use App\Models\Employer;
use App\Models\Posting;
use App\Models\JobSearch;
use App\Models\Notification;
use App\Models\User;
use App\Notifications\NewPostNotification;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Auth;


class PostingsController extends Controller
{
    // public function index(Request $request)
    // {
    //     // Get search parameters
    //     $keywords = $request->input('keywords');
    //     $location = $request->input('location');
    //     $category = $request->input('category');

    //     // Query jobs based on search parameters
    //     $query = JobSearch::query();

    //     if ($keywords) {
    //         $query->where('title', 'like', "%{$keywords}%")
    //               ->orWhere('description', 'like', "%{$keywords}%");
    //     }

    //     if ($location) {
    //         $query->where('location', $location);
    //     }

    //     if ($category) {
    //         $query->where('category', $category);
    //     }

    //     $jobs = $query->get();

    //     return view('jobs.index', compact('jobs'));
    // }

    // Display a single job posting
    // public function show(JobSearch $job)
    // {
    //     $jobs= Posting::find($job);
    //     dd($jobs);
    //     return view('jobs.show', compact('jobs'));
    // }

    public function create()
    {
        return view('jobs.create');
    }

    public function open($id, $id2)
    {
        $post = Posting::find($id);

        $applications = Application::where('job_id',$id)->get();

        $notification = DatabaseNotification::where('id', $id2)
        ->where('notifiable_type', Employer::class)
        ->firstOrFail();
        $notification->markAsRead();
        $unreadCount = Auth::user()->employer->unreadNotifications()->count();

        return view('jobs.open', compact('post', 'applications'));
    }

    public function application($id)
    {
        $post = Posting::find($id);

        return view('candidate.postApplication', compact('post'));
    }

    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        // Get the authenticated employer
        $employer = Auth::user()->employer;

        // Create and save the new post
        $post = new Posting();
        $post->employer_id = $employer->id;
        $post->title = $request->input('title');
        $post->description = $request->input('description');
        $post->application_deadline = $request->input('application_deadline');
        $post->work_type = $request->input('work_type');
        $post->location = $request->input('location');
        $post->benefits = $request->input('benefits');
        $post->salary_range = $request->input('salary_range');
        $post->qualifications = $request->input('qualifications');
        $post->required_skills = $request->input('required_skills');
        $post->responsibilities = $request->input('responsibilities');
        if($request->hasFile('image')){
            $imagePath = $request->file('image')->store('postings','public');
            $post->image=$imagePath;
        }
        $post->save();

        // Retrieve all admins
        $admins = Admin::all();

        // Notify all admins
        foreach ($admins as $admin) {
            $admin->notify(new NewPostNotification($post));
        }

        // Redirect to employer index
        return redirect()->route('employer.index');
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

    return view('jobs.search', compact('postings'));
}


    public function destroy($id)
    {
        $post = Posting::find($id);
        $post->delete();
        return redirect()->route('employer.show');
    }

    public function edit($id)
    {
        $job = Posting::find($id);
        return view('jobs.update', compact('job'));
    }

    public function update(Request $request, $id)
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
        return redirect()->route('employer.show', Auth::user()->employer->id)
            ->with('success', 'Job posting updated successfully.');
    }


    public function list($id)
    {

        $admin = Auth::user()->admin->id;

        $posts = Posting::whereNull('status')->get();

        $notifications = Notification::where('notifiable_id', $admin)
            ->where('notifiable_type', Admin::class)
            ->update(['read_at' => now()]);

        return view('admin.postsList', compact('posts'));
    }
}
