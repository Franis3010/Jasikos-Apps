@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Profile</h2>

    @if(session('success'))
        <div style="color: green;">{{ session('success') }}</div>
    @endif

    <!-- User profile edit form -->
    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
        @csrf
        <button type="submit">Logout</button>
    </form>

    <form action="{{ route('profile.update') }}" method="POST">
        @csrf
        @method('POST')

        <!-- Name -->
        <div>
            <label>Name:</label><br>
            <input type="text" name="name" value="{{ old('name', $user->name) }}">
            @error('name')
                <div style="color: red;">{{ $message }}</div>
            @enderror
        </div>

        <!-- Display email without edit -->
        <div style="margin-top: 10px;">
            <label>Email:</label><br>
            <input type="email" value="{{ old('email', $user->email) }}" disabled>
        </div>

        <!-- Submit Button -->
        <div style="margin-top: 20px;">
            <button type="submit">Update Profile</button>
        </div>
    </form>
</div>
@endsection