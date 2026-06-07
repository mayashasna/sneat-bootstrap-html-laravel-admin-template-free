@extends('layouts/contentNavbarLayout')

@section('title', __('menu.roles'))

@section('content')

<style>
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
.btn-perms { background: #dbeafe; color: #1d4ed8; }
.btn-delete { background: #ffe5e5; color: #dc2626; }

</style>

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="page-title">
            <i class="ph-shield-star"></i>
            {{ __('menu.roles') }}
        </h4>

        @can('create roles')
        <a href="{{ route('admin.roles.create') }}" class="btn btn-primary btn-ultra">
            <i class="ph-plus-circle"></i>
            {{ __('menu.add_role') }}
        </a>
        @endcan
    </div>

    <div class="super-card p-3">

        <div class="table-responsive">
            <table class="table super-table text-center align-middle mb-0">

                <thead>
                    <tr>
                        <th><i class="ph-identification-card"></i> {{ __('menu.role_name') }}</th>
                        <th><i class="ph-lock-key"></i> {{ __('menu.guard') }}</th>
                        <th><i class="ph-gear-six"></i> {{ __('menu.actions') }}</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($roles as $role)
                    <tr>
                        <td class="fw-bold">{{ $role->name }}</td>
                        <td class="text-muted">{{ $role->guard_name }}</td>

                        <td>
                            <div class="d-flex justify-content-center gap-2">

                                {{-- Edit --}}
                                @can('update roles')
                                <a href="{{ route('admin.roles.edit', $role->id) }}"
                                   class="btn-ultra btn-edit"
                                   data-bs-toggle="tooltip"
                                   data-bs-title="{{ __('menu.edit_role') }}">
                                    <i class="ph-pencil-simple-line"></i>
                                </a>
                                @endcan

                                {{-- Permissions --}}
                                @can('assign role permissions')
                                <a href="{{ route('admin.roles.permissions', $role->id) }}"
                                   class="btn-ultra btn-perms"
                                   data-bs-toggle="tooltip"
                                   data-bs-title="{{ __('menu.manage_permissions') }}">
                                    <i class="ph-shield-check"></i>
                                </a>
                                @endcan

                                {{-- Delete --}}
                                @can('delete roles')
                                <form action="{{ route('admin.roles.destroy', $role->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn-ultra btn-delete"
                                            data-bs-toggle="tooltip"
                                            data-bs-title="{{ __('menu.delete_role') }}"
                                            onclick="return confirm('{{ __('menu.confirm_delete') }}')">
                                        <i class="ph-trash-simple"></i>
                                    </button>
                                </form>
                                @endcan

                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>

            </table>
        </div>

    </div>

</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
})
</script>

@endsection
