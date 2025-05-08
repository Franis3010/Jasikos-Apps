<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Edit Service - Jasikos</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <script src="//unpkg.com/alpinejs" defer></script>
    </head>
    <body class="bg-white" x-data="{ showProfile: false }">

        <!-- Navbar -->
        <div class="container mx-auto px-4 py-4 flex items-center justify-between">
            <!-- Logo -->
            <div class="flex-shrink-0">
                <a href="{{ url('/') }}">
                    <img src="{{ asset('storage/logo/jasikos-logo.png') }}" alt="Jasikos Logo" class="h-12">
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

            <div class="flex-shrink-0 ml-auto relative">
                <button @click="showProfile = !showProfile" class="focus:outline-none">
                    <img src="{{ auth()->user()->profile_picture ? asset('storage/' . auth()->user()->profile_picture) : asset('storage/logo/profile.png') }}" alt="Profile" class="h-8 w-8 rounded-full object-cover">
                </button>
                <!-- Profile Dropdown Content -->
                <div x-show="showProfile" @click.outside="showProfile = false" x-cloak class="absolute right-0 mt-2 w-56 bg-white shadow-lg rounded-lg p-4 z-50 text-center">
                    <div class="flex flex-col items-center mb-4 space-y-2">
                        <img src="{{ auth()->user()->profile_picture ? asset('storage/' . auth()->user()->profile_picture) : asset('storage/logo/profile.png') }}" alt="Profile" class="h-12 w-12 rounded-full object-cover">
                        <h3 class="font-semibold text-gray-800">{{ auth()->user()->name }}</h3>
                        <p class="text-sm text-gray-600">{{ auth()->user()->email }}</p>
                    </div>
                    <a href="{{ route('profile.edit') }}" class="block py-2 text-sm text-blue-500 hover:bg-gray-100 rounded">Edit Profile</a>
                    <form action="{{ route('logout') }}" method="POST" class="mt-2">
                        @csrf
                        <button type="submit" class="block py-2 text-sm text-red-500 w-full hover:bg-gray-100 rounded">Logout</button>
                    </form>
                </div>
            </div>
        </div>


        <!-- Main Content -->
        <div class="container mx-auto px-4 py-8">
            <h1 class="text-3xl font-bold text-center mb-6">Edit Service</h1>

            <div class="bg-white shadow-md rounded p-8">
                <!-- Edit Form -->
                <form action="{{ route('service.update', $service->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label for="name" class="block text-lg font-medium">Service Name</label>
                        <input type="text" name="name" id="name" class="mt-2 p-2 w-full border border-gray-300 rounded-lg" value="{{ old('name', $service->name) }}" required>
                        @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label for="email" class="block text-lg font-medium">Email</label>
                        <input type="email" name="email" id="email" class="mt-2 p-2 w-full border border-gray-300 rounded-lg" value="{{ old('email', $service->email) }}">
                        @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label for="phone" class="block text-lg font-medium">Phone</label>
                        <input type="text" name="phone" id="phone" class="mt-2 p-2 w-full border border-gray-300 rounded-lg" value="{{ old('phone', $service->phone) }}">
                        @error('phone') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label for="address" class="block text-lg font-medium">Address</label>
                        <textarea name="address" id="address" class="mt-2 p-2 w-full border border-gray-300 rounded-lg" rows="3">{{ old('address', $service->address) }}</textarea>
                        @error('address') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label for="image" class="block text-lg font-medium">Service Image</label>
                        <input type="file" name="image" id="image" class="mt-2 p-2 w-full border border-gray-300 rounded-lg">
                        @if ($service->image)
                            <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->name }}" class="mt-4 w-32">
                        @endif
                        @error('image') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label for="min_price" class="block text-lg font-medium">Minimum Price</label>
                        <input type="number" name="min_price" id="min_price" class="mt-2 p-2 w-full border border-gray-300 rounded-lg" value="{{ old('min_price', $service->min_price) }}" required>
                        @error('min_price') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label for="max_price" class="block text-lg font-medium">Maximum Price</label>
                        <input type="number" name="max_price" id="max_price" class="mt-2 p-2 w-full border border-gray-300 rounded-lg" value="{{ old('max_price', $service->max_price) }}" required>
                        @error('max_price') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="text-center">
                        <button type="submit" class="px-6 py-2 text-white bg-blue-500 rounded-lg">Update Service</button>
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>