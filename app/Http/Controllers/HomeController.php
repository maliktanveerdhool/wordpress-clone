<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        $featured = Post::published()
            ->with(['author', 'category'])
            ->featured()
            ->latest('published_at')
            ->first();

        $posts = Post::published()
            ->with(['author', 'category'])
            ->when($featured, fn ($query) => $query->whereKeyNot($featured->getKey()))
            ->latest('published_at')
            ->paginate(6);

        $categories = Category::query()
            ->withCount(['posts' => fn ($query) => $query->published()])
            ->orderBy('name')
            ->get();

        $popular = Post::published()
            ->with('category')
            ->orderByDesc('views')
            ->take(4)
            ->get();

        $tags = Tag::query()
            ->withCount('posts')
            ->orderByDesc('posts_count')
            ->take(12)
            ->get();

        return view('home', compact('featured', 'posts', 'categories', 'popular', 'tags'));
    }
}
