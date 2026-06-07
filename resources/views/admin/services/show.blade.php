@extends('layouts/contentNavbarLayout')

@section('content')
<div class="container">

    <h3 class="mb-4 d-flex align-items-center gap-2">
        <i class="bx bx-detail fs-3 text-primary"></i>
        <span>{{ __('services.service_details') }}</span>
    </h3>

    {{-- Basic Information --}}
    <div class="card mb-4 shadow-sm border-0">
        <div class="card-header bg-white border-bottom fw-bold d-flex align-items-center gap-2">
            <i class="bx bx-info-circle text-primary fs-4"></i>
            <span class="text-primary">{{ __('services.basic_info') }}</span>
        </div>

        <div class="card-body">

            <div class="row g-3">

                {{-- Title EN --}}
                <div class="col-md-6">
                    <div class="p-3 rounded border bg-light">
                        <div class="text-muted small">{{ __('services.title_en') }}</div>
                        <div class="fw-semibold">{{ $service->title_en }}</div>
                    </div>
                </div>

                {{-- Title AR --}}
                <div class="col-md-6">
                    <div class="p-3 rounded border bg-light">
                        <div class="text-muted small">{{ __('services.title_ar') }}</div>
                        <div class="fw-semibold">{{ $service->title_ar }}</div>
                    </div>
                </div>

                {{-- Status --}}
                <div class="col-md-4">
                    <div class="p-3 rounded border bg-light">
                        <div class="text-muted small">{{ __('services.status') }}</div>
                        <div>
                            @if($service->status === 'pending')
                                <span class="badge bg-warning">{{ __('services.pending') }}</span>
                            @elseif($service->status === 'approved')
                                <span class="badge bg-success">{{ __('services.approved') }}</span>
                            @else
                                <span class="badge bg-danger">{{ __('services.rejected') }}</span>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Active --}}
                <div class="col-md-4">
                    <div class="p-3 rounded border bg-light">
                        <div class="text-muted small">{{ __('services.active') }}</div>
                        <div>
                            @if($service->is_active)
                                <span class="badge bg-success">{{ __('services.active') }}</span>
                            @else
                                <span class="badge bg-secondary">{{ __('services.inactive') }}</span>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Type --}}
                <div class="col-md-4">
                    <div class="p-3 rounded border bg-light">
                        <div class="text-muted small">{{ __('services.type') }}</div>
                        <div class="fw-semibold">{{ $service->type }}</div>
                    </div>
                </div>

                {{-- Price USD --}}
                <div class="col-md-6">
                    <div class="p-3 rounded border bg-light">
                        <div class="text-muted small">{{ __('services.price_usd') }}</div>
                        <div class="fw-semibold">${{ number_format($service->price_usd, 2) }}</div>
                    </div>
                </div>

                {{-- Price SYP --}}
                <div class="col-md-6">
                    <div class="p-3 rounded border bg-light">
                        <div class="text-muted small">{{ __('services.price_syp') }}</div>
                        <div class="fw-semibold">{{ number_format($service->price_syp, 2) }}</div>
                    </div>
                </div>

                {{-- Description EN --}}
                <div class="col-md-12">
                    <div class="p-3 rounded border bg-light">
                        <div class="text-muted small">{{ __('services.description_en') }}</div>
                        <div>{{ $service->description_en }}</div>
                    </div>
                </div>

                {{-- Description AR --}}
                <div class="col-md-12">
                    <div class="p-3 rounded border bg-light">
                        <div class="text-muted small">{{ __('services.description_ar') }}</div>
                        <div>{{ $service->description_ar }}</div>
                    </div>
                </div>

                {{-- Reject Reason --}}
                @if($service->reject_reason)
                    <div class="col-md-12">
                        <div class="p-3 rounded border bg-light">
                            <div class="text-muted small">{{ __('services.reject_reason') }}</div>
                            <div class="text-danger fw-semibold">{{ $service->reject_reason }}</div>
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div>

    {{-- Category Information --}}
    <div class="card mb-4 shadow-sm border-0">
        <div class="card-header bg-white border-bottom fw-bold d-flex align-items-center gap-2">
            <i class="bx bx-category text-primary fs-4"></i>
            <span class="text-primary">{{ __('services.category_info') }}</span>
        </div>

        <div class="card-body">
            <div class="row g-3">

                {{-- Main Category --}}
                <div class="col-md-6">
                    <div class="p-3 rounded border bg-light">
                        <div class="text-muted small">{{ __('services.category') }}</div>
                        <div class="fw-semibold">
                            {{ $service->category ? $service->category->name_ar : '—' }}
                        </div>
                    </div>
                </div>

                {{-- Subcategory --}}
                <div class="col-md-6">
                    <div class="p-3 rounded border bg-light">
                        <div class="text-muted small">{{ __('services.subcategory') }}</div>
                        <div class="fw-semibold">
                            {{ $service->subcategory ? $service->subcategory->name_ar : '—' }}
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- Images --}}
    <div class="card mb-4 shadow-sm border-0">
        <div class="card-header bg-white border-bottom fw-bold d-flex align-items-center gap-2">
            <i class="bx bx-image text-info fs-4"></i>
            <span class="text-info">{{ __('services.images') }}</span>
        </div>

        <div class="card-body">

            @if($service->media->count() > 0)

                <div id="serviceCarousel" class="carousel slide mb-3" data-bs-ride="carousel">
                    <div class="carousel-inner rounded shadow-sm">

                        @foreach($service->media as $index => $image)
                            <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                <img src="{{ $image->original_url }}" class="d-block w-100" style="max-height:400px; object-fit:cover;">
                            </div>
                        @endforeach

                    </div>

                    <button class="carousel-control-prev" type="button" data-bs-target="#serviceCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                    </button>

                    <button class="carousel-control-next" type="button" data-bs-target="#serviceCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon"></span>
                    </button>
                </div>

            @else
                <p class="text-muted">{{ __('services.no_images') }}</p>
            @endif

        </div>
    </div>

    {{-- Dynamic Fields --}}
    <div class="card mb-4 shadow-sm border-0">
        <div class="card-header bg-white border-bottom fw-bold d-flex align-items-center gap-2">
            <i class="bx bx-list-ul text-secondary fs-4"></i>
            <span class="text-secondary">{{ __('services.dynamic_fields') }}</span>
        </div>

        <div class="card-body">
            @if($service->fieldValues->count() > 0)
                <table class="table table-hover table-striped">
                    <thead class="table-light">
                        <tr>
                            <th>{{ __('services.field') }}</th>
                            <th>{{ __('services.value') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($service->fieldValues as $fv)
                            <tr>
                                <td>{{ $fv->field->name_en }}</td>
                                <td>{{ $fv->value }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-muted">{{ __('services.no_fields') }}</p>
            @endif
        </div>
    </div>

    {{-- Buttons --}}
    <div class="d-flex gap-2">

        @if($service->status === 'pending')

            <form action="{{ route('admin.services.approve', $service->id) }}" method="POST">
                @csrf
                <button class="btn btn-success px-4">
                    <i class="bx bx-check-circle"></i> {{ __('services.approve') }}
                </button>
            </form>

            <button class="btn btn-danger px-4" data-bs-toggle="modal" data-bs-target="#rejectModal">
                <i class="bx bx-x-circle"></i> {{ __('services.reject') }}
            </button>

        @endif

        <a href="{{ route('admin.services.map', $service->id) }}" class="btn btn-info px-4">
            <i class="bx bx-map"></i> View Location on Map
        </a>

        <a href="{{ route('admin.services.index') }}" class="btn btn-secondary px-4">
            <i class="bx bx-arrow-back"></i> {{ __('services.back') }}
        </a>

    </div>

</div>

{{-- Reject Modal --}}
<div class="modal fade" id="rejectModal" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('admin.services.reject', $service->id) }}" method="POST">
            @csrf
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">{{ __('services.reject_reason') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <textarea name="reject_reason" class="form-control" rows="4" required></textarea>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary">{{ __('services.back') }}</button>
                    <button class="btn btn-danger">{{ __('services.reject') }}</button>
                </div>

            </div>
        </form>
    </div>
</div>

@endsection
