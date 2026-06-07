@extends('layouts/contentNavbarLayout')

@section('content')

<style>
    /* ===== Premium Card ===== */
    .premium-card {
        border-radius: 18px;
        overflow: hidden;
        border: none;
        box-shadow: 0 8px 25px rgba(0,0,0,0.12);
        transition: .3s ease;
    }
    .premium-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 35px rgba(0,0,0,0.18);
    }

    .section-title {
        font-weight: 700;
        font-size: 20px;
        margin-bottom: 15px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .section-title i {
        font-size: 22px;
        color: #696cff;
    }

    .info-row {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 8px;
        font-size: 15px;
    }
    .info-row i {
        color: #696cff;
        font-size: 18px;
    }
</style>

<div class="container">

    <h1 class="mb-4"><i class="bx bx-buildings"></i> {{ __('business.show_title') }}</h1>

    {{-- ✅ زر الرجوع الذكي --}}
    @php
        $from = request()->get('from', 'index');
        $routes = [
            'index' => route('admin.business-accounts.index'),
            'rejected' => route('admin.business-accounts.rejected'),
            'deleted' => route('admin.business-accounts.deleted'),
        ];
    @endphp

    <a href="{{ $routes[$from] }}" class="btn btn-secondary mb-3">
        <i class="bx bx-arrow-back"></i> {{ __('business.back') }}
    </a>

    <div class="card premium-card mb-4">
        <div class="card-header">
            <h5 class="section-title"><i class="bx bx-info-circle"></i> {{ __('business.show_info') }}</h5>
        </div>

        <div class="card-body">

            @php
                $statusClass = [
                    'Pending' => 'badge bg-warning',
                    'Approved' => 'badge bg-success',
                    'Rejected' => 'badge bg-danger',
                ][$account->status];
            @endphp

            <div class="info-row">
                <i class="bx bx-check-shield"></i>
                <strong>{{ __('business.status') }}:</strong>
                <span class="{{ $statusClass }}">{{ __('business.status_' . strtolower($account->status)) }}</span>
            </div>

            @if($account->status === 'Rejected' && $account->rejection_reason)
                <div class="alert alert-danger mt-3">
                    <strong>{{ __('business.rejection_reason') }}:</strong> {{ $account->rejection_reason }}
                </div>
            @endif

            <hr>

            <div class="info-row"><i class="bx bx-user"></i> <strong>{{ __('business.name_ar') }}:</strong> {{ $account->name_ar }}</div>
            <div class="info-row"><i class="bx bx-user"></i> <strong>{{ __('business.name_en') }}:</strong> {{ $account->name_en }}</div>

            <div class="info-row">
                <i class="bx bx-map"></i>
                <strong>{{ __('business.city') }}:</strong>
                {{ app()->getLocale() === 'ar' ? $account->city->name_ar : $account->city->name_en }}
            </div>

            <div class="info-row">
                <i class="bx bx-briefcase"></i>
                <strong>{{ __('business.activity_type') }}:</strong>
                {{ app()->getLocale() === 'ar' ? $account->activityType->name_ar : $account->activityType->name_en }}
            </div>

            <div class="info-row"><i class="bx bx-detail"></i> <strong>{{ __('business.details') }}:</strong> {{ $account->details }}</div>

            <div class="info-row"><i class="bx bx-current-location"></i> <strong>{{ __('business.latitude') }}:</strong> {{ $account->latitude }}</div>
            <div class="info-row"><i class="bx bx-current-location"></i> <strong>{{ __('business.longitude') }}:</strong> {{ $account->longitude }}</div>

            <hr>

            <h5 class="section-title"><i class="bx bx-image"></i> {{ __('business.show_documents') }}</h5>

            @if($account->documents)
                <div class="row g-4">
                    @foreach($account->documents as $doc)
                        <div class="col-md-4">
                            <div class="premium-image-card">
                                <img src="{{ $doc['url'] }}" class="premium-img" alt="Document">
                                <div class="premium-overlay">
                                    <a href="{{ $doc['url'] }}" target="_blank" class="btn btn-light btn-sm shadow-sm">
                                        <i class="bx bx-show"></i> {{ __('business.btn_show') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-muted">{{ __('business.no_documents') }}</p>
            @endif

            <hr>

            @if($account->status === 'Pending')
                <div class="mt-4 d-flex gap-2">
                    <form action="{{ route('admin.business-accounts.approve') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" value="{{ $account->id }}">
                        <button class="btn btn-success"><i class="bx bx-check"></i> {{ __('business.btn_approve') }}</button>
                    </form>

                    <button class="btn btn-danger" onclick="openRejectModal({{ $account->id }})">
                        <i class="bx bx-x"></i> {{ __('business.btn_reject') }}
                    </button>
                </div>
            @endif

            <a href="{{ route('admin.business-accounts.map', $account->id) }}"
               class="btn btn-primary mt-3">
                <i class="bx bx-map-alt"></i> {{ __('business.view_location') }}
            </a>

        </div>
    </div>

</div>

{{-- Reject Modal --}}
<div class="modal fade" id="rejectModal" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('admin.business-accounts.reject') }}" method="POST" class="modal-content">
            @csrf
            <input type="hidden" name="id" id="rejectAccountId">

            <div class="modal-header">
                <h5 class="modal-title"><i class="bx bx-x-circle"></i> {{ __('business.btn_reject') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <label class="form-label">{{ __('business.rejection_reason') }}</label>
                <textarea name="reason" class="form-control"></textarea>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('business.back') }}</button>
                <button type="submit" class="btn btn-danger"><i class="bx bx-x"></i> {{ __('business.btn_reject') }}</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openRejectModal(id) {
        document.getElementById('rejectAccountId').value = id;
        new bootstrap.Modal(document.getElementById('rejectModal')).show();
    }
</script>

@endsection
