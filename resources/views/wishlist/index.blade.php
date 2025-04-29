<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Wishlist</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
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

        <!-- Login Button -->
        <button @click="showLogin = true" class="text-gray-600 hover:text-blue-500">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 20c0 1.104.896 2 2 2h10c1.104 0 2-.896 2-2v-2c0-3.314-4-5-6-5s-6 1.686-6 5v2zM12 11c2.209 0 4-1.791 4-4S14.209 3 12 3 8 4.791 8 7s1.791 4 4 4z"/>
            </svg>
        </button>
    </div>

    <div class="container mx-auto px-4 py-8">
        <h1 class="text-4xl font-bold text-center mb-10">My Wishlist</h1>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            @forelse ($wishlists as $wishlist)
                <div class="bg-white p-4 rounded-lg shadow text-center">
                    <a href="{{ route('service.show', $wishlist->service->id) }}">
                        <img src="{{ asset('storage/' . $wishlist->service->image) }}" class="h-48 w-full object-contain mb-4" alt="{{ $wishlist->service->name }}">
                        <h2 class="text-xl font-semibold">{{ $wishlist->service->name }}</h2>
                    </a>

                    <form action="{{ route('wishlist.remove', $wishlist->service->id) }}" method="POST" class="mt-4">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-500 hover:text-red-700">
                            ❌ Remove from Wishlist
                        </button>
                    </form>
                </div>
            @empty
                <p class="text-center col-span-3">Your wishlist is empty.</p>
            @endforelse
        </div>
    </div>

</body>
</html>