<x-app-layouts title="Design Details">
    <div class="card mb-3">
        <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
            <h5 class="mb-0">Design Details</h5>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.designs.index') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-arrow-left me-1"></i>Back
                </a>
                <form method="POST" action="{{ route('admin.designs.destroy', $design) }}"
                    onsubmit="return confirm('Delete this design along with its media?')">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash me-1"></i>Delete</button>
                </form>
            </div>
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

            <div class="row g-4">
                {{-- Left: Details + Description + Media --}}
                <div class="col-lg-8 order-2 order-lg-1">
                    {{-- Detail header --}}
                    <div class="d-flex align-items-start gap-3 flex-wrap">
                        @if ($design->thumbnail)
                            <img src="{{ asset('storage/' . $design->thumbnail) }}" class="rounded border"
                                style="width:120px;height:120px;object-fit:cover" alt="thumbnail">
                        @else
                            <div class="rounded bg-light border d-flex align-items-center justify-content-center"
                                style="width:120px;height:120px;">No Image</div>
                        @endif

                        <div class="flex-grow-1 min-w-0">
                            <div class="d-flex align-items-center flex-wrap gap-2">
                                <h4 class="mb-0 text-truncate">{{ $design->title }}</h4>
                                @if ($design->is_featured)
                                    <span class="badge bg-warning text-dark">Featured</span>
                                @endif
                                @php
                                    $cls =
                                        ['draft' => 'secondary', 'published' => 'success', 'archived' => 'dark'][
                                            $design->status
                                        ] ?? 'secondary';
                                @endphp
                                <span class="badge bg-{{ $cls }}">{{ ucfirst($design->status) }}</span>
                            </div>

                            <div class="small text-muted mt-1">Slug: <code
                                    class="user-select-all">{{ $design->slug }}</code></div>

                            <div class="row g-2 mt-2">
                                <div class="col-md-6">
                                    <div><strong>Designer:</strong>
                                        {{ $design->designer->display_name ?? ($design->designer->user->name ?? '-') }}
                                    </div>
                                    <div><strong>Price:</strong> Rp {{ number_format($design->price, 0, ',', '.') }}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div>
                                        <strong>Categories:</strong>
                                        @forelse($design->categories as $c)
                                            <span class="badge bg-light text-dark me-1">{{ $c->name }}</span>
                                        @empty
                                            <span class="text-muted">-</span>
                                        @endforelse
                                    </div>
                                </div>
                            </div>

                            <div class="small text-muted mt-2">
                                Created: {{ $design->created_at?->format('d-m-Y H:i') }} •
                                Updated: {{ $design->updated_at?->format('d-m-Y H:i') }}
                            </div>
                        </div>
                    </div>

                    <hr>

                    {{-- Description --}}
                    <div class="mb-2 fw-semibold">Description</div>
                    <div class="border rounded p-3 bg-light-subtle" style="min-height:80px">
                        {!! nl2br(e($design->description ?? '-')) !!}
                    </div>

                    <hr>

                    {{-- Media --}}
                    <div class="mb-2 d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">Media</h5>
                        @if ($design->media->count())
                            <span class="badge bg-secondary">{{ $design->media->count() }} files</span>
                        @endif
                    </div>

                    @if ($design->media->count())
                        <div class="row row-cols-2 row-cols-md-4 g-3">
                            @foreach ($design->media as $m)
                                <div class="col">
                                    <div class="border rounded h-100 overflow-hidden">
                                        <div class="position-relative ratio ratio-4x3" style="background:#f8f9fa">
                                            @if ($m->type === 'image')
                                                <img src="{{ asset('storage/' . $m->path) }}" class="w-100 h-100"
                                                    style="object-fit:cover" alt="media">
                                            @else
                                                <div
                                                    class="d-flex align-items-center justify-content-center w-100 h-100 text-muted">
                                                    <i class="fas fa-video me-2"></i> Video
                                                </div>
                                                <div class="position-absolute top-50 start-50 translate-middle">
                                                    <i class="fas fa-play-circle fs-3 text-white text-shadow"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="p-2">
                                            <div class="small text-muted">#{{ $m->id }} •
                                                {{ strtoupper($m->type) }} • Sort: {{ $m->sort_order }}</div>
                                            <a href="{{ asset('storage/' . $m->path) }}" target="_blank"
                                                class="btn btn-sm btn-outline-secondary mt-2 w-100">
                                                <i class="fas fa-external-link-alt me-1"></i>Open File
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-muted">No media yet.</div>
                    @endif
                </div>

                {{-- Right: Update Status (sticky) --}}
                <div class="col-lg-4 order-1 order-lg-2">
                    <div class="border rounded p-3 position-sticky" style="top: 1rem">
                        <div class="fw-semibold mb-3">Update Status</div>
                        <form method="POST" action="{{ route('admin.designs.update', $design) }}">
                            @csrf @method('PUT')
                            <div class="mb-2">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-select" required>
                                    @foreach (['draft', 'published', 'archived'] as $s)
                                        <option value="{{ $s }}" @selected($design->status === $s)>
                                            {{ ucfirst($s) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" name="is_featured" value="1"
                                    id="is_featured" @checked($design->is_featured)>
                                <label class="form-check-label" for="is_featured">Mark as Featured</label>
                            </div>
                            <button class="btn btn-primary w-100">Save Changes</button>
                        </form>
                    </div>
                </div>
            </div>
        </div> {{-- /card-body --}}
    </div>
</x-app-layouts>
