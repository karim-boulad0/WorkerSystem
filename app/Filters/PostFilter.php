<?php

namespace App\Filters;

use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use Illuminate\Database\Eloquent\Builder;

class PostFilter
{
    public function filterApprovedByAll()
    {
        $posts =  [
            'content', 'price',
            AllowedFilter::callback('item', function (Builder $query, $value) {
                $query->where('price', 'like', "%{$value}%")
                    ->orWhere('content', 'like', "%{$value}%")
                    ->orWhereHas('Worker', function (Builder $query) use ($value) {
                        $query->where('name', 'like', "%{$value}%");
                    });
            }),
        ];
        return $posts;
    }

    public function filterOfApproved()
    {
        $posts = QueryBuilder::for(Post::class)
            ->whereStatus('approved')
            ->with('Worker:id,name')
            ->allowedFilters(['content', 'price', 'worker.name'])
            ->get();

        return response()->json([
            'posts' => $posts
        ], 200);
    }
}
