<x-app-layouts title="Edit Category">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Edit Category — {{ $category->name }}</h5>
            <a href="{{ route('admin.categories.index') }}" class="btn btn-sm btn-outline-secondary">Back</a>
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

            <form method="POST" action="{{ route('admin.categories.update', $category) }}" class="row g-3">
                @csrf
                @method('PUT')

                <div class="col-md-6">
                    <label class="form-label">Name</label>
                    <input type="text" name="name" id="name" class="form-control"
                        value="{{ old('name', $category->name) }}" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Slug</label>
                    <input type="text" name="slug" id="slug" class="form-control"
                        value="{{ old('slug', $category->slug) }}" required>
                    <div class="form-text">Ensure it’s unique to avoid URL conflicts.</div>
                </div>

                <div class="col-12 d-flex gap-2">
                    <button class="btn btn-primary">Save Changes</button>
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">Cancel</a>
                </div>
            </form>

            <hr class="my-4">

            {{-- Optional: delete directly from the edit page --}}
            <form method="POST" action="{{ route('admin.categories.destroy', $category) }}"
                onsubmit="return confirm('Are you sure you want to delete this category?')" class="mt-2">
                @csrf @method('DELETE')
                <button class="btn btn-outline-danger btn-sm">Delete Category</button>
            </form>
        </div>
    </div>

    <script>
        // Auto-slug while editing (if the user hasn't touched the slug field)
        const nm = document.getElementById('name');
        const sg = document.getElementById('slug');
        if (nm && sg) {
            const initialSlug = sg.value;
            const toSlug = s => s
                .toString()
                .normalize('NFD').replace(/[\u0300-\u036f]/g, '')
                .toLowerCase()
                .replace(/[^a-z0-9\s-]/g, '')
                .trim()
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-');
            nm.addEventListener('input', () => {
                if (sg.value === initialSlug || sg.dataset.touched !== '1') {
                    sg.value = toSlug(nm.value);
                }
            });
            sg.addEventListener('input', () => sg.dataset.touched = '1');
        }
    </script>
</x-app-layouts>
