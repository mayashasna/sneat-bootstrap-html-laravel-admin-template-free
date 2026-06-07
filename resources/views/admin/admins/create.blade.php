@extends('layouts/contentNavbarLayout')

@section('content')

<div class="card">
    <div class="card-header">
        <h4>{{ __('admin.admins.create_title') }}</h4>
    </div>

    <div class="card-body">

        {{-- Validation Errors --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('admin.admins.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label">{{ __('admin.admins.name') }}</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">{{ __('admin.admins.email') }}</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">{{ __('admin.admins.password') }}</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">{{ __('admin.admins.status') }}</label>
                <select name="status" class="form-select" required>
                    <option value="active" {{ old('status') === 'active' ? 'selected' : '' }}>
                        {{ __('admin.admins.status_active') }}
                    </option>
                    <option value="blocked" {{ old('status') === 'blocked' ? 'selected' : '' }}>
                        {{ __('admin.admins.status_blocked') }}
                    </option>
                </select>
            </div>

            <div class="mb-3">
    <label class="form-label">{{ __('admin.admins.role') }}</label>

    <div class="row">
        @foreach($roles as $role)
            <div class="col-6">
                <label class="d-flex align-items-center gap-2">
                    <input type="checkbox" name="roles[]" value="{{ $role->name }}">
                    {{ $role->display_name ?? $role->name }}
                </label>
            </div>
        @endforeach
    </div>
</div>


            <button class="btn btn-primary">{{ __('admin.admins.add_button') }}</button>
        </form>

    </div>
</div>

@endsection
