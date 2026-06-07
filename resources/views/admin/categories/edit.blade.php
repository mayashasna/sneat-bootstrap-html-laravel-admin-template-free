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

/* ===== Input Wrapper ===== */
.input-wrapper {
    position: relative;
}
.input-wrapper i.input-icon {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    font-size: 20px;
    color: #6c5ce7;
    opacity: .8;
}

/* RTL / LTR */
html[dir="rtl"] .input-wrapper i.input-icon { right: 14px; }
html[dir="ltr"] .input-wrapper i.input-icon { left: 14px; }

html[dir="rtl"] .input-with-icon { padding-right: 48px !important; }
html[dir="ltr"] .input-with-icon { padding-left: 48px !important; }

/* ===== Inputs ===== */
.input-with-icon {
    height: 48px;
    border-radius: 12px;
    border: 1px solid #dcdce8;
    transition: .3s ease;
    font-size: 15px;
}
.input-with-icon:focus {
    border-color: #6c5ce7;
    box-shadow: 0 0 0 4px rgba(108,92,231,0.18);
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

/* ===== Labels ===== */
.form-label {
    font-weight: 700;
    margin-bottom: 6px;
}
</style>

<div class="container">

    {{-- Title --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="page-title">
                <i class="bx bx-edit-alt"></i>
                Edit Category
            </h4>
            <p class="text-muted">Modify the category details with a premium experience.</p>
        </div>

        <a href="{{ route('admin.categories.index') }}" class="btn-ultra btn-secondary-ultra">
            <i class="bx bx-arrow-back"></i> Back
        </a>
    </div>

    {{-- Form --}}
    <div class="super-card">

        <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Arabic Name --}}
            <div class="mb-4 input-wrapper">
                <label class="form-label">Name (Arabic)</label>
                <i class="bx bx-text input-icon"></i>

                <input type="text"
                       name="name_ar"
                       class="form-control input-with-icon @error('name_ar') is-invalid @enderror"
                       value="{{ old('name_ar', $category->name_ar) }}"
                       required>

                @error('name_ar')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            {{-- English Name --}}
            <div class="mb-4 input-wrapper">
                <label class="form-label">Name (English)</label>
                <i class="bx bx-text input-icon"></i>

                <input type="text"
                       name="name_en"
                       class="form-control input-with-icon @error('name_en') is-invalid @enderror"
                       value="{{ old('name_en', $category->name_en) }}"
                       required>

                @error('name_en')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            {{-- Status --}}
            <div class="mb-4">
                <label class="form-label">Status</label>
                <select name="is_active" class="form-select" style="height:48px; border-radius:12px;">
                    <option value="1" {{ $category->is_active ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ !$category->is_active ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            {{-- Sort Order --}}
           

            {{-- Submit --}}
            <button type="submit" class="btn-ultra btn-primary-ultra mt-3">
                <i class="bx bx-save"></i>
                Save Changes
            </button>

        </form>

    </div>

</div>

@endsection
