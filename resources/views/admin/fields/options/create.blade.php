@extends('layouts/contentNavbarLayout')

@section('title', __('fields_options.create_title'))

@section('content')
<div class="container-fluid">

    <h4 class="fw-bold mb-4">{{ __('fields_options.create_title') }}</h4>

    <form action="{{ route('admin.fields.options.store', $field->id) }}" method="POST">
        @csrf

        <!-- القيمة بالعربي -->
        <div class="mb-3">
            <label class="form-label">{{ __('fields_options.form.value_ar') }}</label>
            <input type="text" name="value_ar" class="form-control" value="{{ old('value_ar') }}" required>
        </div>

        <!-- القيمة بالإنجليزي -->
        <div class="mb-3">
            <label class="form-label">{{ __('fields_options.form.value_en') }}</label>
            <input type="text" name="value_en" class="form-control" value="{{ old('value_en') }}" required>
        </div>

        <!-- الحالة -->
        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" name="is_active" value="1" checked>
            <label class="form-check-label">{{ __('fields_options.form.status') }}</label>
        </div>

        <!-- أزرار الحفظ والرجوع -->
        <button type="submit" class="btn btn-primary">
            {{ __('fields_options.buttons.save') }}
        </button>

        <a href="{{ route('admin.fields.options.index', $field->id) }}" class="btn btn-secondary">
            {{ __('fields_options.buttons.back') }}
        </a>
    </form>

</div>
@endsection
