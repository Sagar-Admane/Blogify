<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Store a new comment
     */
    public function store(Request $request, Blog $blog)
    {
        $request->validate([
            'content' => 'required|min:1|max:1000',
        ]);
        
        Comment::create([
            'user_id' => Auth::id(),
            'blog_id' => $blog->id,
            'content' => $request->content
        ]);
        
        return redirect()->back()->with('success', 'Comment added successfully!');
    }
    
    /**
     * Delete a comment
     */
    public function destroy(Comment $comment)
    {
        // Check if the user is the owner of the comment
        if ($comment->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'You are not authorized to delete this comment.');
        }
        
        $comment->delete();
        
        return redirect()->back()->with('success', 'Comment deleted successfully!');
    }
}
