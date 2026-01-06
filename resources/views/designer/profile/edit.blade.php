<style>
    label.required::after {
        content: " *";
        color: red;
    }
</style>

<x-app-layouts title="Designer Profile">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Designer Profile</h4>
            <a href="{{ route('designer.dashboard') }}" class="btn btn-outline-secondary btn-sm">Back</a>
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
                $hasAvatar = $u && !empty($u->avatar);
                $qrisUrl = $designer->qris_image ? asset('storage/' . $designer->qris_image) : null;
            @endphp

            <form method="POST" action="{{ route('designer.profile.update') }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    {{-- Left: designer data --}}
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label class="form-label required">Display Name</label>
                            <input type="text" name="display_name" class="form-control"
                                value="{{ old('display_name', $designer->display_name) }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label required">Bio</label>
                            <textarea name="bio" class="form-control" rows="4" required>{{ old('bio', $designer->bio) }}</textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label required">Bank Name</label>
                                <input type="text" name="bank_name" class="form-control"
                                    value="{{ old('bank_name', $designer->bank_name) }}" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label required">Account Number</label>
                                <input type="text" name="bank_account_no" class="form-control"
                                    value="{{ old('bank_account_no', $designer->bank_account_no) }}" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label required">Account Holder Name</label>
                                <input type="text" name="bank_account_name" class="form-control"
                                    value="{{ old('bank_account_name', $designer->bank_account_name) }}" required>
                            </div>
                        </div>
                    </div>

                    {{-- WhatsApp --}}
                    <div class="col-md-4 mb-3">
                        <label class="form-label required">WhatsApp</label>
                        <input type="text" name="whatsapp"
                            class="form-control @error('whatsapp') is-invalid @enderror"
                            value="{{ old('whatsapp', $u->whatsapp) }}" placeholder="62xxxxxxxxxxx" inputmode="numeric"
                            pattern="^62\d{8,13}$"
                            title="Must start with 62 and contain digits only (e.g. 628123456789)"
                            oninput="
                                this.value = this.value.replace(/\D/g,'');
                                if (this.value.startsWith('0')) { this.value = '62' + this.value.slice(1); }
                            "
                            required>
                        @error('whatsapp')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Must start with <strong>62</strong>. Example: 628123456789.</small>
                    </div>

                    {{-- Right: profile photo (avatar) --}}
                    <div class="col-md-4">
                        <label class="form-label d-block">Profile Photo</label>
                        @if ($hasAvatar)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $u->avatar) }}" alt="Avatar" class="img-thumbnail"
                                    style="max-height:120px">
                            </div>
                        @endif
                        <input type="file" name="avatar" class="form-control">
                        <small class="text-muted d-block mt-1">Optional. Max 2MB. jpg/png/webp.</small>
                    </div>
                </div>

                <hr>

                {{-- QRIS --}}
                <div class="mb-3">
                    <label class="form-label d-block">QRIS (image)</label>

                    @if ($qrisUrl)
                        <div class="mb-2 text-md-start">
                            <a href="{{ $qrisUrl }}" target="_blank" rel="noopener" class="d-inline-block">
                                <img src="{{ $qrisUrl }}" alt="QRIS" style="max-height:140px"
                                    class="img-thumbnail">
                            </a>
                            <div class="mt-2 d-flex flex-wrap gap-2">
                                <a href="{{ $qrisUrl }}" target="_blank" rel="noopener"
                                    class="btn btn-sm btn-outline-secondary">
                                    Open in New Tab
                                </a>
                                <a href="{{ $qrisUrl }}" download class="btn btn-sm btn-primary">
                                    Download
                                </a>
                            </div>
                        </div>
                    @endif

                    <input type="file" name="qris_image" class="form-control">
                    <small class="text-muted">Optional. Max 2MB. Image file.</small>
                </div>

                <div class="d-flex gap-2">
                    <button class="btn btn-primary">Save</button>
                    <a href="{{ route('designer.dashboard') }}" class="btn btn-outline-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layouts>
