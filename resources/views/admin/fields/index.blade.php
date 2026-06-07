@extends('layouts/contentNavbarLayout')

@section('content')

<style>
/* ===== Premium Card ===== */
.super-card {
    border-radius: 20px;
    border: none;
    background: #ffffff;
    box-shadow: 0 10px 35px rgba(0,0,0,0.10);
    transition: .3s ease;
}
.super-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 16px 45px rgba(0,0,0,0.15);
}

/* ===== Table ===== */
.super-table thead th {
    background: #f5f6ff;
    font-weight: 700;
    font-size: 14px;
    color: #4b4b4b;
    padding: 14px;
    border-bottom: 2px solid #e0e0e0;
}
.super-table tbody tr {
    transition: .25s ease;
}
.super-table tbody tr:hover {
    background: #eef0ff;
    transform: scale(1.01);
}

/* ===== Status Badges ===== */
.badge-active {
    background: #d1f7d6;
    color: #1b8a3d;
    padding: 6px 12px;
    border-radius: 10px;
    font-weight: 600;
}
.badge-inactive {
    background: #ffd6d6;
    color: #c62828;
    padding: 6px 12px;
    border-radius: 10px;
    font-weight: 600;
}

/* ===== Action Buttons (Icon Only + Tooltip) ===== */
.btn-action {
    padding: 8px;
    width: 38px;
    height: 38px;
    border-radius: 12px;
    font-size: 18px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: .25s ease;
    position: relative;
    cursor: pointer;
    border: none;
}
.btn-action:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

/* Colors */
.btn-edit { background: #fff3cd; color: #b88600; }
.btn-delete { background: #ffe5e5; color: #dc3545; }
.btn-options { background: #e3f2fd; color: #0d6efd; }

/* Tooltip */
.btn-action .tooltip-text {
    visibility: hidden;
    opacity: 0;
    position: absolute;
    top: 50%;
    left: 120%;
    transform: translateY(-50%);
    background: #333;
    color: #fff;
    padding: 4px 10px;
    border-radius: 6px;
    font-size: 12px;
    white-space: nowrap;
    transition: .2s ease;
    z-index: 10;
}
.btn-action:hover .tooltip-text {
    visibility: visible;
    opacity: 1;
}

/* RTL/LTR */
html[dir="rtl"] .btn-action .tooltip-text {
    left: auto;
    right: 120%;
}
</style>

<div class="container-fluid">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold d-flex align-items-center gap-2">
            <i class="ph-list-checks text-primary fs-3"></i>
            {{ __('fields_list.title') }}
        </h4>
        <a href="{{ route('admin.fields.create') }}" class="btn btn-primary d-flex align-items-center gap-2">
            <i class="ph-plus-circle fs-5"></i>
            {{ __('fields_list.add_new') }}
        </a>
    </div>

    {{-- FILTERS --}}
    <div class="super-card mb-4 p-3">
        <h5 class="fw-bold d-flex align-items-center gap-2 mb-3">
            <i class="ph-funnel-simple text-info fs-4"></i>
            {{ __('fields_list.filters.title') }}
        </h5>
        <form method="GET" action="{{ route('admin.fields.index') }}">
            <div class="row g-3">

                {{-- Binding --}}
                <div class="col-md-4">
                    <label class="form-label fw-semibold">
                        <i class="ph-link-simple me-dir text-primary"></i>
                        {{ __('fields_list.filters.binding_type') }}
                    </label>
                    <select name="binding" id="binding" class="form-select shadow-sm">
                        <option value="">{{ __('fields_list.filters.all') }}</option>
                        <option value="category" {{ request('binding') === 'category' ? 'selected' : '' }}>
                            {{ __('fields_list.filters.category') }}
                        </option>
                        <option value="subcategory" {{ request('binding') === 'subcategory' ? 'selected' : '' }}>
                            {{ __('fields_list.filters.subcategory') }}
                        </option>
                    </select>
                </div>

                {{-- Category --}}
                <div class="col-md-4 {{ request('binding') === 'category' ? '' : 'd-none' }}" id="category_wrapper">
                    <label class="form-label fw-semibold">
                        <i class="ph-folders me-dir text-success"></i>
                        {{ __('fields_list.filters.category') }}
                    </label>
                    <select name="category_id" class="form-select shadow-sm">
                        <option value="">{{ __('fields_list.filters.all_categories') }}</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                                {{ app()->getLocale() === 'ar' ? ($cat->name_ar ?? $cat->name_en) : $cat->name_en }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Subcategory --}}
                <div class="col-md-4 {{ request('binding') === 'subcategory' ? '' : 'd-none' }}" id="subcategory_wrapper">
                    <label class="form-label fw-semibold">
                        <i class="ph-tree-structure me-dir text-warning"></i>
                        {{ __('fields_list.filters.subcategory') }}
                    </label>
                    <select name="subcategory_id" class="form-select shadow-sm">
                        <option value="">{{ __('fields_list.filters.all_subcategories') }}</option>
                        @foreach($subcategories as $sub)
                            <option value="{{ $sub->id }}" {{ request('subcategory_id') == $sub->id ? 'selected' : '' }}>
                                {{ app()->getLocale() === 'ar' ? ($sub->name_ar ?? $sub->name_en) : $sub->name_en }}
                            </option>
                        @endforeach
                    </select>
                </div>

            </div>
            <button type="submit" class="btn btn-info mt-3 px-4 d-flex align-items-center gap-2">
                <i class="ph-magnifying-glass fs-5"></i>
                {{ __('fields_list.filters.apply') }}
            </button>
        </form>
    </div>

    {{-- TABLE --}}
    <div class="super-card p-3">
        <div class="table-responsive">
            <table class="table super-table text-center align-middle mb-0">
                <thead>
                    <tr>
                        <th><i class="ph-hash"></i></th>
                        <th>{{ __('fields_list.table.actions') }}</th>
                        <th>{{ __('fields_list.table.status') }}</th>
                        <th>{{ __('fields_list.table.bound_to') }}</th>
                        <th>{{ __('fields_list.table.bound_id') }}</th>
                        <th>{{ __('fields_list.table.binding') }}</th>
                        <th>{{ __('fields_list.table.type') }}</th>
                        <th>{{ __('fields_list.table.name_ar') }}</th>
                        <th>{{ __('fields_list.table.name_en') }}</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($fields as $field)

                    {{-- MAIN FIELD ROW --}}
                    <tr>
                        <td class="fw-bold text-primary">{{ $field->id }}</td>

                        {{-- ACTIONS --}}
                        <td>
                            <div class="d-flex justify-content-center gap-1">
                                {{-- Edit --}}
                                <a href="{{ route('admin.fields.edit', $field->id) }}"
                                   class="btn-action btn-edit">
                                    <i class="ph-pencil-simple"></i>
                                    <span class="tooltip-text">{{ __('fields_list.buttons.edit') }}</span>
                                </a>

                                {{-- Options (يفتح الصفحة المستقلة) --}}
                                @if(in_array($field->type, ['select','checkbox','radio']))
                                    <a href="{{ route('admin.fields.options.index', $field->id) }}"
                                       class="btn-action btn-options">
                                        <i class="ph-list-bullets"></i>
                                        <span class="tooltip-text">{{ __('fields_list.buttons.options') }}</span>
                                    </a>
                                @endif

                                {{-- Delete --}}
                                <form action="{{ route('admin.fields.destroy', $field->id) }}" method="POST"
                                      onsubmit="return confirm('{{ __('fields_list.confirm_delete') }}');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn-action btn-delete">
                                        <i class="ph-trash"></i>
                                        <span class="tooltip-text">{{ __('fields_list.buttons.delete') }}</span>
                                    </button>
                                </form>
                            </div>
                        </td>

                        {{-- ACTIVE --}}
                        <td>
                            @if($field->is_active)
                                <span class="badge-active">
                                    <i class="ph-check-circle me-dir"></i>
                                    {{ __('fields_list.table.active') }}
                                </span>
                            @else
                                <span class="badge-inactive">
                                    <i class="ph-x-circle me-dir"></i>
                                    {{ __('fields_list.table.inactive') }}
                                </span>
                            @endif
                        </td>

                        {{-- BOUND NAME --}}
                        <td>
                            {{ app()->getLocale() === 'ar'
                                ? ($field->dynamic_fieldable->name_ar ?? $field->dynamic_fieldable->name_en ?? '-')
                                : ($field->dynamic_fieldable->name_en ?? '-') }}
                        </td>

                        {{-- BOUND ID --}}
                        <td class="text-muted">{{ $field->dynamic_fieldable_id ?? '-' }}</td>

                        {{-- BINDING --}}
                        <td>
                            @if($field->dynamic_fieldable_type === \App\Models\Category::class)
                                <span class="badge bg-info">{{ __('fields_list.filters.category') }}</span>
                            @elseif($field->dynamic_fieldable_type === \App\Models\Subcategory::class)
                                <span class="badge bg-primary">{{ __('fields_list.filters.subcategory') }}</span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>

                        {{-- TYPE --}}
                        <td>{{ __('fields_list.types.' . $field->type) }}</td>

                        {{-- NAMES --}}
                        <td>{{ $field->name_ar }}</td>
                        <td>{{ $field->name_en }}</td>
                    </tr>

                @empty
                    <tr>
                        <td colspan="9" class="text-muted py-4">
                            <i class="ph-info fs-3 d-block mb-2"></i>
                            {{ __('fields_list.table.no_data') }}
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

<script>
document.getElementById('binding').addEventListener('change', function () {
    let val = this.value;
    document.getElementById('category_wrapper').classList.add('d-none');
    document.getElementById('subcategory_wrapper').classList.add('d-none');

    if (val === 'category') {
        document.getElementById('category_wrapper').classList.remove('d-none');
    }
    if (val === 'subcategory') {
        document.getElementById('subcategory_wrapper').classList.remove('d-none');
    }
});
</script>

<div class="mt-4 d-flex justify-content-center">
    {{ $fields->links('vendor.pagination.sneat') }}
</div>

@endsection
