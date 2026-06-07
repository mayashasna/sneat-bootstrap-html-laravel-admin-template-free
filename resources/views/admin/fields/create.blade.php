@extends('layouts/contentNavbarLayout')

@section('content')

<style>
/* ===== Ultra Premium Card ===== */
.super-card {
    border-radius: 22px;
    padding: 28px;
    border: none;
    background: #ffffff;
    box-shadow: 0 10px 35px rgba(0,0,0,0.10);
    transition: .35s ease;
}
.super-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 18px 45px rgba(0,0,0,0.18);
}
.page-title {
    font-size: 26px;
    font-weight: 800;
    display: flex;
    align-items: center;
    gap: 10px;
}
.page-title i { font-size: 28px; color: #6c5ce7; }
.input-wrapper { position: relative; }
.input-wrapper i.input-icon {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    font-size: 22px;
    color: #6c5ce7;
    opacity: .85;
}
html[dir="rtl"] .input-wrapper i.input-icon { right: 14px; }
html[dir="ltr"] .input-wrapper i.input-icon { left: 14px; }
html[dir="rtl"] .input-with-icon { padding-right: 50px !important; }
html[dir="ltr"] .input-with-icon { padding-left: 50px !important; }
.input-with-icon,
.super-select {
    height: 50px;
    border-radius: 14px;
    border: 1px solid #dcdce8;
    transition: .3s ease;
    font-size: 15px;
}
.input-with-icon:focus,
.super-select:focus {
    border-color: #6c5ce7;
    box-shadow: 0 0 0 4px rgba(108,92,231,0.18);
}
.btn-ultra {
    padding: 12px 22px;
    border-radius: 14px;
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
.btn-primary-ultra { background: #6c5ce7; border: none; color: #fff; }
.btn-secondary-ultra { background: #ececf5; border: none; color: #333; }
.form-label { font-weight: 700; margin-bottom: 6px; }

/* ===== Options Section ===== */
#options_section {
    border: 1px dashed #c9c9dd;
    border-radius: 16px;
    padding: 18px;
    background: #fafaff;
    margin-bottom: 24px;
}
.option-row {
    display: flex;
    gap: 10px;
    align-items: center;
    margin-bottom: 10px;
}
.option-row .form-control {
    height: 46px;
    border-radius: 12px;
}
.btn-remove-option {
    flex: 0 0 auto;
    width: 46px;
    height: 46px;
    border-radius: 12px;
    border: none;
    background: #ffe5e5;
    color: #dc3545;
    font-size: 20px;
    cursor: pointer;
    transition: .25s ease;
}
.btn-remove-option:hover { background: #ffd0d0; }
</style>

<div class="container-fluid">

    {{-- Title --}}
    <h4 class="page-title mb-4">
        <i class="ph-plus-circle"></i>
        {{ __('fields.title') }}
    </h4>

    <div class="super-card">

        {{-- عرض أخطاء التحقق --}}
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.fields.store') }}" method="POST">
            @csrf

            {{-- Hidden morph fields --}}
            <input type="hidden" name="dynamic_fieldable_type" id="dynamic_fieldable_type">
            <input type="hidden" name="dynamic_fieldable_id" id="dynamic_fieldable_id">

            {{-- Binding Target --}}
            <div class="mb-4 input-wrapper">
                <label class="form-label">{{ __('fields.form.bind_to') }}</label>
                <i class="ph-link-simple input-icon"></i>
                <select id="binding_target" name="binding_target" class="form-select super-select" required>
                    <option value="">{{ __('fields.form.select_binding_target') }}</option>
                    <option value="category">{{ __('fields.form.main_category') }}</option>
                    <option value="subcategory">{{ __('fields.form.subcategory') }}</option>
                </select>
            </div>

            {{-- Category --}}
            <div class="mb-4 input-wrapper d-none" id="category_wrapper">
                <label class="form-label">{{ __('fields.form.select_category') }}</label>
                <i class="ph-folders input-icon"></i>
                <select id="category_select" name="category_id" class="form-select super-select">
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">
                            {{ app()->getLocale() === 'ar' ? ($cat->name_ar ?? $cat->name_en) : $cat->name_en }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Subcategory --}}
            <div class="mb-4 input-wrapper d-none" id="subcategory_wrapper">
                <label class="form-label">{{ __('fields.form.select_subcategory') }}</label>
                <i class="ph-tree-structure input-icon"></i>
                <select id="subcategory_select" name="subcategory_id" class="form-select super-select">
                    @foreach($subcategories as $sub)
                        <option value="{{ $sub->id }}">
                            {{ app()->getLocale() === 'ar' ? ($sub->name_ar ?? $sub->name_en) : $sub->name_en }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Name AR --}}
            <div class="mb-4 input-wrapper">
                <label class="form-label">{{ __('fields.form.name_ar') }}</label>
                <i class="ph-text-aa input-icon"></i>
                <input type="text" name="name_ar" class="form-control input-with-icon" value="{{ old('name_ar') }}" required>
            </div>

            {{-- Name EN --}}
            <div class="mb-4 input-wrapper">
                <label class="form-label">{{ __('fields.form.name_en') }}</label>
                <i class="ph-text-input input-icon"></i>
                <input type="text" name="name_en" class="form-control input-with-icon" value="{{ old('name_en') }}" required>
            </div>

            {{-- Field Type --}}
            <div class="mb-4 input-wrapper">
                <label class="form-label">{{ __('fields.form.field_type') }}</label>
                <i class="ph-sliders-horizontal input-icon"></i>
                <select name="type" id="field_type" class="form-select super-select" required>
                    <option value="text">{{ __('fields.types.text') }}</option>
                    <option value="number">{{ __('fields.types.number') }}</option>
                    <option value="select">{{ __('fields.types.select') }}</option>
                    <option value="checkbox">{{ __('fields.types.checkbox') }}</option>
                    <option value="radio">{{ __('fields.types.radio') }}</option>
                    <option value="date">{{ __('fields.types.date') }}</option>
                </select>
            </div>

            {{-- ============================= --}}
            {{-- OPTIONS SECTION (Dynamic)     --}}
            {{-- ============================= --}}
            <div id="options_section" class="d-none">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <label class="form-label m-0 d-flex align-items-center gap-2">
                        <i class="ph-list-bullets" style="font-size:20px;color:#6c5ce7;"></i>
                        {{ __('fields.options_section.title') }}
                    </label>
                    <button type="button" id="add_option_btn" class="btn btn-sm btn-primary d-flex align-items-center gap-1">
                        <i class="ph-plus-circle"></i>
                        {{ __('fields.options_section.add') }}
                    </button>
                </div>

                {{-- رؤوس الأعمدة --}}
                <div class="option-row fw-semibold text-muted" style="margin-bottom:4px;">
                    <div style="flex:1;">{{ __('fields.options_section.value_ar') }}</div>
                    <div style="flex:1;">{{ __('fields.options_section.value_en') }}</div>
                    <div style="width:46px;"></div>
                </div>

                {{-- حاوية الصفوف --}}
                <div id="options_container"></div>

                <small class="text-muted d-block mt-2">
                    {{ __('fields.options_section.hint') }}
                </small>
            </div>

            {{-- Required --}}
            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" name="is_required" value="1" {{ old('is_required') ? 'checked' : '' }}>
                <label class="form-check-label">{{ __('fields.form.required') }}</label>
            </div>

            {{-- Filterable --}}
            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" name="is_filterable" value="1" {{ old('is_filterable') ? 'checked' : '' }}>
                <label class="form-check-label">{{ __('fields.form.filterable') }}</label>
            </div>

            {{-- Active --}}
            <div class="form-check mb-4">
                <input type="hidden" name="is_active" value="0">
                <input class="form-check-input" type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                <label class="form-check-label">{{ __('fields.form.active') }}</label>
            </div>

            {{-- Buttons --}}
            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn-ultra btn-primary-ultra">
                    <i class="ph-check-circle"></i>
                    {{ __('fields.form.save') }}
                </button>
                <a href="{{ route('admin.fields.index') }}" class="btn-ultra btn-secondary-ultra">
                    <i class="ph-arrow-left"></i>
                    {{ __('fields.form.back') }}
                </a>
            </div>

        </form>

    </div>

</div>

{{-- قالب صف الخيار (مخفي) --}}
<template id="option_row_template">
    <div class="option-row">
        <input type="text" name="options_ar[]" class="form-control" placeholder="{{ __('fields.options_section.value_ar') }}">
        <input type="text" name="options_en[]" class="form-control" placeholder="{{ __('fields.options_section.value_en') }}">
        <button type="button" class="btn-remove-option" title="{{ __('fields.options_section.remove') }}">
            <i class="ph-trash"></i>
        </button>
    </div>
</template>

<script>
document.addEventListener('DOMContentLoaded', function () {

    /* ===== Binding logic ===== */
    const bindTo = document.getElementById('binding_target');
    const category = document.getElementById('category_select');
    const subcategory = document.getElementById('subcategory_select');
    const typeInput = document.getElementById('dynamic_fieldable_type');
    const idInput   = document.getElementById('dynamic_fieldable_id');

    function updateBinding() {
        document.getElementById('category_wrapper').classList.add('d-none');
        document.getElementById('subcategory_wrapper').classList.add('d-none');

        if (bindTo.value === 'category') {
            document.getElementById('category_wrapper').classList.remove('d-none');
            typeInput.value = "App\\Models\\Category";
            idInput.value   = category.value;
        }
        if (bindTo.value === 'subcategory') {
            document.getElementById('subcategory_wrapper').classList.remove('d-none');
            typeInput.value = "App\\Models\\Subcategory";
            idInput.value   = subcategory.value;
        }
    }

    bindTo.addEventListener('change', updateBinding);
    category.addEventListener('change', () => idInput.value = category.value);
    subcategory.addEventListener('change', () => idInput.value = subcategory.value);
    updateBinding();

    /* ===== Options logic ===== */
    const fieldType       = document.getElementById('field_type');
    const optionsSection  = document.getElementById('options_section');
    const optionsContainer= document.getElementById('options_container');
    const addOptionBtn    = document.getElementById('add_option_btn');
    const rowTemplate     = document.getElementById('option_row_template');
    const optionTypes     = ['select', 'checkbox', 'radio'];

    function addOptionRow() {
        const clone = rowTemplate.content.cloneNode(true);
        optionsContainer.appendChild(clone);
    }

    function toggleOptionsSection() {
        if (optionTypes.includes(fieldType.value)) {
            optionsSection.classList.remove('d-none');
            // إذا ما في ولا صف، ضيف صف أول تلقائياً
            if (optionsContainer.children.length === 0) {
                addOptionRow();
            }
        } else {
            optionsSection.classList.add('d-none');
            optionsContainer.innerHTML = ''; // امسح الخيارات حتى ما تنرسل مع نوع لا يحتاجها
        }
    }

    addOptionBtn.addEventListener('click', addOptionRow);

    // حذف صف (event delegation)
    optionsContainer.addEventListener('click', function (e) {
        const removeBtn = e.target.closest('.btn-remove-option');
        if (removeBtn) {
            removeBtn.closest('.option-row').remove();
        }
    });

    fieldType.addEventListener('change', toggleOptionsSection);
    toggleOptionsSection(); // عند التحميل
});
</script>

@endsection
