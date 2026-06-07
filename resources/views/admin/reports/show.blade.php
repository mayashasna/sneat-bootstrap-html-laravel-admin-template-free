@extends('layouts/contentNavbarLayout')

@section('title', __('admin.reports.title'))

@section('content')

<h4 class="fw-bold py-3 mb-4">
    {{ __('admin.reports.title') }} #{{ $report->id }}
</h4>

<div class="row">

    {{-- SERVICE DETAILS --}}
    <div class="col-md-6">
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-light fw-bold">
                {{ __('admin.reports.service') }}
            </div>
            <div class="card-body">
                <p><strong>{{ __('admin.reports.service_title') }}:</strong> {{ $report->service->title_en }}</p>
                <p><strong>{{ __('admin.reports.service_description') }}:</strong> {{ $report->service->description_en }}</p>
                <p><strong>{{ __('admin.reports.location') }}:</strong> {{ $report->service->location_text }}</p>
                <p><strong>{{ __('admin.reports.type') }}:</strong> {{ $report->service->type }}</p>
                <p><strong>{{ __('admin.reports.price') }}:</strong> {{ $report->service->price_usd }} USD</p>
            </div>
        </div>
    </div>

    {{-- REPORT DETAILS --}}
    <div class="col-md-6">
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-light fw-bold">
                {{ __('admin.reports.reason') }}
            </div>
            <div class="card-body">
                <p>{{ $report->reason }}</p>

                <p>
                    <strong>{{ __('admin.reports.status') }}:</strong>
                    <span class="badge bg-{{ $report->status_color }}">
                        {{ __('admin.reports.' . ($report->status ?? 'pending')) }}
                    </span>
                </p>

                @if($report->status === 'pending' || $report->status === null)
                    <form action="{{ route('admin.reports.action', $report->id) }}"
                          method="POST" class="d-flex gap-2 mt-3">
                        @csrf

                        <select name="status" class="form-select form-select-sm" style="width: 150px;">
                            <option value="accepted">{{ __('admin.reports.accepted') }}</option>
                            <option value="rejected">{{ __('admin.reports.rejected') }}</option>
                            <option value="ignored">{{ __('admin.reports.ignored') }}</option>
                        </select>

                        <button type="submit" class="btn btn-sm btn-primary">
                            <i class="ti ti-check"></i> {{ __('admin.reports.update') }}
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>

    {{-- BUSINESS OWNER --}}
    <div class="col-md-12">
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-light fw-bold">
                {{ __('admin.reports.business_owner') }}
            </div>
            <div class="card-body">
                <p><strong>{{ __('admin.reports.business_name') }}:</strong> {{ $report->service->business->user->name }}</p>
                <p><strong>{{ __('admin.reports.business_id') }}:</strong> {{ $report->service->business->id }}</p>
                <p><strong>{{ __('admin.reports.business_status') }}:</strong> {{ $report->service->business->status }}</p>
            </div>
        </div>
    </div>

    {{-- USER WHO REPORTED --}}
    <div class="col-md-12">
        <div class="card shadow-sm">
            <div class="card-header bg-light fw-bold">
                {{ __('admin.reports.user') }}
            </div>
            <div class="card-body">
                <p><strong>{{ __('admin.reports.user_name') }}:</strong> {{ $report->user->name }}</p>
                <p><strong>{{ __('admin.reports.user_id') }}:</strong> {{ $report->user->id }}</p>
                <p><strong>{{ __('admin.reports.user_status') }}:</strong> {{ $report->user->status }}</p>
            </div>
        </div>
    </div>

</div>

@endsection
