<x-app-layouts title="My Designs">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0">My Designs</h4>
            <a href="{{ route('designer.designs.create') }}" class="btn btn-success btn-sm">
                <i class="fas fa-plus"></i> Add Design
            </a>
        </div>

        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="thead-dark">
                        <tr>
                            <th>No.</th>
                            <th>Thumbnail</th>
                            <th>Title</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th>Categories</th>
                            <th>Media</th>
                            <th>Updated</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($designs as $i => $d)
                            <tr>
                                <td>{{ $designs->firstItem() + $i }}</td>
                                <td style="width:90px">
                                    @if ($d->thumbnail)
                                        <img src="{{ asset('storage/' . $d->thumbnail) }}" class="img-thumbnail"
                                            style="max-height:70px">
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td class="fw-semibold">{{ $d->title }}</td>
                                <td>Rp {{ number_format($d->price, 0, ',', '.') }}</td>
                                <td>
                                    <span
                                        class="badge bg-{{ $d->status === 'published' ? 'success' : ($d->status === 'draft' ? 'secondary' : 'dark') }}">
                                        {{ ucfirst($d->status) }}
                                    </span>
                                </td>
                                <td>
                                    {{ $d->categories()->pluck('name')->implode(', ') ?: '-' }}
                                </td>
                                <td>{{ $d->media()->count() }}</td>
                                <td>{{ $d->updated_at->format('d-m-Y H:i') }}</td>
                                <td>
                                    <div class="d-flex gap-1">
                                        <a href="{{ route('designer.designs.show', $d) }}"
                                            class="btn btn-sm btn-info">Show</a>
                                        <a href="{{ route('designer.designs.edit', $d) }}"
                                            class="btn btn-sm btn-primary">Edit</a>
                                        <form method="POST" action="{{ route('designer.designs.destroy', $d) }}"
                                            onsubmit="return confirm('Are you sure you want to delete this design?')">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-danger">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center">No designs yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-2">
                {{ $designs->withQueryString()->links() }}
            </div>
        </div>
    </div>
</x-app-layouts>
