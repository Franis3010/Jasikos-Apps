<x-app-layouts title="Users">
    <div class="card">
        <div class="card-header">
            <form id="filterForm" method="GET" class="d-flex flex-wrap align-items-center gap-2">
                {{-- Search (wide) --}}
                <div class="flex-grow-1 min-w-0">
                    <input type="text" name="q" value="{{ $q }}" class="form-control"
                        placeholder="Search name/email" aria-label="Search name or email">
                </div>

                {{-- Role (inline, fixed width) --}}
                <select name="role" class="form-select" style="min-width: 160px" onchange="this.form.submit()"
                    aria-label="Filter role">
                    <option value="">All Roles</option>
                    @foreach (['admin', 'designer', 'customer'] as $r)
                        <option value="{{ $r }}" @selected($role === $r)>{{ ucfirst($r) }}</option>
                    @endforeach
                </select>

                {{-- Search button --}}
                <button class="btn btn-primary" type="submit" title="Search">Search</button>

                {{-- Reset button (shown if any filter is applied) --}}
                @if ($q || $role)
                    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary"
                        title="Reset filters">Reset</a>
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
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Phone</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $u)
                        <tr>
                            <td>{{ $u->name }}</td>
                            <td>{{ $u->email }}</td>
                            <td><span class="badge bg-secondary">{{ $u->role }}</span></td>
                            <td>{{ $u->phone ?? '-' }}</td>
                            <td class="text-end">
                                <a href="{{ route('admin.users.edit', $u) }}"
                                    class="btn btn-sm btn-outline-primary">Edit</a>
                                @if (auth()->id() !== $u->id)
                                    <form method="POST" action="{{ route('admin.users.destroy', $u) }}"
                                        class="d-inline" onsubmit="return confirm('Delete this user?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger">Delete</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">Empty.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="mt-2">{{ $users->links() }}</div>
        </div>
    </div>
</x-app-layouts>
