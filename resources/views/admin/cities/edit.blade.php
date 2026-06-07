@extends('layouts/contentNavbarLayout')

@section('title', __('admin.cities.edit'))

@section('content')

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4>{{ __('admin.cities.edit') }}</h4>

        <a href="{{ route('admin.cities.index') }}" class="btn btn-secondary">
            {{ __('admin.cities.back') }}
        </a>
    </div>

    <div class="card-body">

        <form action="{{ route('admin.cities.update', $city->id) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Name Arabic --}}
            <div class="mb-3">
                <label class="form-label fw-bold">Name (Arabic)</label>
                <input type="text"
                       name="name_ar"
                       class="form-control @error('name_ar') is-invalid @enderror"
                       value="{{ old('name_ar', $city->name_ar) }}"
                       required>

                @error('name_ar')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Name English --}}
            <div class="mb-3">
                <label class="form-label fw-bold">Name (English)</label>
                <input type="text"
                       name="name_en"
                       class="form-control @error('name_en') is-invalid @enderror"
                       value="{{ old('name_en', $city->name_en) }}">

                @error('name_en')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Status --}}
            <div class="mb-3">
                <label class="form-label fw-bold">Status</label>
                <select name="is_active" class="form-select">
                    <option value="1" {{ $city->is_active ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ !$city->is_active ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            {{-- Submit --}}
            <button type="submit" class="btn btn-primary">
                {{ __('admin.cities.update') }}
            </button>

        </form>

    </div>
</div>

@endsection
