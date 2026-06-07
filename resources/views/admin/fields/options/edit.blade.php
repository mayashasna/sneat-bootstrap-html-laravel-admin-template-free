@extends('layouts/contentNavbarLayout')

@section('title', __('field_options.edit_title'))

@section('content')
<div class="container-fluid">

    <h4 class="fw-bold mb-4">{{ __('field_options.edit_title') }}</h4>

    <form action="{{ route('admin.fields.options.update', [$field->id, $option->id]) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">{{ __('field_options.form.value_ar') }}</label>
            <input type="text" name="value_ar" class="form-control" value="{{ old('value_ar', $option->value_ar) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">{{ __('field_options.form.value_en') }}</label>
            <input type="text" name="value_en" class="form-control" value="{{ old('value_en', $option->value_en) }}" required>
        </div>

        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" name="is_active" value="1" {{ $option->is_active ? 'checked' : '' }}>
            <label class="form-check-label">{{ __('field_options.form.active') }}</label>
        </div>

        <button type="submit" class="btn btn-primary">{{ __('field_options.form.save') }}</button>
        <a href="{{ route('admin.fields.options.index', $field->id) }}" class="btn btn-secondary">
            {{ __('field_options.form.back') }}
        </a>
    </form>

</div>
@endsection
