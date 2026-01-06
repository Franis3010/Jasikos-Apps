<x-app-layouts title="Design Catalog">
    {{-- Filter bar --}}
    <div class="card border-0 shadow-sm rounded-4 mb-3">
        <div class="card-body p-3 p-md-4">
            <form method="GET" class="row g-2 align-items-center">
                <div class="col-12 col-md-6">
                    <input type="text" name="q" class="form-control" placeholder="Search design title…"
                        value="{{ $q }}">
                </div>
                <div class="col-8 col-md-3">
                    <select name="sort" class="form-select">
                        <option value="newest" {{ $sort === 'newest' ? 'selected' : '' }}>Newest</option>
                        <option value="price_asc" {{ $sort === 'price_asc' ? 'selected' : '' }}>Lowest Price</option>
                        <option value="price_desc" {{ $sort === 'price_desc' ? 'selected' : '' }}>Highest Price
                        </option>
                    </select>
                </div>
                <div class="col-4 col-md-3">
                    <button class="btn btn-dark w-100 rounded-pill">Filter</button>
                </div>
            </form>

            {{-- Rail kategori (chip) --}}
            <div class="mt-3 position-relative">
                <div class="d-flex flex-nowrap gap-2 overflow-auto pb-1">
                    <a href="{{ route('customer.browse-designs', array_filter(['q' => $q, 'sort' => $sort])) }}"
                        class="btn rounded-pill cat-chip {{ $catSlug ? '' : 'active' }}">All</a>
                    @foreach ($categories as $c)
                        <a href="{{ route('customer.browse-designs', array_filter(['q' => $q, 'sort' => $sort, 'category' => $c->slug])) }}"
                            class="btn rounded-pill cat-chip {{ $catSlug === $c->slug ? 'active' : '' }}">
                            {{ $c->name }}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- Grid --}}
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0">Design Catalog</h5>
                @if ($catSlug)
                    <a href="{{ route('customer.browse-designs') }}" class="small text-decoration-none">Reset</a>
                @endif
            </div>

            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                @forelse($designs as $d)
                    @php($designer = $d->designer->display_name ?? ($d->designer->user->name ?? '-'))
                    <div class="col">
                        <div class="tile-wrap h-100">
                            <a href="{{ route('designs.show', $d->slug) }}"
                                class="d-block text-decoration-none text-reset">
                                <div class="tile rounded-4 overflow-hidden ratio ratio-16x9 bg-light position-relative">
                                    @if ($d->thumbnail)
                                        <img src="{{ asset('storage/' . $d->thumbnail) }}" class="w-100 h-100"
                                            style="object-fit:cover" alt="{{ $d->title }}">
                                    @endif
                                </div>
                            </a>
                            <div class="tile-meta">
                                <div class="fw-semibold">{{ $d->title }}</div>
                                <div class="text-muted small">{{ $designer }}</div>
                                <div class="mt-1">Rp {{ number_format($d->price, 0, ',', '.') }}</div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-muted">No results found.</div>
                @endforelse
            </div>

            <div class="d-flex justify-content-center mt-4">
                {{ $designs->withQueryString()->links() }}
            </div>
        </div>
    </div>

    @push('styles')
        <style>
            .cat-chip {
                background: #fff;
                border: 1px solid #e5e7eb;
                color: #111;
                padding: .45rem .85rem;
                font-size: .9rem;
                line-height: 1;
            }

            .cat-chip:hover {
                background: #111;
                color: #fff;
                border-color: #111
            }

            .cat-chip.active {
                background: #111;
                color: #fff;
                border-color: #111
            }

            .tile img {
                transition: transform .45s ease;
            }

            .tile-wrap:hover .tile img {
                transform: scale(1.03);
            }

            .tile-meta {
                max-height: 0;
                opacity: 0;
                overflow: hidden;
                margin-top: 0;
                transition: max-height .25s ease, opacity .25s ease, margin-top .25s ease;
            }

            .tile-wrap:hover .tile-meta {
                max-height: 120px;
                opacity: 1;
                margin-top: .5rem;
            }
        </style>
    @endpush
</x-app-layouts>
