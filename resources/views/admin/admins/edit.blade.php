@extends('layouts/contentNavbarLayout')

@section('content')

<div class="card">
    <div class="card-header">
        <h4>{{ __('admin.admins.edit_title') }}</h4>
    </div>

    <div class="card-body">

        {{-- Validation Errors --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('admin.admins.update', $admin->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">{{ __('admin.admins.name') }}</label>
                <input type="text" name="name" class="form-control"
                       value="{{ old('name', $admin->name) }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">{{ __('admin.admins.email') }}</label>
                <input type="email" name="email" class="form-control"
                       value="{{ old('email', $admin->email) }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">{{ __('admin.admins.status') }}</label>
                <select name="status" class="form-select" required>
                    <option value="active"
                        {{ old('status', $admin->status) === 'active' ? 'selected' : '' }}>
                        {{ __('admin.admins.status_active') }}
                    </option>
                    <option value="blocked"
                        {{ old('status', $admin->status) === 'blocked' ? 'selected' : '' }}>
                        {{ __('admin.admins.status_blocked') }}
                    </option>
                </select>
            </div>

            {{-- Roles (Multi-Select Checkboxes) --}}
            <div class="mb-3">
                <label class="form-label">{{ __('admin.admins.role') }}</label>

                <div class="row">
 @foreach($roles as $role)
    <div class="col-6">
        <label class="d-flex align-items-center gap-2">
            <input type="checkbox"
                   name="roles[]"
                   value="{{ $role->name }}"
                   {{ in_array(
                        $role->name,
                        old('roles', $admin->roles->pluck('name')->toArray())
                    ) ? 'checked' : '' }}>
            {{ $role->display_name ?? $role->name }}
        </label>
    </div>
@endforeach

                </div>
            </div>

            <button class="btn btn-primary">{{ __('admin.admins.update_button') }}</button>
        </form>

    </div>
</div>

@endsection
