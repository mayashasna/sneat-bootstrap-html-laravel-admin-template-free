@extends('layouts/contentNavbarLayout')

@section('title', __('admin.cities.title'))

@section('content')

<style>
    /* ===== Premium Table ===== */
    .premium-table thead th {
        background: #f5f5f9;
        font-weight: 700;
        font-size: 14px;
        color: #4b4b4b;
        border-bottom: 2px solid #e0e0e0;
        padding: 12px;
    }

    .premium-table tbody tr {
        transition: .25s ease;
    }

    .premium-table tbody tr:hover {
        background: #eef1ff;
        transform: scale(1.01);
    }

    /* ===== Status Badges ===== */
    .status-badge {
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .status-active {
        background: #d1f7d6;
        color: #1b8a3d;
    }

    .status-inactive {
        background: #ffd6d6;
        color: #c62828;
    }

    /* ===== Action Buttons ===== */
    .btn-action {
        padding: 6px 10px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        transition: .25s ease;
        border: none;
    }

    .btn-action:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }

    .btn-edit { background: #fff3cd; color: #b88600; }
    .btn-delete { background: #ffe5e5; color: #dc3545; }
    .btn-enable { background: #d1f7d6; color: #1b8a3d; }
    .btn-disable { background: #e0e0e0; color: #555; }

</style>

<div class="card">

    <div class="card-header d-flex justify-content-between align-items-center">
        <h4><i class="bx bx-map-alt"></i> {{ __('admin.cities.title') }}</h4>

        <a href="{{ route('admin.cities.create') }}" class="btn btn-primary">
            <i class="bx bx-plus"></i> {{ __('admin.cities.create') }}
        </a>
    </div>

    <div class="card-body">

        <table class="table premium-table text-center">
            <thead>
                <tr>
                    <th><i class="bx bx-hash"></i></th>
                    <th><i class="bx bx-font"></i> {{ __('admin.cities.name_ar') }}</th>
                    <th><i class="bx bx-font-color"></i> {{ __('admin.cities.name_en') }}</th>
                    <th><i class="bx bx-check-shield"></i> {{ __('admin.cities.is_active') }}</th>
                    <th><i class="bx bx-cog"></i> {{ __('admin.cities.manage') }}</th>
                </tr>
            </thead>

            <tbody>
                @foreach($cities as $city)
                    <tr>
                        <td>{{ $city->id }}</td>
                        <td>{{ $city->name_ar }}</td>
                        <td>{{ $city->name_en ?? '-' }}</td>

                        <td>
                            @if($city->is_active)
                                <span class="status-badge status-active">
                                    <i class="bx bx-check-circle"></i>
                                    {{ __('admin.cities.active') }}
                                </span>
                            @else
                                <span class="status-badge status-inactive">
                                    <i class="bx bx-x-circle"></i>
                                    {{ __('admin.cities.inactive') }}
                                </span>
                            @endif
                        </td>

                        <td>

                            {{-- Edit --}}
                            <a href="{{ route('admin.cities.edit', $city->id) }}"
                               class="btn-action btn-edit" title="Edit">
                                <i class="bx bx-edit-alt"></i>
                            </a>

                            {{-- Delete --}}
                            <form action="{{ route('admin.cities.destroy', $city->id) }}"
                                  method="POST"
                                  class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        onclick="return confirm('Are you sure?')"
                                        class="btn-action btn-delete"
                                        title="Delete">
                                    <i class="bx bx-trash"></i>
                                </button>
                            </form>

                            {{-- Enable --}}
                            @if(!$city->is_active)
                                <form action="{{ route('admin.cities.enable', $city->id) }}"
                                      method="POST"
                                      class="d-inline">
                                    @csrf
                                    <button type="submit"
                                            class="btn-action btn-enable"
                                            title="Activate">
                                        <i class="bx bx-check"></i>
                                    </button>
                                </form>
                            @endif

                            {{-- Disable --}}
                            @if($city->is_active)
                                <form action="{{ route('admin.cities.disable', $city->id) }}"
                                      method="POST"
                                      class="d-inline">
                                    @csrf
                                    <button type="submit"
                                            class="btn-action btn-disable"
                                            title="Deactivate">
                                        <i class="bx bx-block"></i>
                                    </button>
                                </form>
                            @endif

                        </td>
                    </tr>
                @endforeach
            </tbody>

        </table>

    </div>
</div>

@endsection
