@extends('layouts/contentNavbarLayout')

@section('content')

<style>
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

.super-table thead th {
    background: #f5f6ff;
    font-weight: 700;
    font-size: 14px;
    color: #4b4b4b;
    padding: 14px;
    border-bottom: 2px solid #e0e0e0;
}

.super-table tbody tr:hover {
    background: #eef0ff;
    transform: scale(1.01);
}

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

.btn-action {
    padding: 6px 10px;
    border-radius: 10px;
    font-size: 13px;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 4px;
    transition: .25s ease;
}
.btn-action:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

.btn-edit { background: #fff3cd; color: #b88600; }
.btn-disable { background: #e0e0e0; color: #555; }
.btn-enable { background: #d1f7d6; color: #1b8a3d; }
.btn-fields { background: #e3f2fd; color: #0d6efd; }

html[dir="rtl"] .me-dir { margin-left: .5rem; }
html[dir="ltr"] .me-dir { margin-right: .5rem; }
</style>

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold page-title">
                <i class="bx bx-category-alt me-dir"></i>
                {{ __('subcategories.index_title') }}
            </h4>

            <p class="text-muted">
                التصنيفات الفرعية للتصنيف:
                <strong>{{ $category->{'name_'.app()->getLocale()} }}</strong>
            </p>
        </div>

        <a href="{{ route('admin.categories.sub.create', ['category_id' => $categoryId]) }}"
           class="btn btn-primary btn-action">
            <i class="bx bx-plus"></i>
            {{ __('subcategories.add_button') }}
        </a>
    </div>

    <div class="super-card p-3">
        <div class="table-responsive">
            <table class="table super-table text-center align-middle mb-0">

                <thead>
                    <tr>
                        <th>#</th>
                        <th>{{ __('subcategories.name') }}</th>
                        <th>{{ __('subcategories.parent_category') }}</th>
                        <th>{{ __('subcategories.status') }}</th>
                        <th>{{ __('subcategories.actions') }}</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($subcategories as $index => $subcategory)
                        <tr>
                            {{-- رقم تسلسلي --}}
                            <td>{{ $index + 1 }}</td>

                            <td>{{ $subcategory->{'name_'.app()->getLocale()} }}</td>

                            <td>{{ $category->{'name_'.app()->getLocale()} }}</td>

                            <td>
                                @if ($subcategory->is_active)
                                    <span class="badge-active">{{ __('subcategories.active') }}</span>
                                @else
                                    <span class="badge-inactive">{{ __('subcategories.inactive') }}</span>
                                @endif
                            </td>

                            <td class="d-flex justify-content-center gap-1">

                                {{-- Edit --}}
                                <a href="{{ route('admin.categories.sub.edit', $subcategory->id) }}"
                                   class="btn-action btn-edit"
                                   title="تعديل">
                                    <i class="bx bx-edit"></i>
                                </a>

                                {{-- Enable / Disable --}}
                                @if ($subcategory->is_active)
                                    <form action="{{ route('admin.categories.sub.disable', $subcategory->id) }}"
                                          method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button class="btn-action btn-disable" title="إيقاف التفعيل">
                                            <i class="bx bx-block"></i>
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('admin.categories.sub.enable', $subcategory->id) }}"
                                          method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button class="btn-action btn-enable" title="تفعيل">
                                            <i class="bx bx-check"></i>
                                        </button>
                                    </form>
                                @endif

                                {{-- Dynamic Fields --}}
                                <a href="{{ route('admin.fields.index', ['subcategory_id' => $subcategory->id]) }}"
                                   class="btn-action btn-fields"
                                   title="الحقول الديناميكية">
                                    <i class="bx bx-list-ul"></i>
                                </a>

                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-muted py-4">
                                {{ __('subcategories.no_data') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>
    </div>

</div>

@endsection
