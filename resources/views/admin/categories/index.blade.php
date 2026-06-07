@extends('layouts/contentNavbarLayout')

@section('content')

<style>
    .premium-table thead th {
        background: #f5f5f9;
        font-weight: 700;
        font-size: 14px;
        color: #4b4b4b;
        border-bottom: 2px solid #e0e0e0;
        padding: 12px;
        text-align: center;
    }

    .premium-table tbody tr {
        transition: .25s ease;
    }

    .premium-table tbody tr:hover {
        background: #eef1ff;
        transform: scale(1.01);
    }

    .status-badge {
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .status-active { background: #d1f7d6; color: #1b8a3d; }
    .status-inactive { background: #ffd6d6; color: #c62828; }

    .btn-action {
        padding: 6px;
        border-radius: 8px;
        font-size: 16px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: .25s ease;
        margin: 0 2px;
    }

    .btn-action:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }

    .btn-sub { background: #e3f2fd; color: #0d6efd; }
    .btn-show { background: #e8e4ff; color: #6f42c1; }
    .btn-edit { background: #fff3cd; color: #b88600; }

    .pagination .page-link {
        border-radius: 6px !important;
        margin: 0 3px;
        color: #4b4b4b;
    }

    .pagination .page-item.active .page-link {
        background: #696cff;
        border-color: #696cff;
        color: #fff;
    }
</style>

<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">
                <i class="bx bx-category-alt"></i>
                {{ __('categories.index_title') }}
            </h4>
            <p class="text-muted">{{ __('categories.index_subtitle') }}</p>
        </div>

        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary btn-action">
            <i class="bx bx-plus"></i>
            {{ __('categories.add_button') }}
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table premium-table text-center align-middle mb-0">

                <thead>
                    <tr>
                        <th><i class="bx bx-hash"></i></th>
                        <th><i class="bx bx-font"></i></th>
                        <th><i class="bx bx-font-color"></i></th>
                        <th><i class="bx bx-toggle-left"></i></th>
                        <th><i class="bx bx-cog"></i></th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($categories as $category)
                        <tr>
                            <td>{{ $category->id }}</td>
                            <td>{{ $category->name_ar }}</td>
                            <td>{{ $category->name_en }}</td>

                            <td>
                                @if($category->is_active)
                                    <span class="status-badge status-active">
                                        <i class="bx bx-check-circle"></i>
                                    </span>
                                @else
                                    <span class="status-badge status-inactive">
                                        <i class="bx bx-x-circle"></i>
                                    </span>
                                @endif
                            </td>

                            <td>
                                <a href="{{ route('admin.categories.sub.index', ['category_id' => $category->id]) }}"
                                   class="btn-action btn-sub">
                                    <i class="bx bx-list-ul"></i>
                                </a>

                                <a href="{{ route('admin.categories.show', $category->id) }}"
                                   class="btn-action btn-show">
                                    <i class="bx bx-show"></i>
                                </a>

                                <a href="{{ route('admin.categories.edit', $category->id) }}"
                                   class="btn-action btn-edit">
                                    <i class="bx bx-edit"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-muted py-4">
                                {{ __('categories.no_data') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

        <div class="mt-3 d-flex justify-content-center">
            {{ $categories->links('vendor.pagination.sneat') }}
        </div>
    </div>

</div>
@endsection
