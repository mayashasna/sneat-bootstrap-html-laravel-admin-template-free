@extends('layouts/contentNavbarLayout')

@section('content')

<div class="card">
    <div class="card-header">
        <h4>{{ __('admin.admins.show_title') }}: {{ $admin->name }}</h4>
    </div>

    <div class="card-body">

        <p><strong>{{ __('admin.admins.name') }}:</strong> {{ $admin->name }}</p>
        <p><strong>{{ __('admin.admins.email') }}:</strong> {{ $admin->email }}</p>

        <p><strong>{{ __('admin.admins.role') }}:</strong>
            @if ($role)
                <span class="badge bg-primary">{{ $role->name }}</span>
            @else
                <span class="badge bg-secondary">{{ __('admin.admins.no_role') }}</span>
            @endif
        </p>

        <hr>

        <h5>{{ __('admin.admins.role_permissions') }}</h5>

        @if ($permissions->count())
            <ul class="list-group">
                @foreach ($permissions as $permission)
                    <li class="list-group-item">
                        {{ $permission->name }}
                    </li>
                @endforeach
            </ul>
        @else
            <p class="text-muted">{{ __('admin.admins.no_permissions') }}</p>
        @endif

    </div>
</div>

@endsection
