@extends('layouts.app')

@section('title', $service->name)

@section('content')
    <div class="container mx-auto px-4 py-4 flex items-center justify-between">
        <!-- Logo -->
        <div class="flex-shrink-0">
            <a href="{{ url('/') }}">
                <img src="{{ asset('storage/services/jasikos-logo.png') }}" alt="Jasikos Logo" class="h-12">
            </a>
        </div>

        <!-- Icons (Wishlist, Cart) moved to the right for the show page -->
        <div class="flex-1 mx-8 flex items-center space-x-4 justify-end">
            <!-- Wishlist Icon -->
            <button class="text-gray-600 hover:text-red-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M4.318 6.318a4.5 4.5 0 016.364 0L12 7.636l1.318-1.318a4.5 4.5 0 116.364 6.364L12 21.364l-7.682-7.682a4.5 4.5 0 010-6.364z"/>
                </svg>
            </button>

            <!-- Basket Icon -->
            <button class="text-gray-600 hover:text-yellow-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 7M7 13l-1.293 2.586A1 1 0 007 17h10a1 1 0 00.894-1.447L17 13M10 21a1 1 0 100-2 1 1 0 000 2zm8 0a1 1 0 100-2 1 1 0 000 2z"/>
                </svg>
            </button>
        </div>

        @auth
        <!-- If User is Authenticated -->
        <div x-data="{ showProfile: false }" class="relative">
            <button @click="showProfile = !showProfile" class="text-gray-600 hover:text-blue-500">
                <!-- User Profile Picture -->
                <img src="{{ asset('storage/' . auth()->user()->profile_picture) }}" alt="Profile" class="h-8 w-8 rounded-full">
            </button>

            <!-- Profile Dropdown -->
            <div x-show="showProfile" @click.outside="showProfile = false" class="absolute right-0 mt-2 w-48 bg-white shadow-lg rounded-lg p-4">
                <div class="flex items-center space-x-2 mb-4">
                    <!-- User Profile Picture in the Dropdown -->
                    <img src="{{ asset('storage/' . auth()->user()->profile_picture) }}" alt="Profile" class="h-12 w-12 rounded-full">
                    <div>
                        <h3 class="font-semibold">{{ auth()->user()->name }}</h3>
                        <p class="text-sm text-gray-600">{{ auth()->user()->email }}</p>
                    </div>
                </div>

                <a href="{{ route('profile.edit') }}" class="block py-2 text-sm text-blue-500 hover:bg-gray-100">Edit Profile</a>
                <form action="{{ route('logout') }}" method="POST" class="mt-2">
                    @csrf
                    <button type="submit" class="block py-2 text-sm text-red-500 w-full text-left">Logout</button>
                </form>
            </div>
        </div>
        @else
        <!-- If User is Not Authenticated -->
        <button @click="showLogin = true" class="text-gray-600 hover:text-blue-500">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 20c0 1.104.896 2 2 2h10c1.104 0 2-.896 2-2v-2c0-3.314-4-5-6-5s-6 1.686-6 5v2zM12 11c2.209 0 4-1.791 4-4S14.209 3 12 3 8 4.791 8 7s1.791 4 4 4z"/>
            </svg>
        </button>
        @endauth
    </div>

    <!-- Service Detail Page -->
    <div class="container mx-auto px-4 py-12">
        <div class="bg-white rounded-xl shadow p-6 flex flex-col md:flex-row items-center md:items-start gap-8">
            <!-- Image Section -->
            <div class="w-full md:w-1/3">
                <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->name }}" class="w-full h-60 object-contain rounded-lg bg-gray-100">
            </div>
            
            <!-- Service Information -->
            <div class="w-full md:w-2/3">
                <h1 class="text-3xl font-bold mb-4">{{ $service->name }}</h1>
                
                <!-- Email Field -->
                <div class="mb-4">
                    <label class="block font-medium mb-1">Email</label>
                    <p>{{ $service->email ?? '-' }}</p>
                </div>

                <!-- Phone Field -->
                <div class="mb-4">
                    <label class="block font-medium mb-1">Phone Number</label>
                    <p>{{ $service->phone ?? '-' }}</p>
                </div>

                <!-- Address Field -->
                <div class="mb-4">
                    <label class="block font-medium mb-1">Address</label>
                    <p>{{ $service->address ?? '-' }}</p>
                </div>

                <div class="mt-6 flex space-x-4">
                    <form action="{{ route('wishlist.add', $service->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="px-6 py-2 rounded-lg bg-red-500 hover:bg-red-600 text-white font-semibold">
                            Add to Wishlist
                        </button>
                    </form>

                    <form action="{{ route('cart.add', $service->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="px-6 py-2 rounded-lg bg-yellow-500 hover:bg-yellow-600 text-white font-semibold">
                            Add to Cart
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection