<h1>📃 All Posts</h1>

<a href="{{ route('posts.create') }}">➕ Create Post</a>

@foreach ($posts as $post)
    <div style="margin-top: 20px;">
        <h2>{{ $post->title }}</h2>
        <p>{{ $post->body }}</p>
        <p><i>By {{ $post->user->name }}</i></p>
    </div>
@endforeach
