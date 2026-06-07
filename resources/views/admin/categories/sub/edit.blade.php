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

<div class="container-fluid">

    {{-- Title --}}
    <h4 class="page-title mb-2">
        <i class="bx bx-edit-alt"></i>
        {{ __('subcategories.edit_title') }}
    </h4>
    <p class="text-muted mb-4">{{ __('subcategories.edit_description') }}</p>

    <div class="super-card">

        <form action="{{ route('admin.categories.sub.update', $subcategory->id) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Arabic Name --}}
            <div class="mb-4 input-wrapper">
                <label class="form-label">{{ __('subcategories.name_ar') }}</label>
                <i class="bx bx-text input-icon"></i>

                <input type="text"
                       name="name_ar"
                       class="form-control input-with-icon"
                       value="{{ old('name_ar', $subcategory->name_ar) }}"
                       required>
            </div>

            {{-- English Name --}}
            <div class="mb-4 input-wrapper">
                <label class="form-label">{{ __('subcategories.name_en') }}</label>
                <i class="bx bx-text input-icon"></i>

                <input type="text"
                       name="name_en"
                       class="form-control input-with-icon"
                       value="{{ old('name_en', $subcategory->name_en) }}"
                       required>
            </div>

            {{-- Parent Category --}}
            <div class="mb-4 input-wrapper">
                <label class="form-label">{{ __('subcategories.parent_category') }}</label>
                <i class="bx bx-category input-icon"></i>

                <select name="category_id"
                        class="form-select input-with-icon"
                        style="height:48px;"
                        required>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}"
                            {{ old('category_id', $subcategory->category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->{'name_'.app()->getLocale()} }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Submit --}}
            <button type="submit" class="btn-ultra btn-primary-ultra mt-3">
                <i class="bx bx-save"></i>
                {{ __('subcategories.update_button') }}
            </button>

        </form>

    </div>

</div>

@endsection
