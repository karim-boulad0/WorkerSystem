<?php

namespace App\Http\Controllers\Dashboard\admin;

use App\Models\Post;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Notification;
use App\Http\Requests\Post\PostStatusRequest;
use App\Notifications\PostNotifications;

class PostStatusController extends Controller
{
    public function changeStatus(PostStatusRequest  $request)
    {
        $postId = $request->post_id;
        $status = $request->status;
        $rejectedReason = $request->rejected_reason;
        $post = Post::find($postId);
        $post->update([
            'status' => $status,
            'rejected_reason' => $rejectedReason,
        ]);
        $updatedPost = Post::find($postId);
        $notification = Notification::send($updatedPost->Worker, new PostNotifications($updatedPost->Worker, $updatedPost));
        return response()->json(['post' => $updatedPost,'worker'=>$updatedPost->Worker, 'message' => 'Post status updated successfully'], 200);
    }
}
