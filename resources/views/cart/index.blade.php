<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Cart</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.0/dist/tailwind.min.css" rel="stylesheet">
    <script src="//unpkg.com/alpinejs" defer></script>
</head>
<body x-data="{ showProfile: false }"> 
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
    <div class="container mx-auto py-8">
        <h1 class="text-3xl font-bold mb-6">Shopping Cart</h1>

        @if (count($cart) > 0)
            <div class="space-y-4">
                @foreach ($cart as $item)
                    <div class="flex justify-between items-center">
                        <div>
                            <h3 class="text-xl">{{ $item->service->name }}</h3>
                            <p class="text-gray-600">
                                Price: Rp{{ number_format($item->service->min_price, 0, ',', '.') }} - Rp{{ number_format($item->service->max_price, 0, ',', '.') }}
                            </p>
                        </div>

                        <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="text-red-500">Remove</button>
                        </form>
                    </div>
                @endforeach
            </div>

            <div class="mt-6 flex justify-end">
                <form action="{{ route('cart.clear') }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded">
                        Clear Cart
                    </button>
                </form>
            </div>
        @else
            <p>Your cart is empty.</p>
        @endif
    </div>
</body>
</html>