{{-- resources/views/admin/settings/content.blade.php --}}
<x-app-layouts title="Site Content">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Site Content</h4>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary btn-sm">Back</a>
        </div>

        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            {{-- Language notice --}}
            <div class="alert alert-info d-flex align-items-center gap-2">
                <i class="fas fa-language"></i>
                <div>
                    <strong>Language policy:</strong> Please enter all content in <u>English</u>. This text appears on
                    the public site.
                </div>
            </div>

            <form method="POST" action="{{ route('admin.settings.content.update') }}">
                @csrf
                @method('PUT')

                {{-- Home – About Blurb --}}
                <h5 class="mb-2">Home – About Blurb</h5>
                <div class="mb-3">
                    <textarea name="home_about_blurb" class="form-control" rows="3">{{ old('home_about_blurb', $home_about_blurb) }}</textarea>
                    <small class="text-muted">Short copy shown to the right of the hero. <em>Write in
                            English.</em></small>
                </div>

                <hr>

                {{-- About Page – Hero --}}
                <h5 class="mb-2">About Page – Hero</h5>
                <div class="mb-3">
                    <label class="form-label">Title (EN)</label>
                    <input type="text" name="about_hero_title" class="form-control"
                        value="{{ old('about_hero_title', $about_hero_title) }}" placeholder="e.g., About Jasikos">
                </div>
                <div class="mb-3">
                    <label class="form-label">Subtitle (EN)</label>
                    <input type="text" name="about_hero_sub" class="form-control"
                        value="{{ old('about_hero_sub', $about_hero_sub) }}" placeholder="One-line mission statement">
                </div>

                {{-- About Page – Free Content (HTML) --}}
                <h5 class="mb-2">About Page – Free Content (HTML)</h5>
                <div class="mb-3">
                    <textarea name="about_body_html" class="form-control" rows="8">{{ old('about_body_html', $about_body_html) }}</textarea>
                    <small class="text-muted">HTML allowed. <em>Write in English.</em></small>
                </div>

                {{-- About Page – Services --}}
                <h5 class="mb-2">About Page – Services</h5>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <input name="about_service_1_t" class="form-control mb-2"
                            value="{{ old('about_service_1_t', $about_service_1_t) }}"
                            placeholder="Service title #1 (EN)">
                        <textarea name="about_service_1_d" class="form-control" rows="3" placeholder="Service description #1 (EN)">{{ old('about_service_1_d', $about_service_1_d) }}</textarea>
                    </div>
                    <div class="col-md-4 mb-3">
                        <input name="about_service_2_t" class="form-control mb-2"
                            value="{{ old('about_service_2_t', $about_service_2_t) }}"
                            placeholder="Service title #2 (EN)">
                        <textarea name="about_service_2_d" class="form-control" rows="3" placeholder="Service description #2 (EN)">{{ old('about_service_2_d', $about_service_2_d) }}</textarea>
                    </div>
                    <div class="col-md-4 mb-3">
                        <input name="about_service_3_t" class="form-control mb-2"
                            value="{{ old('about_service_3_t', $about_service_3_t) }}"
                            placeholder="Service title #3 (EN)">
                        <textarea name="about_service_3_d" class="form-control" rows="3" placeholder="Service description #3 (EN)">{{ old('about_service_3_d', $about_service_3_d) }}</textarea>
                    </div>
                </div>

                {{-- About Page – Stats --}}
                <h5 class="mb-2">About Page – Stats</h5>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <input name="about_stat_1_n" class="form-control mb-2"
                            value="{{ old('about_stat_1_n', $about_stat_1_n) }}" placeholder="Number #1 (e.g., 150+)">
                        <input name="about_stat_1_l" class="form-control"
                            value="{{ old('about_stat_1_l', $about_stat_1_l) }}" placeholder="Label #1 (EN)">
                    </div>
                    <div class="col-md-6 mb-3">
                        <input name="about_stat_2_n" class="form-control mb-2"
                            value="{{ old('about_stat_2_n', $about_stat_2_n) }}" placeholder="Number #2 (e.g., 4.9/5)">
                        <input name="about_stat_2_l" class="form-control"
                            value="{{ old('about_stat_2_l', $about_stat_2_l) }}" placeholder="Label #2 (EN)">
                    </div>
                </div>

                {{-- About Page – WhatsApp --}}
                <h5 class="mb-2">About Page – WhatsApp</h5>
                <div class="mb-4">
                    <input name="about_whatsapp" class="form-control"
                        value="{{ old('about_whatsapp', $about_whatsapp) }}" placeholder="e.g., 628xxxxxxxxxxx">
                    <small class="text-muted">International format (no plus sign).</small>
                </div>

                <button class="btn btn-primary">Save</button>
            </form>
        </div>
    </div>
</x-app-layouts>
