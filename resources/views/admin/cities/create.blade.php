@extends('layouts/contentNavbarLayout')

@section('title', __('admin.cities.create'))

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

    /* ===== Input Wrapper ===== */
    .input-wrapper {
        position: relative;
    }

    /* ===== Icon Positioning (Perfect Center) ===== */
    .input-wrapper .input-icon {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        font-size: 18px;
        color: #696cff;
        opacity: .8;
        pointer-events: none;
    }

    /* RTL / LTR Auto Alignment */
    html[dir="rtl"] .input-wrapper .input-icon { right: 14px; }
    html[dir="ltr"] .input-wrapper .input-icon { left: 14px; }

    /* ===== Input Styling ===== */
    .input-with-icon {
        border-radius: 10px;
        padding: 10px 14px;
        transition: .3s ease;
    }

    /* Add space for icon */
    html[dir="rtl"] .input-with-icon { padding-right: 42px !important; }
    html[dir="ltr"] .input-with-icon { padding-left: 42px !important; }

    .input-with-icon:focus {
        box-shadow: 0 0 0 3px rgba(105,108,255,0.25);
        border-color: #696cff;
    }

    /* ===== Buttons ===== */
    .btn-premium {
        padding: 10px 18px;
        font-weight: 600;
        border-radius: 10px;
        transition: .3s ease;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .btn-premium:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 20px rgba(0,0,0,0.15);
    }
</style>

<div class="card premium-card">

    <div class="card-header d-flex justify-content-between align-items-center">
        <h4><i class="bx bx-map-alt"></i> {{ __('admin.cities.create') }}</h4>

        <a href="{{ route('admin.cities.index') }}" class="btn btn-secondary btn-premium">
            <i class="bx bx-arrow-back"></i> {{ __('admin.cities.back') }}
        </a>
    </div>

    <div class="card-body">

        <form action="{{ route('admin.cities.store') }}" method="POST">
            @csrf

            {{-- Name Arabic --}}
            <div class="mb-3 input-wrapper">
                <label class="form-label fw-bold">{{ __('admin.cities.name_ar') }}</label>
                <i class="bx bx-edit input-icon"></i>
                <input type="text"
                       name="name_ar"
                       class="form-control input-with-icon"
                       value="{{ old('name_ar') }}"
                       required>
            </div>

            {{-- Name English --}}
            <div class="mb-3 input-wrapper">
                <label class="form-label fw-bold">{{ __('admin.cities.name_en') }}</label>
                <i class="bx bx-edit-alt input-icon"></i>
                <input type="text"
                       name="name_en"
                       class="form-control input-with-icon"
                       value="{{ old('name_en') }}">
            </div>

            {{-- Status --}}
            <div class="mb-3 input-wrapper">
                <label class="form-label fw-bold">{{ __('admin.cities.status') }}</label>
                <i class="bx bx-toggle-left input-icon"></i>
                <select name="is_active" class="form-select input-with-icon">
                    <option value="1">{{ __('admin.cities.active') }}</option>
                    <option value="0">{{ __('admin.cities.inactive') }}</option>
                </select>
            </div>

            {{-- Submit --}}
            <button type="submit" class="btn btn-primary btn-premium mt-3">
                <i class="bx bx-save"></i> {{ __('admin.cities.save') }}
            </button>

        </form>

    </div>
</div>

@endsection
