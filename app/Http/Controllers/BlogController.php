<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\Like;

class BlogController extends Controller
{
    public function index()
    {
        $posts = Blog::with(['user', 'likes', 'comments.user'])
            ->latest()
            ->paginate(5);
            
        // Get the current user's likes for these posts
        $userLikes = [];
        if (Auth::check()) {
            $userLikes = Like::where('user_id', Auth::id())
                ->whereIn('blog_id', $posts->pluck('id'))
                ->pluck('is_like', 'blog_id')
                ->toArray();
        }
        
        return view('blog.index', compact('posts', 'userLikes'));
    }

    public function create()
    {
        return view('blog.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
        ]);

        Blog::create([
            'title' => $request->title,
            'content' => $request->content,
            'user_id' => Auth::id(),
        ]);


        return redirect()->route('blogs.index')->with('success', 'Blog created successfully!');
    }
}
