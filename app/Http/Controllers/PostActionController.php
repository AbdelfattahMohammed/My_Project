<?php

namespace App\Http\Controllers;

use App\Models\PostAction;
use App\Models\Posting;
use App\Notifications\NotifyEmployerComment;
use App\Notifications\NotifyEmployerLike;
use App\Notifications\NotifyEmployerShare;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class PostActionController extends Controller
{
    public function like(Request $request)
    {
        $request->validate([
            'posting_id' => 'required|exists:postings,id'
        ]);

        $posting = Posting::findOrFail($request->posting_id);
        $userId = Auth::id();

        $postAction = PostAction::where('user_id', $userId)
        ->where('posting_id', $request->posting_id)
        ->where('action_type', 'like')
        ->first();

        if ($postAction) {
            $postAction->delete();
            $status = 'unliked';
        } else {
            $employer=$posting->employer;
            $employer->notify(new NotifyEmployerLike($posting));
            PostAction::create([
                'user_id' => $userId,
                'posting_id' => $request->posting_id,
                'action_type' => 'like'
            ]);
            $status = 'liked';
        }

        $likeCount = $posting->postActions()->where('action_type', 'like')->count();

        return response()->json(['status' => $status, 'like_count' => $likeCount]);
    }

    public function comment(Request $request)
    {
        $request->validate([
            'posting_id' => 'required|exists:postings,id',
            'comment_text' => 'required|string|max:255'
        ]);

        $posting = Posting::findOrFail($request->posting_id);
        $employer=$posting->employer;
        $employer->notify(new NotifyEmployerComment($posting));
        $userId = Auth::id();

        $postAction = PostAction::create([
            'user_id' => $userId,
            'posting_id' => $request->posting_id,
            'action_type' => 'comment',
            'comment_text' => $request->comment_text
        ]);

        return response()->json([
            'user_image' => Auth::user()->profile_picture,
            'user_name' => Auth::user()->name,
            'comment_text' => $postAction->comment_text,
            'comment_id' => $postAction->id,
        ]);
    }

    public function share(Request $request)
    {
        $request->validate([
            'posting_id' => 'required|exists:postings,id',
            'platform' => 'required|string|in:facebook,twitter,linkedin,email'
        ]);

        $posting = Posting::findOrFail($request->posting_id);
        $employer=$posting->employer;
        $employer->notify(new NotifyEmployerShare($posting));

        PostAction::create([
            'user_id' => Auth::id(),
            'posting_id' => $request->posting_id,
            'action_type' => 'share',
            'share_platform' => $request->platform
        ]);

        return response()->json(['status' => 'shared']);
    }




}
