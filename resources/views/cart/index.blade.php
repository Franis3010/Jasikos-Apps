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

    <div class="container mx-auto py-8">
        <h1 class="text-3xl font-bold mb-6">Shopping Cart</h1>

        @if (count($cart) > 0)

            @php
                $stateColors = [
                    'draft' => 'text-gray-500',
                    'sent' => 'text-yellow-500',
                    'in_progress' => 'text-blue-500',
                    'cancelled' => 'text-red-500',
                    'unpaid' => 'text-pink-500',
                    'complete' => 'text-green-600',
                ];
            @endphp

            <div class="space-y-4">
                @foreach ($cart as $item)
                <div class="border rounded-lg p-4 shadow-sm mb-4 relative">
                    {{-- Status Box di pojok kanan atas --}}
                    <div class="absolute top-2 right-2">
                        <div class="skew-x-[-12deg] bg-gray-100 border border-black px-3 py-1 inline-block">
                            <span class="skew-x-[12deg] text-sm text-gray-800 font-medium">
                                Status: <span class="font-bold capitalize">{{ str_replace('_', ' ', $item->state) }}</span>
                            </span>
                        </div>
                    </div>

                    <div class="flex justify-between items-center mb-2 pt-8"> <!-- tambah pt-8 untuk beri ruang vertikal -->
                        {{-- Info layanan --}}
                        <div>
                            <h3 class="text-xl font-semibold">{{ $item->service->name }}</h3>
                            <p class="text-gray-600">
                                Price: Rp{{ number_format($item->service->min_price, 0, ',', '.') }} - Rp{{ number_format($item->service->max_price, 0, ',', '.') }}
                            </p>
                        </div>

                        {{-- Tombol Mark as Sent & Remove --}}
                        <div class="flex space-x-2">
                            @if ($item->state == 'draft')
                                <form action="{{ route('cart.updateState', $item->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="state" value="sent">
                                    <button type="submit"
                                        class="bg-blue-100 text-blue-600 hover:bg-blue-200 px-3 py-1 rounded text-sm font-medium">
                                        Mark as Sent
                                    </button>
                                </form>
                            
                                <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="bg-red-100 text-red-600 hover:bg-red-200 px-3 py-1 rounded text-sm font-medium">
                                        Remove
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
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