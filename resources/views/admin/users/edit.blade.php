{{-- resources/views/admin/users/edit.blade.php --}}
<x-app-layouts title="Edit User">
    @php $isSelf = auth()->id() === $user->id; @endphp

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Edit User — {{ $user->name }}</h4>
            <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-outline-secondary">Back</a>
        </div>

        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('warning'))
                <div class="alert alert-warning">{{ session('warning') }}</div>
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

            <div class="row g-4">
                <div class="col-lg-8">
                    <form method="POST" action="{{ route('admin.users.update', $user) }}" class="row g-3">
                        @csrf
                        @method('PUT')

                        {{-- Role (FULL WIDTH so Phone & WhatsApp can sit side-by-side on the next row) --}}
                        <div class="col-12"><!-- was: col-md-6 -->
                            <label for="role" class="form-label">Role</label>
                            <select name="role" id="role"
                                class="form-select @error('role') is-invalid @enderror" @disabled($isSelf)>
                                @foreach (['admin', 'designer', 'customer'] as $r)
                                    <option value="{{ $r }}" @selected(old('role', $user->role) === $r)>{{ ucfirst($r) }}
                                    </option>
                                @endforeach
                            </select>
                            @if ($isSelf)
                                <input type="hidden" name="role" value="admin">
                                <div class="form-text text-warning">You cannot change your own account role to
                                    non-admin.</div>
                            @endif
                            @error('role')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Phone (left) --}}
                        <div class="col-md-6">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="text" name="phone" id="phone"
                                class="form-control @error('phone') is-invalid @enderror"
                                value="{{ old('phone', $user->phone) }}" placeholder="0821xxxxxxx" maxlength="30"
                                autocomplete="tel" autofocus>
                            <div class="form-text">Optional. Max 30 characters.</div>
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- WhatsApp (right) --}}
                        <div class="col-md-6">
                            <label for="whatsapp" class="form-label">WhatsApp</label>
                            <input type="text" name="whatsapp" id="whatsapp"
                                class="form-control @error('whatsapp') is-invalid @enderror"
                                value="{{ old('whatsapp', $user->whatsapp) }}" placeholder="62812xxxxxxx"
                                maxlength="30" inputmode="numeric">
                            <div class="form-text">Optional. International format without + (e.g., 62812xxxx).</div>
                            @error('whatsapp')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12 d-flex gap-2">
                            <button class="btn btn-primary">Save Changes</button>
                            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">Cancel</a>
                        </div>
                    </form>
                </div>

                <div class="col-lg-4">
                    <div class="p-3 border rounded mb-3">
                        <div class="mb-2">
                            <small class="text-muted d-block">Name</small>
                            <strong>{{ $user->name }}</strong>
                        </div>
                        <div class="mb-2">
                            <small class="text-muted d-block">Email</small>
                            <span>{{ $user->email }}</span>
                        </div>
                        <div class="mb-0">
                            <small class="text-muted d-block">Created</small>
                            <span>{{ $user->created_at?->format('d M Y H:i') }}</span>
                        </div>
                    </div>

                    @if (!$isSelf)
                        <div class="border border-danger rounded p-3">
                            <h6 class="text-danger mb-2">Delete User</h6>
                            <p class="mb-3 text-muted">This action cannot be undone.</p>
                            <form method="POST" action="{{ route('admin.users.destroy', $user) }}"
                                onsubmit="return confirm('Are you sure you want to delete this user?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-outline-danger w-100">Delete User</button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layouts>
