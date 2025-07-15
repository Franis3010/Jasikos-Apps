<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Jasikos - Admin Homepage</title>
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

        <div class="flex-shrink-0 ml-4">
            <a href="{{ route('service.adminshow') }}" class="inline-block">
                <img 
                    src="{{ asset('storage/logo/clothes.jpeg') }}" 
                    alt="Clothes" 
                    class="h-10 w-10 object-cover rounded hover:opacity-80 transition">
            </a>
        </div>
        
        <!-- Profile Dropdown Button -->
        <div class="flex-shrink-0 ml-auto relative">
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
        <h1 class="text-3xl font-bold text-center mb-6">Services in User Carts</h1>

        <div class="bg-white shadow-md rounded p-4">
            <table class="min-w-full table-auto">
                <thead>
                    <tr class="bg-gray-100 text-left">
                        <th class="px-4 py-2">User</th>
                        <th class="px-4 py-2">Email</th>
                        <th class="px-4 py-2">Service</th>
                        <th class="px-4 py-2">Range Price</th>
                        <th class="px-4 py-2">Price</th>
                        <th class="px-4 py-2">Status</th>
                        <th class="px-4 py-2 text-center">Verify</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($cartedServices as $entry)
                        <tr class="border-t">
                            <td class="px-4 py-2">{{ $entry->user->name }}</td>
                            <td class="px-4 py-2">{{ $entry->user->email }}</td>
                            <td class="px-4 py-2">{{ $entry->service->name }}</td>
                            <td class="px-4 py-2">{{ $entry->service->min_price }} - {{ $entry->service->max_price }}</td>
                            <td class="px-4 py-2">{{ $entry->price }}</td>
                            <td class="px-4 py-2">
                                {{ ucfirst(str_replace('_', ' ', $entry->state ?? 'unknown')) }}
                            </td>
                            <td class="px-4 py-2 text-center">
                                @if ($entry->state === 'sent')
                                    <div x-data="{ 
                                        showModal: false, 
                                        price: '', 
                                        error: '', 
                                        confirm: false, 
                                        showCancelConfirm: false 
                                    }">
                                        <!-- Accept Button -->
                                        <button @click="showModal = true"
                                                class="bg-green-500 hover:bg-green-600 text-white text-sm px-3 py-1 rounded">
                                            Accept
                                        </button>

                                        <!-- Cancel Button -->
                                        <button @click="showCancelConfirm = true"
                                                type="button"
                                                class="bg-red-500 hover:bg-red-600 text-white text-sm px-3 py-1 rounded">
                                            Cancel
                                        </button>

                                        <!-- Cancel Confirmation Modal -->
                                        <template x-if="showCancelConfirm">
                                            <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50" x-cloak>
                                                <div class="bg-white p-6 rounded shadow-lg max-w-sm w-full text-center">
                                                    <h2 class="text-lg font-semibold mb-3">Confirm Cancellation</h2>
                                                    <p class="text-gray-700 text-sm mb-4">Are you sure you want to cancel this user request?</p>

                                                    <div class="flex justify-center gap-4">
                                                        <!-- Cancel: close the modal -->
                                                        <button @click="showCancelConfirm = false"
                                                                class="bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400">
                                                            No
                                                        </button>

                                                        <!-- Confirm: submit the form -->
                                                        <form method="POST" action="{{ route('cart.reject', $entry->id) }}">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button type="submit"
                                                                    class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
                                                                Yes, Cancel
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </template>

                                        <!-- Accept Price Modal -->
                                        <div x-show="showModal" x-cloak class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
                                            <div class="bg-white p-6 rounded shadow-md w-full max-w-md">
                                                <h2 class="text-lg font-semibold mb-2">Enter Price</h2>
                                                <input type="number" step="0.01"
                                                    x-model="price"
                                                    class="w-full border rounded px-3 py-2 mb-2"
                                                    placeholder="Enter price">

                                                <template x-if="error">
                                                    <p class="text-red-500 text-sm mb-2" x-text="error"></p>
                                                </template>

                                                <template x-if="confirm">
                                                    <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
                                                        <div class="bg-white p-6 rounded shadow-lg max-w-sm w-full">
                                                            <h2 class="text-lg font-semibold mb-3">Confirm Acceptance</h2>
                                                            <p class="text-gray-700 text-sm mb-4">Do you want to accept this request with the given price?</p>

                                                            <div class="flex justify-end space-x-3">
                                                                <button @click="confirm = false"
                                                                        class="bg-gray-200 text-gray-800 px-4 py-2 rounded hover:bg-gray-300">
                                                                    Cancel
                                                                </button>
                                                                <form method="POST" :action="'{{ route('cart.accept', ['id' => '__id__']) }}'.replace('__id__', {{ $entry->id }})">
                                                                    @csrf
                                                                    @method('PATCH')
                                                                    <input type="hidden" name="price" :value="price">
                                                                    <button type="submit"
                                                                            class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                                                                        Yes, Accept
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </template>

                                                <div class="flex justify-end gap-2 mt-4">
                                                    <button @click="showModal = false"
                                                            class="bg-gray-300 hover:bg-gray-400 text-sm px-4 py-2 rounded">
                                                        Cancel
                                                    </button>
                                                    <form method="POST" action="{{ route('cart.accept', $entry->id) }}">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="price" :value="price">
                                                        <button type="button"
                                                                @click.prevent="
                                                                    error = '';
                                                                    const min = {{ $entry->service->min_price }};
                                                                    const max = {{ $entry->service->max_price }};
                                                                    if (!price) {
                                                                        error = 'Price is required.';
                                                                        return;
                                                                    }
                                                                    if (price < min || price > max) {
                                                                        error = 'Price must be between ' + min + ' and ' + max + '.';
                                                                        return;
                                                                    }
                                                                    confirm = true;
                                                                "
                                                                class="bg-blue-500 hover:bg-blue-600 text-white text-sm px-4 py-2 rounded">
                                                            Accept
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @elseif ($entry->state === 'draft')
                                    <span class="text-yellow-500 font-semibold">Pending</span>
                                @elseif ($entry->state === 'cancelled')
                                    <span class="text-blue-500 font-semibold">cancelled</span>
                                @endif
                            
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-4 text-gray-500">No services in carts.</td> {{-- colspan 4 karena ada 4 kolom --}}
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>