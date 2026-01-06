<x-app-layouts title="Add Category">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Add Category</h5>
            <a href="{{ route('admin.categories.index') }}" class="btn btn-sm btn-outline-secondary">Back</a>
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

            <form method="POST" action="{{ route('admin.categories.store') }}" class="row g-3">
                @csrf

                <div class="col-md-6">
                    <label class="form-label">Name</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}"
                        placeholder="Category name" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Slug</label>
                    <input type="text" name="slug" id="slug" class="form-control" value="{{ old('slug') }}"
                        placeholder="category-slug" required>
                    <div class="form-text">Slug can be changed before saving.</div>
                </div>

                <div class="col-12 d-flex gap-2">
                    <button class="btn btn-primary">Save</button>
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Auto-slug from Name (optional)
        const nm = document.getElementById('name');
        const sg = document.getElementById('slug');
        if (nm && sg) {
            const toSlug = s => s
                .toString()
                .normalize('NFD').replace(/[\u0300-\u036f]/g, '')
                .toLowerCase()
                .replace(/[^a-z0-9\s-]/g, '')
                .trim()
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-');
            nm.addEventListener('input', () => {
                if (!sg.value || sg.dataset.touched !== '1') {
                    sg.value = toSlug(nm.value);
                }
            });
            sg.addEventListener('input', () => sg.dataset.touched = '1');
        }
    </script>
</x-app-layouts>
