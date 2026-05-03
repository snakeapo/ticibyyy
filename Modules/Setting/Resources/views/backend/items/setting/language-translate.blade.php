@extends('setting::backend.layout.default')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-head d-flex align-items-center">
                <div class="flex-grow-1">
                    <h4 class="page-main-title m-0">{{ $language->language_name }} ({{ strtoupper($language->language_code) }}) - Çeviri Yönetimi</h4>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-lg-4 col-md-5 col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="header-title">Yeni Satır Ekle</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('language_setting_translation_create', $language->id) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">{{ __('Translation key') }}</label>
                            <input type="text" class="form-control" name="new_key" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ __('Translation value') }}</label>
                            <textarea class="form-control" name="new_value" rows="3"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">{{ __('Save') }}</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-8 col-md-7 col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="header-title mb-0">Çeviri Satırları</h4>
                    <form method="GET" action="{{ route('language_setting_translate', $language->id) }}" class="d-flex" style="gap:8px;">
                        <input type="text" name="search" value="{{ $search }}" class="form-control" placeholder="{{ __('Search translation') }}">
                        <button class="btn btn-outline-primary" type="submit">Ara</button>
                    </form>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped align-middle">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ __('Translation key') }}</th>
                                <th>{{ __('Translation value') }}</th>
                                <th>{{ __('Actions') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($translations as $index => $value)
                                <tr>
                                    <td>{{ $translations->firstItem() + $loop->index }}</td>
                                    <td style="min-width: 220px;"><code>{{ $index }}</code></td>
                                    <td>
                                        <form action="{{ route('language_setting_translation_update', $language->id) }}" method="POST" class="d-flex" style="gap:8px;">
                                            @csrf
                                            <input type="hidden" name="key" value="{{ $index }}">
                                            <input type="text" class="form-control" name="value" value="{{ $value }}">
                                    </td>
                                    <td>
                                            <button class="btn btn-sm btn-primary" type="submit">{{ __('Save') }}</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">Kayıt bulunamadı.</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">
                        {{ $translations->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
