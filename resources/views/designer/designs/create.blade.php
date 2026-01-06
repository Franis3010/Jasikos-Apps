<x-app-layouts title="Create New Design">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Create New Design</h4>
        </div>

        <div class="card-body">
            {{-- Validation errors --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $e)
                            <li>{{ $e }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('designer.designs.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Title</label>
                    <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Price (IDR)</label>
                        <input type="number" name="price" class="form-control" value="{{ old('price') }}"
                            min="1000" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select" required>
                            @php $st = old('status','draft'); @endphp
                            <option value="draft" {{ $st == 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="published" {{ $st == 'published' ? 'selected' : '' }}>Published</option>
                            <option value="archived" {{ $st == 'archived' ? 'selected' : '' }}>Archived</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Thumbnail</label>
                        <input type="file" name="thumbnail" class="form-control">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="6">{{ old('description') }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label d-block">Categories</label>
                    <div class="row">
                        @foreach ($categories as $cat)
                            <div class="col-md-3 col-6 mb-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="cat{{ $cat->id }}"
                                        name="categories[]" value="{{ $cat->id }}"
                                        {{ in_array($cat->id, (array) old('categories', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="cat{{ $cat->id }}">
                                        {{ $cat->name }}
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button class="btn btn-primary">Save</button>
                    <a href="{{ route('designer.designs.index') }}" class="btn btn-outline-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layouts>
