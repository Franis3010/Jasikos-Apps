<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Jasikos - Welcome</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
</head>
<body class="bg-white" x-data="{ showProfile: false }">
    <div class="container mx-auto px-4 py-4 flex items-center justify-between">
        <!-- Logo -->
        <div class="flex-shrink-0">
            <a href="{{ url('/') }}">
                <img src="{{ asset('storage/services/jasikos-logo.png') }}" alt="Jasikos Logo" class="h-12">
            </a>
        </div>

        <!-- Search + Icons -->
        <div class="flex-1 mx-8 flex items-center space-x-4">
            @if (Request::is('/'))
                <form action="{{ route('service.search') }}" method="GET" class="w-full flex">
                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Search services..."
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    >
                </form>
            @endif

            <!-- Wishlist Icon -->
            <a href="{{ route('wishlist.index') }}" class="text-gray-600 hover:text-red-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M4.318 6.318a4.5 4.5 0 016.364 0L12 7.636l1.318-1.318a4.5 4.5 0 116.364 6.364L12 21.364l-7.682-7.682a4.5 4.5 0 010-6.364z"/>
                </svg>
            </a>

            <!-- Basket Icon -->
            <a href="{{ route('cart.show') }}" class="text-gray-600 hover:text-yellow-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 7M7 13l-1.293 2.586A1 1 0 007 17h10a1 1 0 00.894-1.447L17 13M10 21a1 1 0 100-2 1 1 0 000 2zm8 0a1 1 0 100-2 1 1 0 000 2z"/>
                </svg>
            </a>
        </div>

        @auth
            <!-- User Profile Button -->
            <button @click="showProfile = !showProfile" class="text-gray-600 hover:text-blue-500 relative">
                <img src="{{ asset('storage/' . auth()->user()->profile_picture) }}" alt="Profile" class="h-8 w-8 rounded-full">

                <div x-show="showProfile" @click.outside="showProfile = false" class="absolute right-0 mt-2 w-48 bg-white shadow-lg rounded-lg p-4">
                    <div class="flex items-center space-x-2 mb-4">
                    <img src="{{ asset('storage/' . (auth()->user()->profile_picture ?? 'default.png')) }}" alt="Profile" class="h-8 w-8 rounded-full">
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
            </button>
        @endauth
    </div>

    <!-- Main Content -->
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-4xl font-bold text-center mb-10">Designer</h1>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
        @foreach ($services as $service)
            <div class="block bg-white rounded-xl shadow p-4 text-center hover:shadow-lg transition-shadow duration-300">
                <a href="{{ route('service.show', $service->id) }}">
                    <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->name }}" class="h-72 w-full object-contain rounded-lg mb-4 bg-gray-200">
                    <h2 class="text-xl font-semibold mb-2">{{ $service->name }}</h2>
                </a>

                @auth
                    <form action="{{ route('wishlist.add', $service->id) }}" method="POST" class="mt-2">
                        @csrf
                        <input type="hidden" name="redirect_url" value="{{ url()->current() }}">
                        <button type="submit" class="text-gray-600 hover:text-red-500">
                            ❤️ Add to Wishlist
                        </button>
                    </form>
                @endauth
            </div>
        @endforeach
        </div>
    </div>
</body>
</html>