<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    // public function index($receiverId)
    //     {
    //         return view('chat.index', ['receiverId' => $receiverId]);
    //     }

    //     public function fetchMessages($userId)
    //     {
    //         $messages = Message::where(function($query) use ($userId) {
    //             $query->where('sender_id', Auth::user()->id)
    //                   ->where('receiver_id', $userId);
    //         })->orWhere(function($query) use ($userId) {
    //             $query->where('sender_id', $userId)
    //                   ->where('receiver_id', Auth::user()->id);
    //         })->get();

    //         return response()->json($messages);
    //     }

    //     public function sendMessage(Request $request)
    //     {
    //         $message = Message::create([
    //             'sender_id' => Auth::user()->id,
    //             'receiver_id' => $request->receiver_id,
    //             'message' => $request->message,
    //         ]);

    //         return response()->json($message);
    //     }

    // Display all users the authenticated user has messaged with
    public function index()
    {
        $userId = Auth::id();

        // Get users that have messaged or been messaged by the authenticated user
        $users = User::whereHas('messagesSent', function ($query) use ($userId) {
            $query->where('receiver_id', $userId);
        })->orWhereHas('messagesReceived', function ($query) use ($userId) {
            $query->where('sender_id', $userId);
        })
        ->get();

        return view('chat.index', compact('users'));
    }

    // Show the chat between the authenticated user and another user
    public function show($userId)
    {
        $user = User::findOrFail($userId); // Get the user you're chatting with
        $messages = Message::where(function ($query) use ($userId) {
            $query->where('sender_id', Auth::id())
                  ->where('receiver_id', $userId);
        })->orWhere(function ($query) use ($userId) {
            $query->where('sender_id', $userId)
                  ->where('receiver_id', Auth::id());
        })->get();

        return view('chat.show', compact('user', 'messages'));
    }

    // Send a new message
    public function send(Request $request, User $user)
    {
        // Validate the message input
        $request->validate([
            'message' => 'required|string',
        ]);

        // Create a new message
        Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $user->id,
            'message' => $request->message,
        ]);

        // Redirect back to the chat with the selected user
        return redirect()->route('chat.show', $user->id);
    }
}
