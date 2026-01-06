<x-app-layouts title="My Cart">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Cart</h4>
            {{-- Move the Checkout button below as part of the form --}}
        </div>

        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if (!$cart->items->count())
                <p class="text-muted mb-0">Cart is empty.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered align-middle">
                        <thead>
                            <tr>
                                <th>Design</th>
                                <th>Designer</th>
                                <th>Price</th>
                                <th>Qty</th>
                                <th>Subtotal</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cart->items as $it)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            @if ($it->design->thumbnail)
                                                <img src="{{ asset('storage/' . $it->design->thumbnail) }}"
                                                    style="height:50px" class="rounded">
                                            @endif
                                            <div>{{ $it->design->title }}</div>
                                        </div>
                                    </td>
                                    <td>{{ $it->design->designer->display_name ?? $it->design->designer->user->name }}
                                    </td>
                                    <td>Rp {{ number_format($it->price_snapshot, 0, ',', '.') }}</td>
                                    <td>{{ $it->qty }}</td>
                                    <td>Rp {{ number_format($it->price_snapshot * $it->qty, 0, ',', '.') }}</td>
                                    <td class="text-end">
                                        @php
                                            $designer = $it->design->designer ?? null;
                                            $waNumber = $designer?->user?->whatsapp ?? null; // 62…
                                            $waDigits = $waNumber ? preg_replace('/\D/', '', $waNumber) : null;
                                            $msg =
                                                "Halo kak {$designer?->display_name}, saya mau tanya soal item di keranjang: " .
                                                "{$it->design->title} (Qty {$it->qty}).";
                                            $waLink = $waDigits
                                                ? "https://wa.me/{$waDigits}?text=" . urlencode($msg)
                                                : null;
                                        @endphp

                                        @if ($waLink)
                                            <a href="{{ $waLink }}" target="_blank" rel="noopener"
                                                class="btn btn-sm btn-outline-success me-2">
                                                <i class="bi bi-whatsapp"></i> Ask via WA
                                            </a>
                                        @endif

                                        <form method="POST" action="{{ route('customer.cart.destroy', $it) }}"
                                            class="d-inline" onsubmit="return confirm('Remove this item?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger">Remove</button>
                                        </form>
                                    </td>

                                </tr>
                            @endforeach
                            <tr>
                                <td colspan="4" class="text-end fw-semibold">Total</td>
                                <td colspan="2" class="fw-bold">Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                            </tr>
                        </tbody>
                    </table>
                    @php
                        // Kumpulkan designer unik di cart
                        $waButtons = collect($cart->items)
                            ->map(function ($it) {
                                $d = $it->design->designer ?? null;
                                $num = $d?->user?->whatsapp ?? null;
                                if (!$num) {
                                    return null;
                                }
                                $digits = preg_replace('/\D/', '', $num);
                                return [
                                    'name' => $d?->display_name ?? 'Designer',
                                    'link' =>
                                        "https://wa.me/{$digits}?text=" .
                                        urlencode(
                                            "Halo kak {$d?->display_name}, saya mau konsultasi dulu terkait orderan di keranjang saya.",
                                        ),
                                ];
                            })
                            ->filter()
                            ->unique('link')
                            ->values();
                    @endphp

                    @if ($waButtons->isNotEmpty())
                        <div class="mt-3 d-flex flex-wrap gap-2">
                            @foreach ($waButtons as $btn)
                                <a href="{{ $btn['link'] }}" target="_blank" rel="noopener"
                                    class="btn btn-outline-success btn-sm">
                                    <i class="bi bi-whatsapp"></i> Chat {{ $btn['name'] }}
                                </a>
                            @endforeach
                        </div>
                    @endif

                </div>

                {{-- ==== CHECKOUT + SHIPPING FORM ==== --}}
                <form method="POST" action="{{ route('customer.checkout.store') }}" class="mt-3">
                    @csrf

                    {{-- Choose shipping method --}}
                    <div class="mb-3">
                        <label class="form-label">Shipping Method</label>
                        <div class="d-flex flex-wrap gap-3">
                            <label class="me-3 mb-0">
                                <input type="radio" name="shipping_method" value="digital" checked>
                                Digital Download
                            </label>
                            <label class="mb-0">
                                <input type="radio" name="shipping_method" value="ship">
                                Ship Package
                            </label>
                        </div>
                    </div>

                    {{-- Address fields shown only if "ship" --}}
                    <div id="shipFields" class="border rounded p-4 mt-2 d-none">
                        <div class="row gy-3 gx-3">
                            <div class="col-md-6">
                                <input class="form-control" name="ship_name" placeholder="Recipient name"
                                    value="{{ old('ship_name') }}">
                            </div>
                            <div class="col-md-6">
                                <input class="form-control" name="ship_phone" placeholder="Phone number"
                                    value="{{ old('ship_phone') }}">
                            </div>
                            <div class="col-12 mt-4">
                                <input class="form-control" name="ship_address" placeholder="Address"
                                    value="{{ old('ship_address') }}">
                            </div>
                            <div class="col-md-4 mt-4">
                                <input class="form-control" name="ship_city" placeholder="City"
                                    value="{{ old('ship_city') }}">
                            </div>
                            <div class="col-md-4 mt-4">
                                <input class="form-control" name="ship_province" placeholder="Province"
                                    value="{{ old('ship_province') }}">
                            </div>
                            <div class="col-md-4 mt-4">
                                <input class="form-control" name="ship_postal_code" placeholder="Postal Code"
                                    value="{{ old('ship_postal_code') }}">
                            </div>
                            {{-- <div class="col-md-4 mt-4">
                                <input type="number" class="form-control" name="shipping_fee"
                                    placeholder="Shipping Fee (optional)" value="{{ old('shipping_fee') }}">
                            </div> --}}
                        </div>
                    </div>

                    <div class="mt-3 d-flex justify-content-end">
                        <button class="btn btn-primary">Checkout</button>
                    </div>
                </form>

                @push('lastScripts')
                    <script>
                        const radios = document.querySelectorAll('input[name="shipping_method"]');
                        const box = document.getElementById('shipFields');

                        function toggleBox() {
                            const val = document.querySelector('input[name="shipping_method"]:checked')?.value;
                            if (!box) return;
                            if (val === 'ship') box.classList.remove('d-none');
                            else box.classList.add('d-none');
                        }
                        radios.forEach(r => r.addEventListener('change', toggleBox));
                        toggleBox();
                    </script>
                @endpush
            @endif
        </div>
    </div>
</x-app-layouts>
