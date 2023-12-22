<?php

namespace App\Http\Controllers\Dashboard\post;

use App\Models\Post;
use App\Filters\PostFilter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Requests\Post\StorePostRequest;
use App\Services\WorkerService\PostStoreService;

class PostController extends Controller
{

    public function index()
    {
        $posts = Post::all();
        return response()->json([
            'posts' => $posts
        ], 200);
    }
    public function approved()
    {
        $ApprovedPosts = Post::whereStatus('approved')->with('Worker:id,name')->get();
        return response()->json([
            'ApprovedPosts' => $ApprovedPosts
        ], 200);
    }


    public function store(StorePostRequest $request)
    {
        return (new PostStoreService())->store($request);
    }
    public function getById($id)
    {
        $post = Post::find($id)->first();
        return $post;
    }


    public function filterOfApproved()
    {
        return (new PostFilter())->filterOfApproved();
    }
    public function filterApprovedByAll()
    {
        $posts = QueryBuilder::for(Post::class)
            ->allowedFilters((new PostFilter)->filterApprovedByAll())
            ->whereStatus('approved')
            ->with('Worker:id,name')
            ->get();
        return response()->json([
            'posts' => $posts
        ], 200);
    }

}
