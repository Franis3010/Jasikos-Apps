<x-app-layouts title="Designs">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Designs</h5>
            <form class="d-flex gap-2" method="GET">
                @php $status = request('status'); @endphp
                <select name="status" class="form-select form-select-sm" style="width:200px">
                    <option value="">All Status</option>
                    @foreach (['draft', 'published', 'archived'] as $s)
                        <option value="{{ $s }}" @selected($status === $s)>{{ ucfirst($s) }}</option>
                    @endforeach
                </select>
                <button class="btn btn-sm btn-primary">Filter</button>
                @if ($status)
                    <a href="{{ route('admin.designs.index') }}" class="btn btn-sm btn-outline-secondary">Reset</a>
                @endif
            </form>
        </div>

        <div class="card-body table-responsive">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            <table class="table table-bordered align-middle">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Designer</th>
                        <th>Status</th>
                        <th>Price</th>
                        <th>Categories</th>
                        <th>Updated</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($designs as $d)
                        <tr>
                            <td class="fw-semibold">
                                @if ($d->thumbnail)
                                    <img src="{{ asset('storage/' . $d->thumbnail) }}" class="me-2 rounded"
                                        style="width:40px;height:40px;object-fit:cover">
                                @endif
                                {{ $d->title }}
                                @if ($d->is_featured)
                                    <span class="badge bg-warning text-dark ms-1">Featured</span>
                                @endif
                            </td>
                            <td>{{ $d->designer->display_name ?? ($d->designer->user->name ?? '-') }}</td>
                            <td>
                                @php
                                    $cls =
                                        ['draft' => 'secondary', 'published' => 'success', 'archived' => 'dark'][
                                            $d->status
                                        ] ?? 'secondary';
                                @endphp
                                <span class="badge bg-{{ $cls }}">{{ ucfirst($d->status) }}</span>
                            </td>
                            <td>Rp {{ number_format($d->price, 0, ',', '.') }}</td>
                            <td class="small">
                                {{ $d->categories?->pluck('name')->implode(', ') ?: '-' }}
                            </td>
                            <td class="text-muted small">{{ $d->updated_at?->format('d-m-Y H:i') }}</td>
                            <td class="text-end">
                                <a class="btn btn-sm btn-outline-primary"
                                    href="{{ route('admin.designs.show', $d) }}">Details</a>
                                <form method="POST" action="{{ route('admin.designs.destroy', $d) }}" class="d-inline"
                                    onsubmit="return confirm('Delete this design along with its media?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">No data.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-2">{{ $designs->links() }}</div>
        </div>
    </div>
</x-app-layouts>
