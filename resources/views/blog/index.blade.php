<!DOCTYPE html>
<html>
<head>
    <title>Public Blog</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 0; margin: 0; background: #f9f9f9; }
        .navbar { background: #333; color: white; padding: 15px 0; }
        .nav-container { max-width: 1200px; margin: 0 auto; display: flex; justify-content: space-between; align-items: center; padding: 0 20px; }
        .nav-brand { font-size: 24px; font-weight: bold; text-decoration: none; color: white; }
        .nav-links { display: flex; gap: 20px; }
        .nav-link { color: #ddd; text-decoration: none; padding: 5px 10px; border-radius: 5px; transition: background 0.3s; }
        .nav-link:hover { background: #444; color: white; }
        .nav-link.active { background: #2196F3; color: white; }
        .container { max-width: 1200px; margin: 0 auto; padding: 20px; }
        .post { background: white; padding: 1.5rem; margin-bottom: 1rem; border-radius: 10px; box-shadow: 0 0 5px rgba(0,0,0,0.1); }
        .title { font-size: 24px; font-weight: bold; margin-bottom: 10px; }
        .author { color: #666; font-size: 14px; margin-bottom: 15px; }
        .body { margin-bottom: 20px; }
        .actions { display: flex; gap: 10px; margin-bottom: 15px; }
        .btn { padding: 5px 10px; border-radius: 5px; cursor: pointer; border: none; }
        .btn-like { background: #4CAF50; color: white; }
        .btn-dislike { background: #f44336; color: white; }
        .btn-active { opacity: 1; }
        .btn-inactive { opacity: 0.6; }
        .comments { margin-top: 15px; border-top: 1px solid #eee; padding-top: 15px; }
        .comment { background: #f5f5f5; padding: 10px; margin-bottom: 10px; border-radius: 5px; }
        .comment-form { margin-top: 15px; }
        .comment-form textarea { width: 100%; padding: 8px; border-radius: 5px; border: 1px solid #ddd; }
        .comment-form button { background: #2196F3; color: white; padding: 8px 15px; border: none; border-radius: 5px; cursor: pointer; margin-top: 5px; }
        .comment-header { display: flex; justify-content: space-between; font-size: 12px; color: #666; }
        .delete-comment { color: #f44336; cursor: pointer; }
        .success-message { background: #dff0d8; color: #3c763d; padding: 10px; border-radius: 5px; margin-bottom: 15px; }
        .error-message { background: #f2dede; color: #a94442; padding: 10px; border-radius: 5px; margin-bottom: 15px; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .create-btn { background: #2196F3; color: white; padding: 10px 20px; border-radius: 5px; text-decoration: none; font-weight: bold; }
        .user-menu { position: relative; display: inline-block; }
        .user-menu-content { display: none; position: absolute; right: 0; background-color: #f9f9f9; min-width: 160px; box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2); z-index: 1; border-radius: 5px; }
        .user-menu:hover .user-menu-content { display: block; }
        .user-menu-item { color: black; padding: 12px 16px; text-decoration: none; display: block; }
        .user-menu-item:hover { background-color: #f1f1f1; }
        .user-menu-header { padding: 12px 16px; background: #eee; border-radius: 5px 5px 0 0; }
    </style>
</head>
<body>

    <nav class="navbar">
        <div class="nav-container">
            <a href="{{ route('blogs.index') }}" class="nav-brand">Blogify</a>
            <div class="nav-links">
                <a href="{{ route('blogs.index') }}" class="nav-link {{ request()->routeIs('blogs.index') ? 'active' : '' }}">Home</a>
                @auth
                    <a href="{{ route('blogs.create') }}" class="nav-link {{ request()->routeIs('blogs.create') ? 'active' : '' }}">Create Post</a>
                    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">Dashboard</a>
                    <div class="user-menu">
                        <a href="#" class="nav-link">{{ Auth::user()->name }}</a>
                        <div class="user-menu-content">
                            <div class="user-menu-header">{{ Auth::user()->email }}</div>
                            <a href="{{ route('profile.edit') }}" class="user-menu-item">Profile</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a href="{{ route('logout') }}" class="user-menu-item" onclick="event.preventDefault(); this.closest('form').submit();">
                                    Logout
                                </a>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="nav-link {{ request()->routeIs('login') ? 'active' : '' }}">Login</a>
                    <a href="{{ route('register') }}" class="nav-link {{ request()->routeIs('register') ? 'active' : '' }}">Register</a>
                @endauth
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="header">
            <h1>📰 Welcome to the Blog</h1>
            @auth
                <a href="{{ route('blogs.create') }}" class="create-btn">Create New Post</a>
            @endauth
        </div>
        
        @if(session('success'))
            <div class="success-message">
                {{ session('success') }}
            </div>
        @endif
        
        @if(session('error'))
            <div class="error-message">
                {{ session('error') }}
            </div>
        @endif

        @foreach($posts as $post)
            <div class="post">
                <div class="title">{{ $post->title }}</div>
                <div class="author">by {{ $post->user ? $post->user->name : 'Unknown User' }} | {{ $post->created_at->format('M d, Y') }}</div>
                <div class="body">{{ $post->content }}</div>
                
                <div class="actions">
                    <form action="{{ route('blogs.like', $post) }}" method="POST" style="display: inline;">
                        @csrf
                        <input type="hidden" name="is_like" value="1">
                        <button type="submit" class="btn btn-like {{ isset($userLikes[$post->id]) && $userLikes[$post->id] ? 'btn-active' : 'btn-inactive' }}">
                            👍 Like ({{ $post->likes->where('is_like', true)->count() }})
                        </button>
                    </form>
                    
                    <form action="{{ route('blogs.like', $post) }}" method="POST" style="display: inline;">
                        @csrf
                        <input type="hidden" name="is_like" value="0">
                        <button type="submit" class="btn btn-dislike {{ isset($userLikes[$post->id]) && !$userLikes[$post->id] ? 'btn-active' : 'btn-inactive' }}">
                            👎 Dislike ({{ $post->likes->where('is_like', false)->count() }})
                        </button>
                    </form>
                </div>
                
                <div class="comments">
                    <h3>Comments ({{ $post->comments->count() }})</h3>
                    
                    @foreach($post->comments as $comment)
                        <div class="comment">
                            <div class="comment-header">
                                <span>{{ $comment->user->name }} | {{ $comment->created_at->format('M d, Y H:i') }}</span>
                                @if(Auth::check() && Auth::id() === $comment->user_id)
                                    <form action="{{ route('comments.destroy', $comment) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <span class="delete-comment" onclick="this.closest('form').submit();">Delete</span>
                                    </form>
                                @endif
                            </div>
                            <div class="comment-content">
                                {{ $comment->content }}
                            </div>
                        </div>
                    @endforeach
                    
                    @auth
                        <div class="comment-form">
                            <form action="{{ route('blogs.comment', $post) }}" method="POST">
                                @csrf
                                <textarea name="content" rows="2" placeholder="Write a comment..." required></textarea>
                                <button type="submit">Post Comment</button>
                            </form>
                        </div>
                    @endauth
                </div>
            </div>
        @endforeach

        <div>
            {{ $posts->links() }}
        </div>
    </div>

</body>
</html>
