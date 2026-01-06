<x-app-layouts title="Profil Designer">
    <div class="card mb-3">
        <div class="card-body">
            <h3 class="mb-1">{{ $designer->display_name ?? $designer->user->name }}</h3>
            <div class="text-muted mb-2">Designer Jasikos</div>
            <div>{!! nl2br(e($designer->bio)) !!}</div>
            <div class="text-muted mb-2">
                Rating: <strong>{{ number_format($designer->ratings_avg_stars ?? 0, 1) }}/5</strong>
                ({{ $designer->ratings_count }} ulasan)
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h4 class="mb-0">Desain oleh {{ $designer->display_name ?? $designer->user->name }}</h4>
        </div>
        <div class="card-body">
            <div class="row g-3">
                @forelse($designer->designs as $d)
                    <div class="col-md-3 col-6">
                        <div class="border rounded h-100 p-2">
                            <a href="{{ route('designs.show', $d->slug) }}" class="text-decoration-none">
                                @if ($d->thumbnail)
                                    <img src="{{ asset('storage/' . $d->thumbnail) }}" class="img-fluid rounded mb-2">
                                @endif
                                <div class="fw-semibold text-dark">{{ $d->title }}</div>
                            </a>
                            <div class="mt-1">Rp {{ number_format($d->price, 0, ',', '.') }}</div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <p class="text-muted">Belum ada desain dipublikasi.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layouts>
