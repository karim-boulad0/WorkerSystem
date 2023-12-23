<?php

namespace App\Http\Controllers\WebSite\Post;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use Illuminate\Database\Eloquent\Builder;

class PostController extends Controller
{
    // get approved posts
    public function index(Request $request)
    {
        $posts = QueryBuilder::for(Post::class)
            ->with(['photos', 'Worker', 'reviews'])
            ->where('status', 'approved')
            ->allowedFilters([
                AllowedFilter::callback('item', function (Builder $query, $value) {
                    $query->where('content', 'like', "%{$value}%")
                        ->orWhere('price', 'like', "%{$value}%")
                        ->orWhere('status', 'like', "%{$value}%")
                        ->orWhere('rejected_reason', 'like', "%{$value}%")
                        ->orWhereHas('Worker', function (Builder $query) use ($value) {
                            $query->where('name', 'like', "%{$value}%")
                                ->orWhere('email', 'like', "%{$value}%")
                                ->orWhere('phone', 'like', "%{$value}%")
                                ->orWhere('location', 'like', "%{$value}%");
                        });
                }),
            ])
            ->get();
        return $posts;
    }
}
