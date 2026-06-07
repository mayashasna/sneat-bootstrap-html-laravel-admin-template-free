@extends('layouts/contentNavbarLayout')

@section('title', 'تعديل الدور')

@section('content')

<h4 class="fw-bold mb-4">تعديل الدور: {{ $role->display_name ?? $role->name }}</h4>

<div class="card">
    <div class="card-body">

        <form action="{{ route('admin.roles.update', $role->id) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- اسم الدور --}}
            <div class="mb-3">
                <label class="form-label">اسم الدور (name)</label>
                <input type="text" name="name" class="form-control" value="{{ $role->name }}" required>
            </div>

            {{-- الاسم الظاهر --}}
            <div class="mb-3">
                <label class="form-label">الاسم الظاهر (display_name)</label>
                <input type="text" name="display_name" class="form-control" value="{{ $role->display_name }}">
            </div>

            <button class="btn btn-primary">حفظ التعديلات</button>
        </form>

    </div>
</div>

@endsection
