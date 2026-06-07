@extends('layouts/contentNavbarLayout')

@section('title', __('fields.title_edit'))

@section('content')

<div class="container-fluid">

    <h4 class="fw-bold mb-4">{{ __('fields.title_edit') }}</h4>

    {{-- ========================= --}}
    {{-- FORM: UPDATE FIELD --}}
    {{-- ========================= --}}

    <form action="{{ route('admin.fields.update', $field->id) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Hidden morph fields --}}
        <input type="hidden" name="dynamic_fieldable_type" id="dynamic_fieldable_type"
               value="{{ $field->dynamic_fieldable_type }}">
        <input type="hidden" name="dynamic_fieldable_id" id="dynamic_fieldable_id"
               value="{{ $field->dynamic_fieldable_id }}">

        {{-- Binding Target --}}
        <div class="mb-3">
            <label class="form-label">{{ __('fields.bind_to') }}</label>
            <select id="binding_target" class="form-select" required>
                <option value="">{{ __('fields.bind_to') }}</option>
                <option value="category"
                    {{ $field->dynamic_fieldable_type === \App\Models\Category::class ? 'selected' : '' }}>
                    {{ __('fields.bind_category') }}
                </option>
                <option value="subcategory"
                    {{ $field->dynamic_fieldable_type === \App\Models\Subcategory::class ? 'selected' : '' }}>
                    {{ __('fields.bind_subcategory') }}
                </option>
            </select>
        </div>

        {{-- Category List --}}
        <div class="mb-3 {{ $field->dynamic_fieldable_type === \App\Models\Category::class ? '' : 'd-none' }}"
             id="category_wrapper">
            <label class="form-label">{{ __('fields.select_category') }}</label>
            <select id="category_select" class="form-select">
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}"
                        {{ $field->dynamic_fieldable_type === \App\Models\Category::class && $field->dynamic_fieldable_id == $cat->id ? 'selected' : '' }}>
                        {{ $cat->name_en }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Subcategory List --}}
        <div class="mb-3 {{ $field->dynamic_fieldable_type === \App\Models\Subcategory::class ? '' : 'd-none' }}"
             id="subcategory_wrapper">
            <label class="form-label">{{ __('fields.select_subcategory') }}</label>
            <select id="subcategory_select" class="form-select">
                @foreach($subcategories as $sub)
                    <option value="{{ $sub->id }}"
                        {{ $field->dynamic_fieldable_type === \App\Models\Subcategory::class && $field->dynamic_fieldable_id == $sub->id ? 'selected' : '' }}>
                        {{ $sub->name_en }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Name Arabic --}}
        <div class="mb-3">
            <label class="form-label">{{ __('fields.name_ar') }}</label>
            <input type="text" name="name_ar" class="form-control" value="{{ $field->name_ar }}" required>
        </div>

        {{-- Name English --}}
        <div class="mb-3">
            <label class="form-label">{{ __('fields.name_en') }}</label>
            <input type="text" name="name_en" class="form-control" value="{{ $field->name_en }}" required>
        </div>

        {{-- Type --}}
        <div class="mb-3">
            <label class="form-label">{{ __('fields.field_type') }}</label>
            <select name="type" class="form-select" required>
                <option value="text" {{ $field->type === 'text' ? 'selected' : '' }}>
                    {{ __('fields.type_text') }}
                </option>
                <option value="number" {{ $field->type === 'number' ? 'selected' : '' }}>
                    {{ __('fields.type_number') }}
                </option>
                <option value="select" {{ $field->type === 'select' ? 'selected' : '' }}>
                    {{ __('fields.type_select') }}
                </option>
                <option value="checkbox" {{ $field->type === 'checkbox' ? 'selected' : '' }}>
                    {{ __('fields.type_checkbox') }}
                </option>
                <option value="radio" {{ $field->type === 'radio' ? 'selected' : '' }}>
                    {{ __('fields.type_radio') }}
                </option>
                <option value="date" {{ $field->type === 'date' ? 'selected' : '' }}>
                    {{ __('fields.type_date') }}
                </option>
            </select>
        </div>

        {{-- Required --}}
        <div class="form-check mb-2">
            <input type="hidden" name="is_required" value="0">
            <input class="form-check-input" type="checkbox" name="is_required" value="1"
                   {{ $field->is_required ? 'checked' : '' }}>
            <label class="form-check-label">{{ __('fields.required') }}</label>
        </div>

        {{-- Filterable --}}
        <div class="form-check mb-2">
            <input type="hidden" name="is_filterable" value="0">
            <input class="form-check-input" type="checkbox" name="is_filterable" value="1"
                   {{ $field->is_filterable ? 'checked' : '' }}>
            <label class="form-check-label">{{ __('fields.filterable') }}</label>
        </div>

        {{-- Active --}}
        <div class="form-check mb-3">
            <input type="hidden" name="is_active" value="0">
            <input class="form-check-input" type="checkbox" name="is_active" value="1"
                   {{ $field->is_active ? 'checked' : '' }}>
            <label class="form-check-label">{{ __('fields.active') }}</label>
        </div>

        <button type="submit" class="btn btn-primary mt-3">{{ __('fields.update') }}</button>
        <a href="{{ route('admin.fields.index') }}" class="btn btn-secondary mt-3">{{ __('fields.back') }}</a>
    </form>

    {{-- ========================= --}}
    {{-- FIELD OPTIONS MANAGEMENT --}}
    {{-- ========================= --}}

    @if(in_array($field->type, ['select', 'checkbox', 'radio']))
        <hr class="my-4">

        <h5 class="fw-bold mb-3">{{ __('fields.field_options') }}</h5>

        {{-- Add New Option --}}
        <form action="{{ route('admin.fields.options.store', $field->id) }}" method="POST" class="card p-3 mb-4">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <label class="form-label">{{ __('fields.value_ar') }}</label>
                    <input type="text" name="value_ar" class="form-control" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">{{ __('fields.value_en') }}</label>
                    <input type="text" name="value_en" class="form-control" required>
                </div>

                <div class="col-12 d-flex align-items-end mt-3">
                    <button class="btn btn-primary w-100">{{ __('fields.add_option') }}</button>
                </div>
            </div>
        </form>

        {{-- Existing Options --}}
        <div class="card p-3">
            <h6 class="fw-bold mb-3">{{ __('fields.existing_options') }}</h6>

            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>{{ __('fields.actions') }}</th>
                        <th>{{ __('fields.active') }}</th>
                        <th>{{ __('fields.value_en_col') }}</th>
                        <th>{{ __('fields.value_ar_col') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($field->options as $option)
                        <tr>
                            {{-- ACTIONS --}}
                            <td class="text-nowrap">
                                {{-- Edit Option --}}
                                <button class="btn btn-warning btn-sm" data-bs-toggle="collapse"
                                        data-bs-target="#editOption{{ $option->id }}">
                                    {{ __('fields.edit') }}
                                </button>

                                {{-- Delete Option --}}
                                <form action="{{ route('admin.fields.options.destroy', [$field->id, $option->id]) }}"
                                      method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm"
                                            onclick="return confirm('{{ __('fields.delete_confirm') }}')">
                                        {{ __('fields.delete') }}
                                    </button>
                                </form>
                            </td>

                            {{-- ACTIVE --}}
                            <td>
                                @if($option->is_active)
                                    <span class="badge bg-success">{{ __('fields.status_active') }}</span>
                                @else
                                    <span class="badge bg-secondary">{{ __('fields.status_inactive') }}</span>
                                @endif
                            </td>

                            {{-- VALUE EN --}}
                            <td>{{ $option->value_en }}</td>

                            {{-- VALUE AR --}}
                            <td>{{ $option->value_ar }}</td>
                        </tr>

                        {{-- EDIT FORM --}}
                        <tr class="collapse" id="editOption{{ $option->id }}">
                            <td colspan="4">
                                <form action="{{ route('admin.fields.options.update', [$field->id, $option->id]) }}"
                                      method="POST" class="border p-3 rounded bg-light">
                                    @csrf
                                    @method('PUT')

                                    <div class="row">
                                        <div class="col-md-4">
                                            <label class="form-label">{{ __('fields.value_ar') }}</label>
                                            <input type="text" name="value_ar" class="form-control"
                                                   value="{{ $option->value_ar }}" required>
                                        </div>

                                        <div class="col-md-4">
                                            <label class="form-label">{{ __('fields.value_en') }}</label>
                                            <input type="text" name="value_en" class="form-control"
                                                   value="{{ $option->value_en }}" required>
                                        </div>

                                        <div class="col-md-4">
                                            <label class="form-label">{{ __('fields.active') }}</label>
                                            <select name="is_active" class="form-select">
                                                <option value="1" {{ $option->is_active ? 'selected' : '' }}>
                                                    {{ __('fields.status_active') }}
                                                </option>
                                                <option value="0" {{ !$option->is_active ? 'selected' : '' }}>
                                                    {{ __('fields.status_inactive') }}
                                                </option>
                                            </select>
                                        </div>
                                    </div>

                                    <button class="btn btn-success mt-3">{{ __('fields.save_changes') }}</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">
                                {{ __('fields.no_options') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    @endif

</div>

<script>
    document.getElementById('binding_target').addEventListener('change', function () {
        let target = this.value;

        document.getElementById('category_wrapper').classList.add('d-none');
        document.getElementById('subcategory_wrapper').classList.add('d-none');

        if (target === 'category') {
            document.getElementById('category_wrapper').classList.remove('d-none');
            document.getElementById('dynamic_fieldable_type').value = "App\\Models\\Category";
            document.getElementById('dynamic_fieldable_id').value =
                document.getElementById('category_select').value;
        }

        if (target === 'subcategory') {
            document.getElementById('subcategory_wrapper').classList.remove('d-none');
            document.getElementById('dynamic_fieldable_type').value = "App\\Models\\Subcategory";
            document.getElementById('dynamic_fieldable_id').value =
                document.getElementById('subcategory_select').value;
        }
    });

    document.getElementById('category_select').addEventListener('change', function () {
        document.getElementById('dynamic_fieldable_id').value = this.value;
    });

    document.getElementById('subcategory_select').addEventListener('change', function () {
        document.getElementById('dynamic_fieldable_id').value = this.value;
    });
</script>

@endsection
