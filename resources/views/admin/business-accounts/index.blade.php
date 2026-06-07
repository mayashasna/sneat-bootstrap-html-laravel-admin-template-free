@extends('layouts/contentNavbarLayout')

@section('content')

<style>
    /* ===== Premium Table ===== */
    .premium-table thead th {
        background: #f5f5f9;
        font-weight: 700;
        font-size: 14px;
        color: #4b4b4b;
        border-bottom: 2px solid #e0e0e0;
        text-align: center;
    }

    .premium-table tbody tr {
        transition: .25s ease;
    }

    .premium-table tbody tr:hover {
        background: #f0f2ff;
        transform: scale(1.01);
    }

    /* ===== Status Badges ===== */
    .status-badge {
        padding: 6px 10px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .status-pending { background: #fff3cd; color: #b88600; }
    .status-approved { background: #d1f7d6; color: #1b8a3d; }
    .status-rejected { background: #ffd6d6; color: #c62828; }

    /* ===== Action Buttons ===== */
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

    .btn-show { background: #e3f2fd; color: #0d6efd; }
    .btn-edit { background: #e8e4ff; color: #6f42c1; }
    .btn-delete { background: #ffe5e5; color: #dc3545; }

    /* ===== Pagination ===== */
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

    .pagination .page-link:hover {
        background: #eef0ff;
    }
</style>

<div class="container">

    <h1 class="mb-2"><i class="bx bx-list-ul"></i> {{ __('business.list_title') }}</h1>
    <p class="text-muted mb-4">{{ __('business.list_subtitle') }}</p>

    <div class="card p-3">
        <div class="table-responsive">
            <table class="table premium-table text-center">

                <thead>
                    <tr>
                        <th title="{{ __('business.column_id') }}"><i class="bx bx-hash"></i></th>
                        <th title="{{ __('business.column_name') }}"><i class="bx bx-user"></i></th>
                        <th title="{{ __('business.column_city') }}"><i class="bx bx-map"></i></th>
                        <th title="{{ __('business.column_activity') }}"><i class="bx bx-briefcase"></i></th>
                        <th title="{{ __('business.column_status') }}"><i class="bx bx-check-shield"></i></th>
                        <th title="{{ __('business.column_actions') }}"><i class="bx bx-cog"></i></th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($accounts as $account)
                        <tr>
                            <td>{{ $account->id }}</td>

                            <td>
                                {{ app()->getLocale() === 'ar' ? $account->name_ar : $account->name_en }}
                            </td>

                            <td>
                                {{ app()->getLocale() === 'ar' ? $account->city->name_ar : $account->city->name_en }}
                            </td>

                            <td>
                                {{ app()->getLocale() === 'ar' ? $account->activityType->name_ar : $account->activityType->name_en }}
                            </td>

                            <td>
                                @php
                                    $statusClass = [
                                        'Pending' => 'status-badge status-pending',
                                        'Approved' => 'status-badge status-approved',
                                        'Rejected' => 'status-badge status-rejected',
                                    ][$account->status];
                                @endphp

                                <span class="{{ $statusClass }}" title="{{ __('business.status_' . strtolower($account->status)) }}">
                                    <i class="bx bx-info-circle"></i>
                                </span>
                            </td>

                            <td>
                                <a href="{{ route('admin.business-accounts.show', ['id' => $account->id, 'from' => 'index']) }}"
                                   class="btn-action btn-show"
                                   title="{{ __('business.btn_show') }}">
                                    <i class="bx bx-show"></i>
                                </a>

                                <a href="{{ route('admin.business-accounts.edit', ['id' => $account->id, 'from' => 'index']) }}"
                                   class="btn-action btn-edit"
                                   title="{{ __('business.btn_edit') }}">
                                    <i class="bx bx-edit-alt"></i>
                                </a>

                                <form action="{{ route('admin.business-accounts.destroy', $account->id) }}"
                                      method="POST"
                                      class="d-inline"
                                      onsubmit="return confirm('{{ __('business.confirm_delete') }}');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn-action btn-delete" title="{{ __('business.btn_delete') }}">
                                        <i class="bx bx-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>

            </table>
        </div>

        {{-- ✅ Pagination باستخدام sneat.blade.php --}}
        <div class="mt-3 d-flex justify-content-center">
            {{ $accounts->links('vendor.pagination.sneat') }}
        </div>
    </div>

</div>
@endsection
