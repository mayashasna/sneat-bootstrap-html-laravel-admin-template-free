@extends('layouts/contentNavbarLayout')

@section('content')

<style>
    /* ===== Fix Image Display ===== */
    .premium-image-card {
        position: relative;
        overflow: hidden;
        border-radius: 14px;
        background: #fff;
        height: 220px; /* ارتفاع ثابت */
        box-shadow: 0 6px 20px rgba(0,0,0,0.12);
        transition: all .3s ease;
    }

    .premium-img {
        width: 100%;
        height: 100%;
        object-fit: cover; /* أهم سطر */
        border-radius: 14px;
        transition: .3s ease;
    }

    .premium-image-card:hover .premium-img {
        transform: scale(1.05);
        filter: brightness(0.85);
    }

    .premium-overlay {
        position: absolute;
        bottom: 12px;
        right: 12px;
        opacity: 0;
        transition: .3s ease;
    }

    .premium-image-card:hover .premium-overlay {
        opacity: 1;
        transform: translateY(-4px);
    }
</style>

<div class="container">

    <h1 class="mb-4"><i class="bx bx-edit"></i> {{ __('business.edit_title') }}</h1>

    <div class="card premium-card">
        <div class="card-header">
            <h5 class="section-title"><i class="bx bx-cog"></i> {{ __('business.edit_info') }}</h5>
        </div>

        <div class="card-body">

            <form action="{{ route('admin.business-accounts.update', $account->id) }}"
                  method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- Name Arabic --}}
                <div class="mb-3 position-relative">
                    <label class="form-label">{{ __('business.name_ar') }}</label>
                    <i class="bx bx-user input-icon"></i>
                    <input type="text" name="name_ar" class="form-control input-with-icon"
                           value="{{ old('name_ar', $account->name_ar) }}" required>
                </div>

                {{-- Name English --}}
                <div class="mb-3 position-relative">
                    <label class="form-label">{{ __('business.name_en') }}</label>
                    <i class="bx bx-user input-icon"></i>
                    <input type="text" name="name_en" class="form-control input-with-icon"
                           value="{{ old('name_en', $account->name_en) }}" required>
                </div>

                {{-- Activity Type --}}
                <div class="mb-3 position-relative">
                    <label class="form-label">{{ __('business.activity_type') }}</label>
                    <i class="bx bx-briefcase input-icon"></i>
                    <select name="activity_type_id" class="form-control input-with-icon" required>
                        @foreach($activityTypes as $type)
                            <option value="{{ $type->id }}"
                                {{ $account->activity_type_id == $type->id ? 'selected' : '' }}>
                                {{ app()->getLocale() === 'ar' ? $type->name_ar : $type->name_en }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- City --}}
                <div class="mb-3 position-relative">
                    <label class="form-label">{{ __('business.city') }}</label>
                    <i class="bx bx-map input-icon"></i>
                    <select name="city_id" class="form-control input-with-icon" required>
                        @foreach($cities as $city)
                            <option value="{{ $city->id }}"
                                {{ $account->city_id == $city->id ? 'selected' : '' }}>
                                {{ app()->getLocale() === 'ar' ? $city->name_ar : $city->name_en }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Details --}}
                <div class="mb-3 position-relative">
                    <label class="form-label">{{ __('business.details') }}</label>
                    <i class="bx bx-detail input-icon"></i>
                    <textarea name="details" class="form-control input-with-icon" rows="4">{{ old('details', $account->details) }}</textarea>
                </div>

                {{-- Location --}}
                <div class="row">
                    <div class="col-md-6 mb-3 position-relative">
                        <label class="form-label">{{ __('business.latitude') }}</label>
                        <i class="bx bx-current-location input-icon"></i>
                        <input type="text" name="latitude" class="form-control input-with-icon"
                               value="{{ old('latitude', $account->latitude) }}">
                    </div>

                    <div class="col-md-6 mb-3 position-relative">
                        <label class="form-label">{{ __('business.longitude') }}</label>
                        <i class="bx bx-current-location input-icon"></i>
                        <input type="text" name="longitude" class="form-control input-with-icon"
                               value="{{ old('longitude', $account->longitude) }}">
                    </div>
                </div>

                {{-- Upload Documents --}}
                <div class="mb-3 position-relative">
                    <label class="form-label">{{ __('business.upload_documents') }}</label>
                    <i class="bx bx-upload input-icon"></i>
                    <input type="file" name="documents[]" class="form-control input-with-icon" multiple>
                </div>

                {{-- Existing Documents --}}
                @if($account->documents && count($account->documents))
                    <div class="mb-3">
                        <label class="form-label">{{ __('business.existing_documents') }}</label>

                        <div class="row g-3">
                            @foreach($account->documents as $doc)
                                <div class="col-md-4">
                                    <div class="premium-image-card">
                                        <img src="{{ $doc['url'] }}" class="premium-img" alt="Document">

                                        <div class="premium-overlay">
                                            <a href="{{ $doc['url'] }}" target="_blank" class="btn btn-light btn-sm shadow-sm">
                                                <i class="bx bx-show"></i> View
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                    </div>
                @endif

                <button type="submit" class="btn btn-primary btn-premium mt-3">
                    <i class="bx bx-save"></i> {{ __('business.save_changes') }}
                </button>

            </form>

        </div>
    </div>
</div>

@endsection
