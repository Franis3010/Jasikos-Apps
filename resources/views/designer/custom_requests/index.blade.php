<x-app-layouts title="Custom Requests">
    <div class="card">
        <div class="card-header">
            <h4 class="mb-0">Custom Requests</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead>
                        <tr>
                            <th>Code</th>
                            <th>Title</th>
                            <th>Customer</th>
                            <th>Status</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($crs as $c)
                            <tr>
                                <td>{{ $c->code }}</td>
                                <td>{{ $c->title }}</td>
                                <td>{{ $c->customer->user->name ?? 'Customer' }}</td>
                                <td><span class="badge bg-secondary">{{ $c->status }}</span></td>
                                <td>{{ $c->created_at->format('d-m-Y H:i') }}</td>
                                <td class="text-end"><a class="btn btn-sm btn-primary"
                                        href="{{ route('designer.custom-requests.show', $c) }}">Details</a></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">No requests yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-2">{{ $crs->links() }}</div>
        </div>
    </div>
</x-app-layouts>
