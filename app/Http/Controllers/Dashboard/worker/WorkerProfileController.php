<?php

namespace App\Http\Controllers\Dashboard\worker;

use App\Models\Post;
use App\Models\Worker;
use App\Models\WorkerReview;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Worker\profile\UpdateWorkerRequest;
use App\Services\WorkerService\WorkerProfileUpdateService;

class WorkerProfileController extends Controller
{
    public function profile()
    {
        $workerId = auth()->guard('worker')->id();
        $workerWithPosts = Worker::with('posts.reviews')
            ->find($workerId)
            ->makeHidden(['status', 'verification_token', 'verified_at', 'created_at', 'updated_at']);
        $postReviews = WorkerReview::whereIn('post_id', $workerWithPosts->posts()->pluck('id'))->get();
        $rate = ($postReviews->sum('rate') / $postReviews->count('rate'));
        return response()->json([
            'data' => array_merge($workerWithPosts->toArray(), ['rate' => $rate])
        ], 200);
    }
    public function edit()
    {
        $worker = auth()->guard()->id();
        return response()->json([
            'data' => $worker
        ], 200);
    }
    public function update(UpdateWorkerRequest $request)
    {
        return ((new WorkerProfileUpdateService())->update($request));
    }
    public function delete()
    {
        $workerId = auth()->guard('worker')->id();
        Post::where('worker_id', $workerId)->delete();
        return response()->json([
            'message' => 'deleted'
        ], 200);
    }
}
