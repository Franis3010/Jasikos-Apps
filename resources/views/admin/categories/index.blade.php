<x-app-layouts title="Categories">
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h5 class="mb-0">Categories</h5>
            <a href="{{ route('admin.categories.create') }}" class="btn btn-sm btn-primary">Create</a>
        </div>
        <div class="card-body table-responsive">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Slug</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $c)
                        <tr>
                            <td>{{ $c->name }}</td>
                            <td>{{ $c->slug }}</td>
                            <td class="text-end">
                                <a class="btn btn-sm btn-outline-primary"
                                    href="{{ route('admin.categories.edit', $c) }}">Edit</a>
                                <form class="d-inline" method="POST"
                                    action="{{ route('admin.categories.destroy', $c) }}"
                                    onsubmit="return confirm('Hapus?')">
                                    @csrf @method('DELETE') <button
                                        class="btn btn-sm btn-outline-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-2">{{ $categories->links() }}</div>
        </div>
    </div>
</x-app-layouts>
