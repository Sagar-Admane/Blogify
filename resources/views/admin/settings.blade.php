@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Application Settings</h1>
        <a href="{{ route('admin.dashboard') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">
            Back to Dashboard
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <div class="bg-white shadow-md rounded-lg p-6">
        <form action="{{ route('admin.settings.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-6">
                <h2 class="text-xl font-semibold mb-4">General Settings</h2>
                
                <div class="mb-4">
                    <label for="site_name" class="block text-gray-700 text-sm font-bold mb-2">Site Name</label>
                    <input type="text" name="site_name" id="site_name" value="{{ old('site_name', $settings['site_name'] ?? 'Blogify') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('site_name') border-red-500 @enderror">
                    @error('site_name')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="site_description" class="block text-gray-700 text-sm font-bold mb-2">Site Description</label>
                    <textarea name="site_description" id="site_description" rows="3" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('site_description') border-red-500 @enderror">{{ old('site_description', $settings['site_description'] ?? 'A modern blogging platform') }}</textarea>
                    @error('site_description')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="contact_email" class="block text-gray-700 text-sm font-bold mb-2">Contact Email</label>
                    <input type="email" name="contact_email" id="contact_email" value="{{ old('contact_email', $settings['contact_email'] ?? 'admin99@gmail.com') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('contact_email') border-red-500 @enderror">
                    @error('contact_email')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mb-6">
                <h2 class="text-xl font-semibold mb-4">Blog Settings</h2>
                
                <div class="mb-4">
                    <label for="posts_per_page" class="block text-gray-700 text-sm font-bold mb-2">Posts Per Page</label>
                    <input type="number" name="posts_per_page" id="posts_per_page" value="{{ old('posts_per_page', $settings['posts_per_page'] ?? '10') }}" min="1" max="50" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('posts_per_page') border-red-500 @enderror">
                    @error('posts_per_page')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="comments_per_page" class="block text-gray-700 text-sm font-bold mb-2">Comments Per Page</label>
                    <input type="number" name="comments_per_page" id="comments_per_page" value="{{ old('comments_per_page', $settings['comments_per_page'] ?? '20') }}" min="1" max="100" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('comments_per_page') border-red-500 @enderror">
                    @error('comments_per_page')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="comment_moderation" class="block text-gray-700 text-sm font-bold mb-2">Comment Moderation</label>
                    <select name="comment_moderation" id="comment_moderation" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('comment_moderation') border-red-500 @enderror">
                        <option value="disabled" {{ old('comment_moderation', $settings['comment_moderation'] ?? 'enabled') === 'disabled' ? 'selected' : '' }}>Disabled (all comments are approved)</option>
                        <option value="enabled" {{ old('comment_moderation', $settings['comment_moderation'] ?? 'enabled') === 'enabled' ? 'selected' : '' }}>Enabled (comments require approval)</option>
                    </select>
                    @error('comment_moderation')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mb-6">
                <h2 class="text-xl font-semibold mb-4">User Settings</h2>
                
                <div class="mb-4">
                    <label for="allow_registration" class="block text-gray-700 text-sm font-bold mb-2">Allow User Registration</label>
                    <select name="allow_registration" id="allow_registration" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('allow_registration') border-red-500 @enderror">
                        <option value="1" {{ old('allow_registration', $settings['allow_registration'] ?? '1') == '1' ? 'selected' : '' }}>Yes</option>
                        <option value="0" {{ old('allow_registration', $settings['allow_registration'] ?? '1') == '0' ? 'selected' : '' }}>No</option>
                    </select>
                    @error('allow_registration')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="default_user_role" class="block text-gray-700 text-sm font-bold mb-2">Default User Role</label>
                    <select name="default_user_role" id="default_user_role" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('default_user_role') border-red-500 @enderror">
                        <option value="user" {{ old('default_user_role', $settings['default_user_role'] ?? 'user') === 'user' ? 'selected' : '' }}>User</option>
                        <option value="admin" {{ old('default_user_role', $settings['default_user_role'] ?? 'user') === 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                    @error('default_user_role')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex items-center justify-end">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Save Settings
                </button>
            </div>
        </form>
    </div>
</div>
@endsection 