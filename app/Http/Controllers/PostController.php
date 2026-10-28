<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function show(Request $request, Post $post): View
    {
        abort_unless(
            $post->status === 'published' && $post->published_at?->isPast(),
            404
        );

        $post->load(['author', 'category', 'tags']);
        $post->increment('views');

        $comments = $post->approvedComments()->with('replies')->get();

        $related = Post::published()
            ->with(['author', 'category'])
            ->whereKeyNot($post->getKey())
            ->when($post->category_id, fn ($query) => $query->where('category_id', $post->category_id))
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('posts.show', compact('post', 'comments', 'related'));
    }
}
