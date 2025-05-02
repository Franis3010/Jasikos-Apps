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
            <img 
                src="{{ asset('storage/logo/jasikos-logo.png') }}" 
                alt="Jasikos Logo" class="h-12">
            </a>
        </div>

        <!-- Search + Icons -->
        <div class="flex-1 mx-8 flex items-center space-x-4">


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

            <form action="{{ route('home') }}" method="GET" class="w-full flex">
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Search services..."
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
            </form>
        </div>

        <!-- Profile Dropdown Button -->
        <div x-data="{ showProfile: false }" class="relative">
            <!-- Icon Button -->
            <button @click="showProfile = !showProfile" class="focus:outline-none">
                <img src="{{ auth()->user()->profile_picture 
                    ? asset('storage/' . auth()->user()->profile_picture) 
                    : asset('storage/logo/profile.png') }}" 
                    alt="Profile" 
                    class="h-8 w-8 rounded-full object-cover">
            </button>

            <!-- Dropdown Content -->
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

                <!-- Edit Profile -->
                <a href="{{ route('profile.edit') }}" 
                class="block py-2 text-sm text-blue-500 hover:bg-gray-100 rounded">
                    Edit Profile
                </a>

                <!-- Logout -->
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
        <h1 class="text-4xl font-bold text-center mb-10">Designer</h1>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            @foreach ($services as $service)
                <div class="block bg-white rounded-xl shadow p-4 text-center hover:shadow-lg transition-shadow duration-300">
                    <a href="{{ route('service.show', $service->id) }}">
                        <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->name }}" class="w-full max-h-80 object-contain rounded-lg mb-4 bg-white">
                        <h2 class="text-xl font-semibold mb-2">{{ $service->name }}</h2>
                    </a>

                    @auth
                        <div class="flex justify-center gap-4 mt-2">
                            {{-- Wishlist Button --}}
                            <form action="{{ route('wishlist.add', $service->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="redirect_url" value="{{ url()->current() }}">
                                <button type="submit" class="text-gray-600 hover:text-red-500">
                                    ❤️ Wishlist
                                </button>
                            </form>

                            {{-- Cart Button --}}
                            <form action="{{ route('cart.add', $service->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="text-gray-600 hover:text-green-600">
                                    🛒 Add to Cart
                                </button>
                            </form>
                        </div>
                    @endauth
                </div>
            @endforeach
        </div>
    </div>
</body>
</html>