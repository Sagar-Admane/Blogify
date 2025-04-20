<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function toggle(Request $request, Blog $blog)
    {
        $isLike = $request->input('is_like', true);
        
        $existingLike = Like::where('user_id', Auth::id())
            ->where('blog_id', $blog->id)
            ->first();
        
        if ($existingLike) {
            if ($existingLike->is_like == $isLike) {
                $existingLike->delete();
                $message = $isLike ? 'Like removed' : 'Dislike removed';
            } else {
                // If the like status is different, update it
                $existingLike->update(['is_like' => $isLike]);
                $message = $isLike ? 'Changed to like' : 'Changed to dislike';
            }
        } else {
            // Create a new like/dislike
            Like::create([
                'user_id' => Auth::id(),
                'blog_id' => $blog->id,
                'is_like' => $isLike
            ]);
            $message = $isLike ? 'Liked' : 'Disliked';
        }
        
        return redirect()->back()->with('success', $message);
    }
}
// App\Models\User::all();

