@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Profile and Service</h2>

    @if(session('success'))
        <div style="color: green;">{{ session('success') }}</div>
    @endif

    <!-- User profile edit form -->
    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
        @csrf
        <button type="submit">Logout</button>
    </form>
    
    <!-- Service edit form -->
    <form action="{{ route('service.update', $service->id) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Name -->
        <div>
            <label>Name:</label><br>
            <input type="text" name="name" value="{{ old('name', $service->name) }}">
            @error('name')
                <div style="color: red;">{{ $message }}</div>
            @enderror
        </div>

        <!-- Email -->
        <div style="margin-top: 10px;">
            <label>Email:</label><br>
            <input type="email" name="email" value="{{ old('email', $service->email) }}">
            @error('email')
                <div style="color: red;">{{ $message }}</div>
            @enderror
        </div>

        <!-- Phone -->
        <div style="margin-top: 10px;">
            <label>Phone Number:</label><br>
            <input type="text" name="phone" value="{{ old('phone', $service->phone) }}">
            @error('phone')
                <div style="color: red;">{{ $message }}</div>
            @enderror
        </div>

        <!-- Address -->
        <div style="margin-top: 10px;">
            <label>Address:</label><br>
            <textarea name="address">{{ old('address', $service->address) }}</textarea>
            @error('address')
                <div style="color: red;">{{ $message }}</div>
            @enderror
        </div>

        <!-- Submit Button -->
        <div style="margin-top: 20px;">
            <button type="submit">Update Service</button>
        </div>
    </form>
</div>
@endsection