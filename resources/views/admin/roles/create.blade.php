@extends('layouts/contentNavbarLayout')

@section('title', __('menu.add_role'))

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="card-title">{{ __('menu.add_role') }}</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.roles.store') }}" method="POST">
            @csrf

            <!-- اسم الدور -->
            <div class="mb-3">
                <label class="form-label">{{ __('menu.role_name') }}</label>
                <input type="text" name="name" class="form-control" required>
                @error('name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- guard_name مخفي -->
            <input type="hidden" name="guard_name" value="admin">

            <!-- زر الحفظ -->
            <button type="submit" class="btn btn-primary">
                {{ __('menu.save') }}
            </button>
        </form>
    </div>
</div>
@endsection
