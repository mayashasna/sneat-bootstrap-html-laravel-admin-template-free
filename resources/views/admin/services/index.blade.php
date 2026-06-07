@extends('layouts/contentNavbarLayout')

@section('content')
<div class="container">

    <h1 class="mb-4 d-flex align-items-center gap-2">
        <i class="bx bx-list-ul fs-2 text-primary"></i>
        <span class="fw-bold">{{ __('services.services') }}</span>
    </h1>

    {{-- Alerts --}}
    @if(session('success'))
        <div class="alert alert-success shadow-sm">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger shadow-sm">{{ session('error') }}</div>
    @endif

    <div class="card shadow-sm border-0 rounded-3">

        {{-- Header + Filter Button --}}
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom">
            <h5 class="mb-0 fw-bold text-primary d-flex align-items-center gap-2">
                <i class="bx bx-grid-alt"></i> {{ __('services.service_list') }}
            </h5>

            <!-- Filter Button -->
            <button class="btn btn-outline-primary btn-sm" data-bs-toggle="offcanvas" data-bs-target="#filtersOffcanvas">
                <i class="bx bx-filter-alt"></i> {{ __('services.filter') }}
            </button>
        </div>

        {{-- Offcanvas Filters --}}
        <div class="offcanvas offcanvas-end" tabindex="-1" id="filtersOffcanvas">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title fw-bold">{{ __('services.filter') }}</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"></button>
            </div>

            <div class="offcanvas-body">

                {{-- Filters Form --}}
                <form method="GET" action="{{ route('admin.services.index') }}" class="row g-3">

                    {{-- Search Card --}}
                    <div class="col-12">
                        <div class="card shadow-sm border-0 mb-3">
                            <div class="card-body">
                                <h6 class="fw-bold mb-3 d-flex align-items-center gap-2">
                                    <i class="bx bx-search-alt fs-5 text-primary"></i>
                                    {{ __('services.search') }}
                                </h6>

                                <input type="text" name="search" class="form-control"
                                       placeholder="{{ __('services.search_placeholder') }}"
                                       value="{{ request('search') }}">
                            </div>
                        </div>
                    </div>
{{-- Price Range Card --}}
<div class="col-12">
    <div class="card shadow-sm border-0 mb-3">
        <div class="card-body">
            <h6 class="fw-bold mb-3 d-flex align-items-center gap-2">
                <i class="bx bx-dollar fs-5 text-primary"></i>
                {{ __('services.price_range') }}
            </h6>

            <div class="row g-2">
                <div class="col-6">
                    <label class="form-label small fw-semibold">{{ __('services.min_price') }}</label>
                    <input type="number" name="min_price" class="form-control"
                           placeholder="0"
                           value="{{ request('min_price') }}">
                </div>

                <div class="col-6">
                    <label class="form-label small fw-semibold">{{ __('services.max_price') }}</label>
                    <input type="number" name="max_price" class="form-control"
                           placeholder="100000"
                           value="{{ request('max_price') }}">
                </div>
            </div>

        </div>
    </div>
</div>
{{-- Location Card --}}
<div class="col-12">
    <div class="card shadow-sm border-0 mb-3">
        <div class="card-body">
            <h6 class="fw-bold mb-3 d-flex align-items-center gap-2">
                <i class="bx bx-map fs-5 text-primary"></i>
                {{ __('services.location') }}
            </h6>

            <input type="text" name="location" class="form-control"
                   placeholder="{{ __('services.location_placeholder') }}"
                   value="{{ request('location') }}">
        </div>
    </div>
</div>
{{-- Category Card --}}
<div class="col-12">
    <div class="card shadow-sm border-0 mb-3">
        <div class="card-body">
            <h6 class="fw-bold mb-3 d-flex align-items-center gap-2">
                <i class="bx bx-layer fs-5 text-primary"></i>
                {{ __('services.category') }}
            </h6>

            <select name="category_id" class="form-select">
                <option value="">{{ __('services.all') }}</option>

                @foreach($categories as $category)
                    <option value="{{ $category->id }}"
                        {{ request('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name_ar }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
</div>
{{-- Subcategory Card --}}
<div class="col-12">
    <div class="card shadow-sm border-0 mb-3">
        <div class="card-body">
            <h6 class="fw-bold mb-3 d-flex align-items-center gap-2">
                <i class="bx bx-subdirectory-right fs-5 text-primary"></i>
                {{ __('services.subcategory') }}
            </h6>

            <select name="subcategory_id" id="subcategorySelect" class="form-select">
                <option value="">{{ __('services.all') }}</option>

                @foreach($subcategories as $sub)
                    <option value="{{ $sub->id }}"
                        data-category="{{ $sub->category_id }}"
                        {{ request('subcategory_id') == $sub->id ? 'selected' : '' }}>
                        {{ $sub->name_ar }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
</div>



                    {{-- Status Card --}}
                    <div class="col-12">
                        <div class="card shadow-sm border-0 mb-3">
                            <div class="card-body">
                                <h6 class="fw-bold mb-3 d-flex align-items-center gap-2">
                                    <i class="bx bx-check-shield fs-5 text-primary"></i>
                                    {{ __('services.status') }}
                                </h6>

                                <select name="status" class="form-select">
                                    <option value="">{{ __('services.all') }}</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>
                                        {{ __('services.pending') }}
                                    </option>
                                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>
                                        {{ __('services.approved') }}
                                    </option>
                                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>
                                        {{ __('services.rejected') }}
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>

                    {{-- Service Type Card --}}
                    <div class="col-12">
                        <div class="card shadow-sm border-0 mb-3">
                            <div class="card-body">
                                <h6 class="fw-bold mb-3 d-flex align-items-center gap-2">
                                    <i class="bx bx-category fs-5 text-primary"></i>
                                    {{ __('services.type') }}
                                </h6>

                                <select name="type" class="form-select">
                                    <option value="">{{ __('services.all') }}</option>
                                    <option value="sale" {{ request('type') == 'sale' ? 'selected' : '' }}>
                                        {{ __('services.sale') }}
                                    </option>
                                    <option value="rent" {{ request('type') == 'rent' ? 'selected' : '' }}>
                                        {{ __('services.rent') }}
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>

                    {{-- Buttons --}}
                    <div class="col-12 d-flex gap-2 mt-2">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bx bx-filter-alt"></i> {{ __('services.filter') }}
                        </button>

                        <a href="{{ route('admin.services.index') }}" class="btn btn-secondary w-100">
                            <i class="bx bx-reset"></i> {{ __('services.reset') }}
                        </a>
                    </div>

                </form>

            </div>
        </div>

        {{-- Table --}}
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="text-center">{{ __('services.id') }}</th>
                        <th>Business ID</th>
                        <th>{{ __('services.title_ar') }}</th>
                        <th>{{ __('services.title_en') }}</th>
                        <th>{{ __('services.status') }}</th>
                        <th>{{ __('services.active') }}</th>
                        <th>{{ __('services.prices') }}</th>
                        <th class="text-center" style="width: 240px;">{{ __('services.actions') }}</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($services as $service)
                        @php $status = strtolower($service->status); @endphp

                        <tr class="border-bottom">
                            <td class="text-center fw-bold text-secondary">{{ $service->id }}</td>
                            <td class="text-center text-muted">{{ $service->business_id }}</td>
                            <td class="fw-semibold">{{ $service->title_ar }}</td>
                            <td class="fw-semibold">{{ $service->title_en }}</td>

                            <td>
                                @if($status === 'pending')
                                    <span class="badge bg-warning text-dark px-3 py-2">
                                        <i class="bx bx-time-five"></i> {{ __('services.pending') }}
                                    </span>
                                @elseif($status === 'approved')
                                    <span class="badge bg-success px-3 py-2">
                                        <i class="bx bx-check-circle"></i> {{ __('services.approved') }}
                                    </span>
                                @else
                                    <span class="badge bg-danger px-3 py-2">
                                        <i class="bx bx-x-circle"></i> {{ __('services.rejected') }}
                                    </span>
                                @endif
                            </td>

                            <td>
                                @if($service->is_active)
                                    <span class="badge bg-success px-3 py-2">
                                        <i class="bx bx-bulb"></i> {{ __('services.active') }}
                                    </span>
                                @else
                                    <span class="badge bg-secondary px-3 py-2">
                                        <i class="bx bx-power-off"></i> {{ __('services.inactive') }}
                                    </span>
                                @endif
                            </td>

                            <td class="small">
                                <div><strong>{{ __('services.usd') }}:</strong> {{ number_format($service->price_usd, 2) }}</div>
                                <div><strong>{{ __('services.syp') }}:</strong> {{ number_format($service->price_syp, 2) }}</div>
                            </td>

                            <td class="text-center">
                                <a href="{{ route('admin.services.show', $service->id) }}"
                                   class="btn btn-sm btn-info me-1 shadow-sm">
                                    <i class="bx bx-show"></i> {{ __('services.show') }}
                                </a>

                                <form action="{{ $service->is_active
                                                ? route('admin.services.deactivate', $service->id)
                                                : route('admin.services.activate', $service->id) }}"
                                      method="POST"
                                      class="d-inline">
                                    @csrf
                                    <button type="submit"
                                            class="btn btn-sm shadow-sm {{ $service->is_active ? 'btn-warning' : 'btn-primary' }}">
                                        <i class="bx {{ $service->is_active ? 'bx-power-off' : 'bx-check-circle' }}"></i>
                                        {{ $service->is_active ? __('services.deactivate') : __('services.activate') }}
                                    </button>
                                </form>

                            </td>
                        </tr>

                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="card-footer bg-white py-3 d-flex justify-content-between align-items-center">
            <div class="text-muted small">
                {{ __('services.showing') }}
                <span class="fw-semibold">{{ $services->firstItem() }}</span>
                {{ __('services.to') }}
                <span class="fw-semibold">{{ $services->lastItem() }}</span>
                {{ __('services.of') }}
                <span class="fw-semibold">{{ $services->total() }}</span>
                {{ __('services.results') }}
            </div>

            <nav>
                <ul class="pagination pagination-sm mb-0">
                    @if ($services->onFirstPage())
                        <li class="page-item disabled">
                            <span class="page-link rounded-pill px-3">
                                <i class="bx bx-chevron-left"></i>
                            </span>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link rounded-pill px-3" href="{{ $services->previousPageUrl() }}">
                                <i class="bx bx-chevron-left"></i>
                            </a>
                        </li>
                    @endif

                    @foreach ($services->getUrlRange(1, $services->lastPage()) as $page => $url)
                        <li class="page-item {{ $page == $services->currentPage() ? 'active' : '' }}">
                            <a class="page-link rounded-pill px-3" href="{{ $url }}">
                                {{ $page }}
                            </a>
                        </li>
                    @endforeach

                    @if ($services->hasMorePages())
                        <li class="page-item">
                            <a class="page-link rounded-pill px-3" href="{{ $services->nextPageUrl() }}">
                                <i class="bx bx-chevron-right"></i>
                            </a>
                        </li>
                    @else
                        <li class="page-item disabled">
                            <span class="page-link rounded-pill px-3">
                                <i class="bx bx-chevron-right"></i>
                            </span>
                        </li>
                    @endif
                </ul>
            </nav>

        </div>

    </div>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const categorySelect = document.querySelector('select[name="category_id"]');
    const subcategorySelect = document.getElementById('subcategorySelect');

    function filterSubcategories() {
        const selectedCategory = categorySelect.value;

        for (let option of subcategorySelect.options) {
            if (!option.value) continue;

            const cat = option.getAttribute('data-category');

            option.style.display = (selectedCategory === "" || selectedCategory === cat)
                ? "block"
                : "none";
        }
    }

    categorySelect.addEventListener('change', filterSubcategories);

    filterSubcategories();
});
</script>

</div>
@endsection
