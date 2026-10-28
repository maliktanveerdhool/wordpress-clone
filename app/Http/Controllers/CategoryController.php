<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Contracts\View\View;

class CategoryController extends Controller
{
    public function show(Category $category): View
    {
        $posts = $category->posts()
            ->published()
            ->with(['author', 'category'])
            ->latest('published_at')
            ->paginate(9);

        return view('categories.show', compact('category', 'posts'));
    }
}
