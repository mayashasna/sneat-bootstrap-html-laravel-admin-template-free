@extends('layouts/contentNavbarLayout')

@section('title', 'إدارة صلاحيات الدور')

@section('content')

<h4 class="fw-bold mb-4">
    إدارة صلاحيات الدور: <span class="text-primary">{{ $role->display_name ?? $role->name }}</span>
</h4>

<form action="{{ route('admin.roles.permissions.update', $role->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="row">
        @foreach($permissions as $permission)
            <div class="col-md-3 mb-3">

                {{-- صندوق اختيار الصلاحية --}}
                <label class="form-check-label">
                    <input type="checkbox"
                           name="permissions[]"
                           value="{{ $permission->name }}"
                           class="form-check-input"
                           {{ $role->hasPermissionTo($permission->name) ? 'checked' : '' }}>
                    {{ $permission->display_name ?? $permission->name }}
                </label>

            </div>
        @endforeach
    </div>

    <button class="btn btn-primary mt-3">حفظ الصلاحيات</button>
</form>

@endsection
