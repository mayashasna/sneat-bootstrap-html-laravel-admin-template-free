@extends('layouts/contentNavbarLayout')

@section('content')

<style>
/* ===== Ultra Premium Card ===== */
.super-card {
    border-radius: 22px;
    padding: 28px;
    border: none;
    background: linear-gradient(145deg, #ffffff, #f3f3f7);
    box-shadow: 0 10px 35px rgba(0,0,0,0.12);
    transition: .35s ease;
}
.super-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 18px 45px rgba(0,0,0,0.18);
}

/* ===== Title ===== */
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

/* ===== Info Row ===== */
.info-item {
    padding: 14px 0;
    border-bottom: 1px solid #ececf5;
    display: flex;
    align-items: center;
    gap: 12px;
}
.info-item:last-child {
    border-bottom: none;
}
.info-item i {
    font-size: 22px;
    color: #6c5ce7;
}
.info-label {
    font-weight: 700;
    font-size: 15px;
}
.info-value {
    font-size: 15px;
    color: #444;
}

/* ===== Status Badges ===== */
.badge-active {
    background: #d1f7d6;
    color: #1b8a3d;
    padding: 6px 12px;
    border-radius: 10px;
    font-weight: 600;
}
.badge-inactive {
    background: #ffd6d6;
    color: #c62828;
    padding: 6px 12px;
    border-radius: 10px;
    font-weight: 600;
}

/* ===== Buttons ===== */
.btn-ultra {
    padding: 12px 22px;
    border-radius: 12px;
    font-weight: 700;
    font-size: 15px;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: .3s ease;
}
.btn-ultra:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(108,92,231,0.25);
}
.btn-primary-ultra {
    background: #6c5ce7;
    border: none;
    color: #fff;
}
.btn-secondary-ultra {
    background: #ececf5;
    border: none;
    color: #333;
}
</style>

<div class="container">

    {{-- Title --}}
    <h4 class="page-title mb-4">
        <i class="bx bx-show-alt"></i>
        Subcategory Details
    </h4>

    <div class="super-card">

        {{-- Name AR --}}
        <div class="info-item">
            <i class="bx bx-text"></i>
            <span class="info-label">Name (AR):</span>
            <span class="info-value">{{ $subcategory->name_ar }}</span>
        </div>

        {{-- Name EN --}}
        <div class="info-item">
            <i class="bx bx-text"></i>
            <span class="info-label">Name (EN):</span>
            <span class="info-value">{{ $subcategory->name_en }}</span>
        </div>

        {{-- Parent Category --}}
        <div class="info-item">
            <i class="bx bx-category"></i>
            <span class="info-label">Parent Category:</span>
            <span class="info-value">{{ $subcategory->category->{'name_'.app()->getLocale()} }}</span>
        </div>

        {{-- Status --}}
        <div class="info-item">
            <i class="bx bx-check-shield"></i>
            <span class="info-label">Status:</span>

            @if($subcategory->is_active)
                <span class="badge-active">Active</span>
            @else
                <span class="badge-inactive">Inactive</span>
            @endif
        </div>

        {{-- Buttons --}}
        <div class="mt-4 d-flex gap-2">

            <a href="{{ route('admin.categories.sub.edit', $subcategory->id) }}"
               class="btn-ultra btn-primary-ultra">
                <i class="bx bx-edit"></i>
                Edit
            </a>

            <a href="{{ route('admin.categories.sub.index', ['category_id' => $subcategory->category_id]) }}"
               class="btn-ultra btn-secondary-ultra">
                <i class="bx bx-arrow-back"></i>
                Back
            </a>

        </div>

    </div>

</div>

@endsection
