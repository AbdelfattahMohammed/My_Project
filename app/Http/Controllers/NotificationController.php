<?php


namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\Employer;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\DatabaseNotification;

class NotificationController extends Controller
{
    public function candidateShow($id)
    {
        $candidateId = Auth::user()->candidates->id;
        $notifications = Notification::where('notifiable_id', $candidateId)
            ->where('notifiable_type', Candidate::class)
            ->get();


        $notification = DatabaseNotification::where('id', $id)
            ->where('notifiable_type', Candidate::class)
            ->firstOrFail();
        $message = $notification->data;
        $notification->markAsRead();

        // $notifications = Auth::user()->candidates->notifications; // Fetch notifications
        $unreadCount = Auth::user()->candidates->unreadNotifications()->count();

        return view('notification.candidateShow', compact('notification', 'notifications', 'message','unreadCount'));
    }

    // public function employerShow($id)
    // {
    //     $employerId = Auth::user()->employer->id;
    //     // $notifications = Notification::where('notifiable_id', $employerId)
    //     //     ->where('notifiable_type', Employer::class)
    //     //     ->get();


    //     // $data = is_string($notification->data) ? json_decode($notification->data, true) : $notification->data;

    //     // $notifications = Auth::user()->candidates->notifications; // Fetch notifications
    //     $notification = DatabaseNotification::where('id', $id)
    //     ->where('notifiable_type', Employer::class)
    //     ->firstOrFail();
    //     $notification->markAsRead();
    //     $unreadCount = Auth::user()->employer->unreadNotifications()->count();

    //     return view('notification.employerShow', compact('notification', 'notifications','unreadCount'));
    // }


    // public function markAsRead($id)
    // {
    //     $notification = Auth::user()->candidates->notifications()->find($id);

    //     if ($notification) {
    //         $notification->markAsRead();
    //         return response()->json(['success' => true]);
    //     }

    //     return response()->json(['success' => false], 404);
    // }

    // public function count()
    // {
    //     $count = Auth::user()->candidates->unreadNotifications()->count();
    //     return response()->json(['count' => $count]);
    // }

}
