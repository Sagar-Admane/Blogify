<h1>Create Post 📝</h1>

<form method="POST" action="{{ route('posts.store') }}">
    @csrf
    <input type="text" name="title" placeholder="Title" required><br><br>
    <textarea name="body" placeholder="Body..." rows="5" required></textarea><br><br>
    <button type="submit">Post</button>
</form>
