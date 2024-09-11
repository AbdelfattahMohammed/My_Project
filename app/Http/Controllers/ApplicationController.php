<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Posting;
use App\Notifications\ApplicationAccepted as NotificationsApplicationAccepted;
use App\Notifications\ApplicationSended as NotificationsApplicationSended;
use Smalot\PdfParser\Parser;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class ApplicationController extends Controller
{

    public function store(Request $request, $id)
    {
        $validatedData = $request->validate([
            'resume' => 'required|file|mimes:pdf',
            'email' => 'required|email',
            'phone' => 'required|string|max:11|min:11',
        ]);
        $applications= Application::where('candidate_id',Auth::user()->candidates->id)->get();
        foreach ($applications as $application)
        {
            if(Auth::user()->candidates->id == $application->candidate_id)
            {
                if($application->job_id == $id){
                    return redirect()->back()->with('error','You have already sent the request.');
                }
            }

        }
        $filePath = $request->file('resume')->store('resume', 'public');
        $application = new Application;
        $application->job_id = $id;
        $application->candidate_id = Auth::user()->candidates->id;
        $application->resume = $filePath;
        $application->email = $request->email;
        $application->phone = $request->phone;
        $application->save();

        // return redirect()->back()->with('success','Application sent successfully.');
        return redirect()->route('application.app',$application->id);
    }

    public function app($id)
    {
        $application = Application::findOrFail($id);
        // Create a UUID for the notification
        $notificationId = (string) Str::uuid();
        $employer=$application->posting->employer;

        // Create a new notification
        $notification = new NotificationsApplicationSended($application);

        // Assign UUID to the notification
        $notification->id = $notificationId;

        // Send a notification to the candidate
        $employer->notify($notification);

        return redirect()->route('candidate.index')->with('success', 'Application sent successfully.');
    }

    // public function show()
    // {
    //     $application=Application::all();
    //     $posts=Auth::user()->employer->posting;
    //     $applications = [];
    //     // dd($employer);
    //     foreach ($posts as $post) {
    //         foreach($application as $app){
    //             if ($post->id == $app->job_id && $app->status === null) {
    //                 $applications[] = $app;
    //             }
    //         }
    //     }
    //     return view('application.show', compact('applications'));
    // }


    public function search(Request $request,$id)
    {

        $searchTerm = $request->input('query');
        $applications = Application::where('job_id',$id)->get();
        // $applications = Application::with('candidate.user')->get(); // Eager load user details
        $matchedApplications = [];

        foreach ($applications as $application) {
            $resumePath = storage_path('app/public/' . $application->resume);

            // Check if the file exists
            if (!file_exists($resumePath)) {
                continue;
            }

            // Extract text from the PDF file
            $text = $this->extractTextFromPdf($resumePath);

            // Check if the search term is found in the extracted text
            if ($text && stripos($text, $searchTerm) !== false) {
                $matchedApplications[] = [
                    'id' => $application->id,
                    'name' => $application->candidate->user->name,
                    'email' => $application->email,
                    'phone' => $application->phone,
                    'resume' => $application->resume,
                ];
            }
        }

        return view('application.search', ['applications' => $matchedApplications]);
    }

    private function extractTextFromPdf($pdfPath)
    {
        if (!file_exists($pdfPath)) {
            return null;
        }

        $parser = new Parser();
        $pdf = $parser->parseFile($pdfPath);
        $text = $pdf->getText();

        return $text;
    }











    public function accept($id)
    {
        // Find the job application by ID
        $application = Application::findOrFail($id);

        // Update the application status to 'accepted'
        $application->status = 'accepted';
        $application->save();

        // Retrieve the candidate associated with the application
        $candidate = $application->candidate;

        // Create a UUID for the notification
        $notificationId = (string) Str::uuid();

        // Create a new notification
        $notification = new NotificationsApplicationAccepted($application);

        // Assign UUID to the notification
        $notification->id = $notificationId;

        // Send a notification to the candidate
        // dd($application->job->title);
        $candidate->notify($notification);

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Accepted successfully.');
    }


    public function refuse($id)
    {
        $application = Application::findOrFail($id);
        $resumePath = public_path('app/public/' . $application->resume);
        if (file_exists($resumePath)) {
            unlink($resumePath);
        }
        $application->delete();

        return redirect()->back();
    }

    public function index()
    {
        $applications = Application::where('candidate_id',Auth::user()->candidates->id)->get(); // Fetch applications related to the authenticated user
        return view('candidate.applicationShow', compact('applications'));
    }

    public function edit(Application $application)
    {
        return view('candidate.applicationEdit', compact('application'));
    }

    public function update(Request $request, Application $application)
    {
        $validated = $request->validate([
            'resume' => 'nullable|file|mimes:pdf,doc,docx|max:2048', // Adjust validation as needed
            'email' => 'nullable|email',
            'phone' => 'nullable|string|max:15',
        ]);

        // Update fields
        $application->update($validated);

        return redirect()->route('applications.index')->with('success', 'Application updated successfully.');
    }
























    // public function index()
    // {
    //     $applications = Application::all();
    //     return view('applications.index', compact('applications'));
    // }

    // public function create()
    // {
    //     return view('applications.create');
    // }

    // public function store(Request $request)
    // {
    //     $validatedData = $request->validate([
    //         'job_id' => 'required|exists:job_postings,id',
    //         'candidate_id' => 'required|exists:candidates,id',
    //         'resume' => 'nullable|string',
    //         'cover_letter' => 'nullable|string',
    //         'status' => 'required|in:pending,accepted,rejected',
    //         'applied_at' => 'required|date',
    //     ]);

    //     Application::create($validatedData);

    //     return redirect()->route('applications.index')->with('success', 'Application created successfully.');
    // }

    // public function show(Application $application)
    // {
    //     return view('applications.show', compact('application'));
    // }

    // public function edit(Application $application)
    // {
    //     return view('applications.edit', compact('application'));
    // }

    // public function update(Request $request, Application $application)
    // {
    //     $validatedData = $request->validate([
    //         'job_id' => 'required|exists:job_postings,id',
    //         'candidate_id' => 'required|exists:candidates,id',
    //         'resume' => 'nullable|string',
    //         'cover_letter' => 'nullable|string',
    //         'status' => 'required|in:pending,accepted,rejected',
    //         'applied_at' => 'required|date',
    //     ]);

    //     $application->update($validatedData);

    //     return redirect()->route('applications.index')->with('success', 'Application updated successfully.');
    // }

    // public function destroy(Application $application)
    // {
    //     $application->delete();

    //     return redirect()->route('applications.index')->with('success', 'Application deleted successfully.');
    // }
}
