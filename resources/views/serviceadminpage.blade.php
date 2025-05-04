<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Jasikos - Admin Services</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <script src="//unpkg.com/alpinejs" defer></script>
    </head>
    <body class="bg-white" x-data="{ showProfile: false }">
        <!-- Top Bar -->
        <div class="container mx-auto px-4 py-4 flex items-center justify-between">
            <!-- Logo -->
            <div class="flex-shrink-0">
                <a href="{{ url('/') }}">
                    <img 
                        src="{{ asset('storage/logo/jasikos-logo.png') }}" 
                        alt="Jasikos Logo" 
                        class="h-12">
                </a>
            </div>

            <!-- Clothes Icon -->
            <div class="flex-shrink-0 ml-4">
                <a href="{{ route('service.adminshow') }}" class="inline-block">
                    <img 
                        src="{{ asset('storage/logo/clothes.jpeg') }}" 
                        alt="Clothes" 
                        class="h-10 w-10 object-cover rounded hover:opacity-80 transition">
                </a>
            </div>

            <!-- Profile Dropdown -->
            <div class="flex-shrink-0 ml-auto relative">
                <button @click="showProfile = !showProfile" class="focus:outline-none">
                    <img src="{{ auth()->user()->profile_picture 
                        ? asset('storage/' . auth()->user()->profile_picture) 
                        : asset('storage/logo/profile.png') }}" 
                        alt="Profile" 
                        class="h-8 w-8 rounded-full object-cover">
                </button>

                <div x-show="showProfile" 
                    @click.outside="showProfile = false" 
                    x-cloak
                    class="absolute right-0 mt-2 w-56 bg-white shadow-lg rounded-lg p-4 z-50 text-center">
                    
                    <!-- User Info -->
                    <div class="flex flex-col items-center mb-4 space-y-2">
                        <img src="{{ auth()->user()->profile_picture 
                            ? asset('storage/' . auth()->user()->profile_picture) 
                            : asset('storage/logo/profile.png') }}"
                            alt="Profile"
                            class="h-12 w-12 rounded-full object-cover">
                        <h3 class="font-semibold text-gray-800">{{ auth()->user()->name }}</h3>
                        <p class="text-sm text-gray-600">{{ auth()->user()->email }}</p>
                    </div>

                    <a href="{{ route('profile.edit') }}" 
                    class="block py-2 text-sm text-blue-500 hover:bg-gray-100 rounded">
                        Edit Profile
                    </a>

                    <form action="{{ route('logout') }}" method="POST" class="mt-2">
                        @csrf
                        <button type="submit" 
                                class="block py-2 text-sm text-red-500 w-full hover:bg-gray-100 rounded">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="container mx-auto px-4 py-8">
            <h1 class="text-3xl font-bold text-center mb-8">All Services</h1>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach ($services as $service)
                <a href="{{ route('service.edit', $service->id) }}" class="block hover:shadow-lg transition rounded-lg border p-4">
                    <img src="{{ asset('storage/' . $service->image) }}" 
                        alt="{{ $service->name }}" 
                        class="w-full h-48 object-contain bg-white-100 rounded mb-4">
                    
                    <h3 class="text-lg font-bold">{{ $service->name }}</h3>
                    <p class="text-sm text-gray-600">{{ $service->email }}</p>
                    <p class="text-sm text-gray-600">{{ $service->phone }}</p>
                    <p class="text-sm text-gray-600">{{ $service->address }}</p>
                    <p class="text-sm text-gray-600">Price: Rp{{ number_format($service->min_price) }} - Rp{{ number_format($service->max_price) }}</p>
                </a>
                @endforeach
            </div>
        </div>
    </body>
</html>