@extends('layouts/contentNavbarLayout')

@section('content')
<div class="container">

    <h4 class="fw-bold mb-4">
        <i class="bx bx-show me-2"></i>
        Category Details
    </h4>

    <div class="card shadow-sm p-4">

        <p><strong>Name (AR):</strong> {{ $category->name_ar }}</p>
        <p><strong>Name (EN):</strong> {{ $category->name_en }}</p>
        <p><strong>Slug:</strong> {{ $category->slug }}</p>

        <p>
            <strong>Status:</strong>
            @if($category->is_active)
                <span class="badge bg-success">Active</span>
            @else
                <span class="badge bg-danger">Inactive</span>
            @endif
        </p>

        <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-warning">
            <i class="bx bx-edit"></i> Edit
        </a>

        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
            Back
        </a>

    </div>

</div>
@endsection
