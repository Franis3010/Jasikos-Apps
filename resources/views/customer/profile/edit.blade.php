<style>
    label.required::after {
        content: " *";
        color: red;
    }
</style>

<x-app-layouts title="My Profile">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Customer Profile</h4>
            <a href="{{ route('customer.dashboard') }}" class="btn btn-outline-secondary btn-sm">Back</a>
        </div>

        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $e)
                            <li>{{ $e }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @php
                $u = auth()->user();
                $c = $u->customer;
            @endphp

            <form method="POST" action="{{ route('customer.profile.update') }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- Account Data --}}
                <div class="row">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label class="form-label required">Name</label>
                            <input type="text" name="name" class="form-control"
                                value="{{ old('name', $u->name) }}" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label required">Phone</label>
                                <input type="text" name="phone" class="form-control"
                                    value="{{ old('phone', $u->phone) }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label required">WhatsApp</label>
                                <input type="text" name="whatsapp" class="form-control"
                                    value="{{ old('whatsapp', $u->whatsapp) }}" required>
                                <small class="text-muted">Use 62… format</small>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label required d-block">Avatar</label>
                        @if ($u->avatar)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $u->avatar) }}" alt="Avatar" class="img-thumbnail"
                                    style="max-height:120px">
                            </div>
                        @endif
                        <input type="file" name="avatar" class="form-control" >
                        <small class="text-muted">Optional. Max 2MB.</small>
                    </div>
                </div>

                <hr>

                {{-- Address --}}
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label required">Address</label>
                        <input type="text" name="address" class="form-control" required
                            value="{{ old('address', $c->address ?? '') }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label required">City</label>
                        <input type="text" name="city" class="form-control" required
                            value="{{ old('city', $c->city ?? '') }}">
                    </div>
                    <div class="col-md-6 mb-3 required">
                        <label class="form-label required">Province</label>
                        <input type="text" name="province" class="form-control" required
                            value="{{ old('province', $c->province ?? '') }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label required">Postal Code</label>
                        <input type="text" name="postal_code" class="form-control" required
                            value="{{ old('postal_code', $c->postal_code ?? '') }}">
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button class="btn btn-primary">Save</button>
                    <a href="{{ route('customer.dashboard') }}" class="btn btn-outline-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layouts>
