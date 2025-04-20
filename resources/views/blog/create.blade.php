<!DOCTYPE html>
<html>
<head>
    <title>Create Blog</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 2rem; background: #f0f0f0; }
        form { background: white; padding: 2rem; border-radius: 10px; width: 500px; margin: 0 auto; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        label { display: block; margin-bottom: 0.5rem; font-weight: bold; }
        input, textarea { width: 100%; padding: 0.5rem; margin-bottom: 1rem; border-radius: 5px; border: 1px solid #ccc; }
        button { background: #007bff; color: white; padding: 0.5rem 1rem; border: none; border-radius: 5px; cursor: pointer; }
    </style>
</head>
<body>

    <h2>Create a New Blog Post</h2>

    <form method="POST" action="{{ route('blogs.store') }}">
        @csrf

        <label for="title">Title</label>
        <input type="text" name="title" required>

        <label for="content">Body</label>
        <textarea name="content" rows="5" required></textarea>

        <button type="submit">Create</button>
    </form>

</body>
</html>
