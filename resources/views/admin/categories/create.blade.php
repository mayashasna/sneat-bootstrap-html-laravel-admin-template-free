@extends('layouts/contentNavbarLayout')

@section('content')
<style>
  :root {
    --brand-1: #696cff;
    --brand-2: #8a8dff;
    --brand-soft: rgba(105, 108, 255, 0.1);
    --text-muted: #7a7f9a;
  }

  .page-shell {
    max-width: 1080px;
    margin-inline: auto;
  }

  .premium-card {
    border: 1px solid rgba(105, 108, 255, 0.08);
    border-radius: 18px;
    box-shadow: 0 14px 34px rgba(16, 24, 40, 0.08);
    overflow: hidden;
    transition: 0.25s ease;
    background: #fff;
  }

  .premium-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 16px 40px rgba(16, 24, 40, 0.12);
  }

  .premium-card .card-header {
    background: linear-gradient(100deg, var(--brand-1), var(--brand-2));
    color: #fff;
    font-weight: 700;
    font-size: 1.05rem;
    letter-spacing: .2px;
    padding: 1rem 1.25rem;
    display: flex;
    align-items: center;
    gap: 8px;
  }

  .section-label {
    margin: 0 0 14px;
    color: #222;
    font-weight: 700;
    font-size: .95rem;
  }

  .required-dot {
    color: #ff4d6d;
    margin-inline-start: 2px;
  }

  .input-wrapper {
    position: relative;
  }

  .input-wrapper i.input-icon {
    position: absolute;
    top: 52%;
    transform: translateY(-50%);
    font-size: 18px;
    color: var(--brand-1);
    opacity: 0.9;
    pointer-events: none;
  }

  html[dir='rtl'] .input-wrapper i.input-icon { right: 12px; }
  html[dir='ltr'] .input-wrapper i.input-icon { left: 12px; }

  html[dir='rtl'] .input-with-icon { padding-right: 40px !important; }
  html[dir='ltr'] .input-with-icon { padding-left: 40px !important; }

  .input-with-icon,
  .form-control {
    border-radius: 12px;
    min-height: 44px;
    border-color: #e6e8f0;
    transition: 0.2s ease;
  }

  .input-with-icon:focus,
  .form-control:focus {
    box-shadow: 0 0 0 3px var(--brand-soft);
    border-color: var(--brand-1);
  }

  .hint {
    color: var(--text-muted);
    font-size: 0.81rem;
  }

  .btn-premium {
    padding: 10px 18px;
    font-weight: 600;
    border-radius: 12px;
    transition: .25s ease;
    display: inline-flex;
    align-items: center;
    gap: 6px;
  }

  .btn-premium:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(16, 24, 40, 0.15);
  }

  .btn-gradient {
    background: linear-gradient(100deg, var(--brand-1), var(--brand-2));
    color: #fff;
    border: none;
  }

  .form-actions {
    border-top: 1px dashed #e6e8f0;
    padding-top: 1rem;
    margin-top: 1.25rem;
  }
</style>

<div class="container page-shell py-2">
  <h4 class="page-title mb-1 d-flex align-items-center gap-2">
    <i class="bx bx-category-alt"></i>
    {{ __('categories.create_title') }}
  </h4>
  <p class="text-muted mb-4">{{ __('categories.create_subtitle') }}</p>

  <div class="card premium-card">
    <div class="card-header">
      <i class="bx bx-edit-alt"></i>
      {{ __('categories.create_info') }}
    </div>

    <div class="card-body p-4">
      <form action="{{ route('admin.categories.store') }}" method="POST">
        @csrf

        <p class="section-label">{{ __('categories.create_info') }}</p>

        <div class="row g-3">

          {{-- English Name --}}
          <div class="col-md-6 input-wrapper">
            <label class="form-label fw-semibold">
              {{ __('categories.name_en') }}<span class="required-dot">*</span>
            </label>
            <i class="bx bx-globe input-icon"></i>
            <input type="text" name="name_en"
                   class="form-control input-with-icon @error('name_en') is-invalid @enderror"
                   value="{{ old('name_en') }}"
                   placeholder="{{ __('categories.name_en_placeholder') }}"
                   required>
            @error('name_en') <small class="text-danger">{{ $message }}</small> @enderror
          </div>

          {{-- Arabic Name --}}
          <div class="col-md-6 input-wrapper">
            <label class="form-label fw-semibold">
              {{ __('categories.name_ar') }}<span class="required-dot">*</span>
            </label>
            <i class="bx bx-globe-alt input-icon"></i>
            <input type="text" name="name_ar"
                   class="form-control input-with-icon @error('name_ar') is-invalid @enderror"
                   value="{{ old('name_ar') }}"
                   placeholder="{{ __('categories.name_ar_placeholder') }}"
                   required>
            @error('name_ar') <small class="text-danger">{{ $message }}</small> @enderror
          </div>

          {{-- Status --}}
          <div class="col-md-6">
            <label class="form-label fw-semibold">{{ __('categories.status') }}</label>

            {{-- الحل النهائي لمشكلة الحالة --}}
            <input type="hidden" name="is_active" value="0">

            <div class="form-check form-switch mt-1">
              <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1"
                     {{ old('is_active', 1) ? 'checked' : '' }}>
              <label class="form-check-label" for="is_active">{{ __('categories.active_label') }}</label>
            </div>

            <small class="hint">{{ __('categories.status_hint') }}</small>
          </div>

        </div>

        <div class="d-flex justify-content-between align-items-center form-actions">
          <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary btn-premium">
            <i class="bx bx-arrow-back"></i>
            {{ __('categories.back_button') }}
          </a>
          <button type="submit" class="btn btn-gradient btn-premium">
            <i class="bx bx-save"></i>
            {{ __('categories.save_button') }}
          </button>
        </div>

      </form>
    </div>
  </div>
</div>
@endsection
