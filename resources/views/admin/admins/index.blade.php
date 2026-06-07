@extends('layouts/contentNavbarLayout')

@section('content')

<style>
/* ===== Premium Card ===== */
.super-card {
    border-radius: 18px;
    border: none;
    background: #ffffff;
    box-shadow: 0 8px 25px rgba(0,0,0,0.10);
    transition: .3s ease;
}
.super-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 14px 35px rgba(0,0,0,0.15);
}

/* ===== Page Title ===== */
.page-title {
    font-size: 26px;
    font-weight: 800;
    display: flex;
    align-items: center;
    gap: 10px;
}
.page-title i {
    font-size: 28px;
    color: #6c5ce7;
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

/* ===== Buttons ===== */
.btn-ultra {
    padding: 8px 14px;
    border-radius: 10px;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    transition: .25s ease;
}
.btn-ultra:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 18px rgba(0,0,0,0.15);
}

.btn-edit { background: #fff3cd; color: #b88600; }
.btn-delete { background: #ffe5e5; color: #dc2626; }
.btn-details { background: #dbeafe; color: #1d4ed8; }

/* ===== RTL/LTR Icon Direction ===== */
html[dir="rtl"] .me-dir { margin-left: .5rem; margin-right: 0; }
html[dir="ltr"] .me-dir { margin-right: .5rem; margin-left: 0; }

</style>

<div class="container-fluid">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="page-title">
            <i class="ph-users-three"></i>
            {{ __('admin.admins.index_title') }}
        </h4>

        <a href="{{ route('admin.admins.create') }}" class="btn btn-primary btn-ultra">
            <i class="ph-plus-circle"></i>
            {{ __('admin.admins.add_button') }}
        </a>
    </div>

    {{-- ADMINS TABLE --}}
    <div class="super-card p-3">

        <div class="table-responsive">
            <table class="table super-table text-center align-middle mb-0">

                <thead>
                    <tr>
                        <th>#</th>
                        <th><i class="ph-user"></i> {{ __('admin.admins.name') }}</th>
                        <th><i class="ph-at"></i> {{ __('admin.admins.email') }}</th>
                        <th><i class="ph-shield-check"></i> {{ __('admin.admins.role') }}</th>
                        <th><i class="ph-activity"></i> {{ __('admin.admins.status') }}</th>
                        <th><i class="ph-gear-six"></i> {{ __('admin.admins.options') }}</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($admins as $admin)
                        <tr>
                            <td class="fw-bold">{{ $admin->id }}</td>
                            <td>{{ $admin->name }}</td>
                            <td>{{ $admin->email }}</td>

                            <td>
                                @if($admin->roles->count())
                                    {{ $admin->roles->pluck('name')->join(', ') }}
                                @else
                                    <span class="text-muted">{{ __('admin.admins.no_role') }}</span>
                                @endif
                            </td>

                            <td>
                                @if($admin->status === 'active')
                                    <span class="badge bg-success px-3 py-2">
                                        <i class="ph-check-circle me-dir"></i>
                                        {{ __('admin.admins.status_active') }}
                                    </span>
                                @else
                                    <span class="badge bg-danger px-3 py-2">
                                        <i class="ph-x-circle me-dir"></i>
                                        {{ __('admin.admins.status_blocked') }}
                                    </span>
                                @endif
                            </td>

                            <td>
                                <div class="d-flex justify-content-center gap-2">

                                    {{-- Edit --}}
                                    <a href="{{ route('admin.admins.edit', $admin->id) }}"
                                       class="btn-ultra btn-edit"
                                       data-bs-toggle="tooltip"
                                       data-bs-title="{{ __('admin.admins.edit_button') }}">
                                        <i class="ph-pencil-simple-line"></i>
                                    </a>

                                    {{-- Delete --}}
                                    <form action="{{ route('admin.admins.destroy', $admin->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn-ultra btn-delete"
                                                data-bs-toggle="tooltip"
                                                data-bs-title="{{ __('admin.admins.delete_button') }}"
                                                onclick="return confirm('{{ __('admin.admins.confirm_delete') }}')">
                                            <i class="ph-trash-simple"></i>
                                        </button>
                                    </form>

                                    {{-- Details --}}
                                    <a href="{{ route('admin.admins.show', $admin->id) }}"
                                       class="btn-ultra btn-details"
                                       data-bs-toggle="tooltip"
                                       data-bs-title="{{ __('admin.admins.details_button') }}">
                                        <i class="ph-info"></i>
                                    </a>

                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>

            </table>
        </div>

    </div>

</div>

{{-- Tooltip Activation --}}
<script>
document.addEventListener("DOMContentLoaded", function () {
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
})
</script>

@endsection
