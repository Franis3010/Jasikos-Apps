<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Jasikos</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
</head>
<body class="bg-white" x-data="{showLogin: {{ session('showLogin') ? 'true' : 'false' }}, showRegister: false}">
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
                <form action="{{ route('home') }}" method="GET" class="w-full flex">
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

    <!-- Main Content -->
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-4xl font-bold text-center mb-10">Designer</h1>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            @foreach ($services as $service)
            <a href="{{ route('service.show', $service->id) }}" class="block bg-white rounded-xl shadow p-4 text-center hover:shadow-lg transition-shadow duration-300">
            <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->name }}" class="w-full max-h-80 object-contain rounded-lg mb-4 bg-white">
                <h2 class="text-xl font-semibold mb-2">{{ $service->name }}</h2>

                <form action="{{ route('wishlist.add', $service->id) }}" method="POST" class="mt-2">
                    @csrf
                    <button type="submit" class="text-gray-600 hover:text-red-500">
                        ❤️ Add to Wishlist
                    </button>
                </form>
            </a>
            @endforeach
        </div>
    </div>

    <!-- Login Modal -->
    <div x-show="showLogin" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white p-6 rounded-xl w-full max-w-md relative">
            <button @click="showLogin = false" class="absolute top-2 right-2 text-gray-600 hover:text-black">&times;</button>
            <h2 class="text-2xl font-bold mb-4">Login</h2>
            <form action="{{ route('login') }}" method="POST">
                @csrf
                <input type="email" name="email" placeholder="Email" class="w-full mb-3 p-2 border rounded" required>
                @error('email')
                    <div class="text-red-500 text-sm">{{ $message }}</div>
                @enderror

                <input type="password" name="password" placeholder="Password" class="w-full mb-3 p-2 border rounded" required>
                @error('password')
                    <div class="text-red-500 text-sm">{{ $message }}</div>
                @enderror

                <button type="submit" class="w-full py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Login</button>
            </form>

            <p class="mt-4 text-sm text-gray-600">Don't have an account? <a href="#" @click="showRegister = true" class="text-blue-500 hover:underline">Register here</a></p>
        </div>
    </div>

    <!-- Register Modal -->
    <div x-show="showRegister" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white p-6 rounded-xl w-full max-w-md relative">
            <button @click="showRegister = false" class="absolute top-2 right-2 text-gray-600 hover:text-black">&times;</button>
            <h2 class="text-2xl font-bold mb-4">Register</h2>
            <form action="{{ route('register.submit') }}" method="POST">
                @csrf
                <input type="text" name="name" placeholder="Name" class="w-full mb-3 p-2 border rounded" required>
                @error('name')
                    <div class="text-red-500 text-sm">{{ $message }}</div>
                @enderror

                <input type="email" name="email" placeholder="Email" class="w-full mb-3 p-2 border rounded" required>
                @error('email')
                    <div class="text-red-500 text-sm">{{ $message }}</div>
                @enderror

                <input type="password" name="password" placeholder="Password" class="w-full mb-3 p-2 border rounded" required>
                @error('password')
                    <div class="text-red-500 text-sm">{{ $message }}</div>
                @enderror

                <input type="password" name="password_confirmation" placeholder="Confirm Password" class="w-full mb-3 p-2 border rounded" required>
                @error('password_confirmation')
                    <div class="text-red-500 text-sm">{{ $message }}</div>
                @enderror

                <button type="submit" class="w-full py-2 bg-green-500 text-white rounded hover:bg-green-600">Register</button>
            </form>
        </div>
    </div>
</body>
</html>