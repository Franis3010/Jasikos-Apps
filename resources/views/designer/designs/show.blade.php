<x-app-layouts title="Design Details">

    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0">{{ $design->title }}</h4>
            <div class="d-flex gap-2">
                <a href="{{ route('designer.designs.edit', $design) }}" class="btn btn-primary btn-sm">Edit</a>
                <a href="{{ route('designer.designs.index') }}" class="btn btn-outline-secondary btn-sm">Back</a>
            </div>
        </div>

        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-4">
                    @if ($design->thumbnail)
                        <img src="{{ asset('storage/' . $design->thumbnail) }}" class="img-fluid rounded border">
                    @else
                        <div class="border rounded p-4 text-center text-muted">No thumbnail</div>
                    @endif
                </div>
                <div class="col-md-8">
                    <div class="mb-2"><strong>Price:</strong> Rp {{ number_format($design->price, 0, ',', '.') }}
                    </div>
                    <div class="mb-2"><strong>Status:</strong>
                        <span
                            class="badge bg-{{ $design->status === 'published' ? 'success' : ($design->status === 'draft' ? 'secondary' : 'dark') }}">
                            {{ ucfirst($design->status) }}
                        </span>
                    </div>
                    <div class="mb-2"><strong>Categories:</strong>
                        {{ $design->categories()->pluck('name')->implode(', ') ?: '-' }}</div>
                    <div class="mb-2"><strong>Slug:</strong> {{ $design->slug }}</div>
                    <div class="mb-2"><strong>Created:</strong> {{ $design->created_at->format('d-m-Y H:i') }}</div>
                    <div class="mb-2"><strong>Updated:</strong> {{ $design->updated_at->format('d-m-Y H:i') }}</div>
                </div>
            </div>

            <div class="mt-3">
                <strong>Description:</strong>
                <div class="mt-1">{!! nl2br(e($design->description)) !!}</div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Media</h5>
            <a href="{{ route('designer.designs.edit', $design) }}" class="btn btn-sm btn-success">
                Manage Media
            </a>
        </div>
        <div class="card-body">
            @if ($design->media->count() === 0)
                <p class="text-muted mb-0">No media yet.</p>
            @else
                <div class="row">
                    @foreach ($design->media as $m)
                        <div class="col-md-3 col-6 mb-3">
                            <div class="border rounded p-2 text-center">
                                @if ($m->type === 'image')
                                    <img src="{{ asset('storage/' . $m->path) }}" class="img-fluid"
                                        style="max-height:150px;object-fit:cover;">
                                @else
                                    <video src="{{ asset('storage/' . $m->path) }}" class="w-100" controls
                                        style="max-height:150px;"></video>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layouts>
