<x-app-layouts title="Edit Design">
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Edit Design: {{ $design->title }}</h4>
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

            <form method="POST" action="{{ route('designer.designs.update', $design) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Title</label>
                    <input type="text" name="title" class="form-control" value="{{ old('title', $design->title) }}"
                        required>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Price (IDR)</label>
                        <input type="number" name="price" class="form-control"
                            value="{{ old('price', $design->price) }}" min="1000" required>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Status</label>
                        @php $st = old('status', $design->status); @endphp
                        <select name="status" class="form-select" required>
                            <option value="draft" {{ $st == 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="published" {{ $st == 'published' ? 'selected' : '' }}>Published</option>
                            <option value="archived" {{ $st == 'archived' ? 'selected' : '' }}>Archived</option>
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label d-block">Thumbnail</label>
                        @if ($design->thumbnail)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $design->thumbnail) }}" alt="Thumbnail"
                                    style="max-height:80px" class="img-thumbnail">
                            </div>
                        @endif
                        <input type="file" name="thumbnail" class="form-control">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label d-block">Categories</label>
                    <div class="row">
                        @foreach ($categories as $cat)
                            @php $checked = in_array($cat->id, (array) old('categories', $selected ?? [])); @endphp
                            <div class="col-md-3 col-6 mb-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="cat{{ $cat->id }}"
                                        name="categories[]" value="{{ $cat->id }}"
                                        {{ $checked ? 'checked' : '' }}>
                                    <label class="form-check-label" for="cat{{ $cat->id }}">
                                        {{ $cat->name }}
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="6">{{ old('description', $design->description) }}</textarea>
                </div>

                <div class="d-flex gap-2">
                    <button class="btn btn-primary">Save Changes</button>
                    <a href="{{ route('designer.designs.index') }}" class="btn btn-outline-secondary">Back</a>
                </div>
            </form>
        </div>
    </div>

    {{-- ===== MEDIA SECTION ===== --}}
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Design Media</h5>
            <form method="POST" action="{{ route('designer.designs.media.store', $design) }}"
                enctype="multipart/form-data" class="d-flex gap-2">
                @csrf
                <input type="file" name="file" class="form-control form-control-sm" required>
                <button class="btn btn-sm btn-success">
                    <i class="fas fa-upload"></i> Upload
                </button>
            </form>
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
                                    <img src="{{ asset('storage/' . $m->path) }}" alt="Media" class="img-fluid"
                                        style="max-height:150px; object-fit:cover;">
                                @else
                                    <video src="{{ asset('storage/' . $m->path) }}" class="w-100" controls
                                        style="max-height:150px;"></video>
                                @endif
                                <div class="mt-2">
                                    <form method="POST" action="{{ route('designer.designs.media.destroy', $m) }}"
                                        onsubmit="return confirm('Delete this media?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layouts>
