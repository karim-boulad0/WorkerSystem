<?php

namespace App\Http\Controllers\WebSite\Review;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Review\WorkerReviewRequest;
use App\Models\WorkerReview;
use Exception;

class WorkerReviewController extends Controller
{
    public function store(WorkerReviewRequest $request)
    {
        try {
            $data = $request->all();
            $data['client_id'] = auth()->guard('client')->id();
            $reviews = WorkerReview::create($data);
            return response()->json(['data' => $reviews], 200);
        } catch (Exception $err) {
            return response()->json(['err' => $err], 200);
        }
    }
    public function postRate($id)
    {
        try {
            $reviews = WorkerReview::wherePostId($id)->get();
            $average = $reviews->sum('rate') / $reviews->count();
            return response()->json(['data' => $average], 200);
        } catch (Exception $err) {
            return response()->json(['err' => $err], 200);
        }
    }
}

