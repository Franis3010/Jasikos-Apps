<x-app-layouts title="Create Custom Request">
    <div class="card">
        <div class="card-header">
            <h4 class="mb-0">Create Custom Request</h4>
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $e)
                            <li>{{ $e }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('customer.custom-requests.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Title</label>
                    <input type="text" name="title" class="form-control" required value="{{ old('title') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Choose Designer (optional)</label>
                    <select name="designer_id" class="form-select">
                        <option value="">Any/Suggest</option>
                        @foreach ($designers as $d)
                            <option value="{{ $d->id }}" @selected(old('designer_id') == $d->id)>
                                {{ $d->display_name ?? $d->user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Brief</label>
                    <textarea name="brief" class="form-control" rows="5" placeholder="Describe requirements, sizes, deadline, etc.">{{ old('brief') }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Revision Limit (default 2)</label>
                    <input type="number" name="revisions_allowed" class="form-control" min="1" max="10"
                        value="{{ old('revisions_allowed', 2) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Reference Links (optional)</label>
                    <div id="links">
                        <input type="url" name="reference_links[]" class="form-control mb-2"
                            placeholder="https://..." value="{{ old('reference_links.0') }}">
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-secondary" onclick="addLink()">Add
                        Link</button>
                </div>

                <div class="mb-3">
                    <label class="form-label">Upload References (optional)</label>
                    <input type="file" name="files[]" class="form-control" multiple>
                    <small class="text-muted">Max 8MB/file.</small>
                </div>

                {{-- === NEW: Delivery Method === --}}
                <hr>
                <div class="mb-2">
                    <label class="form-label mb-1">Delivery Method</label>
                    <div class="d-flex gap-3">
                        <label class="mb-0">
                            <input type="radio" name="shipping_method" value="digital"
                                {{ old('shipping_method', 'digital') === 'digital' ? 'checked' : '' }}>
                            Digital Download
                        </label>
                        <label class="mb-0">
                            <input type="radio" name="shipping_method" value="ship"
                                {{ old('shipping_method') === 'ship' ? 'checked' : '' }}>
                            Ship Package
                        </label>
                    </div>
                    <small class="text-muted">If you choose Ship Package, please fill in the address below so the
                        designer can estimate the shipping cost.</small>
                </div>

                <div id="shipFields"
                    class="border rounded p-3 mt-2 {{ old('shipping_method', 'digital') === 'ship' ? '' : 'd-none' }}">
                    <div class="row g-2">
                        <div class="col-md-6">
                            <input class="form-control" name="ship_name" placeholder="Recipient name"
                                value="{{ old('ship_name') }}">
                        </div>
                        <div class="col-md-6">
                            <input class="form-control" name="ship_phone" placeholder="Phone"
                                value="{{ old('ship_phone') }}">
                        </div>
                        <div class="col-12">
                            <input class="form-control" name="ship_address" placeholder="Address"
                                value="{{ old('ship_address') }}">
                        </div>
                        <div class="col-md-4">
                            <input class="form-control" name="ship_city" placeholder="City"
                                value="{{ old('ship_city') }}">
                        </div>
                        <div class="col-md-4">
                            <input class="form-control" name="ship_province" placeholder="Province"
                                value="{{ old('ship_province') }}">
                        </div>
                        <div class="col-md-4">
                            <input class="form-control" name="ship_postal_code" placeholder="Postal Code"
                                value="{{ old('ship_postal_code') }}">
                        </div>
                    </div>
                </div>

                <div class="d-flex gap-2 mt-3">
                    <button class="btn btn-primary">Submit</button>
                    <a href="{{ route('customer.custom-requests.index') }}"
                        class="btn btn-outline-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        function addLink() {
            const el = document.createElement('input');
            el.type = 'url';
            el.name = 'reference_links[]';
            el.className = 'form-control mb-2';
            el.placeholder = 'https://...';
            document.getElementById('links').appendChild(el);
        }

        const radios = document.querySelectorAll('input[name="shipping_method"]');
        const shipBox = document.getElementById('shipFields');

        function toggleShip() {
            const v = document.querySelector('input[name="shipping_method"]:checked').value;
            shipBox.classList.toggle('d-none', v !== 'ship');
        }
        radios.forEach(r => r.addEventListener('change', toggleShip));
    </script>
</x-app-layouts>
