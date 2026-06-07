@extends('layouts/contentNavbarLayout')

@section('title', __('subcategories.add_title'))

@section('content')
<div class="container-fluid">

    <h4 class="fw-bold mb-4">{{ __('subcategories.add_title') }}</h4>
    <p class="text-muted mb-4">{{ __('subcategories.create_description') }}</p>

    <div class="card shadow-sm">
        <div class="card-body">

            <form action="{{ route('admin.categories.sub.store') }}" method="POST">
                @csrf

                {{-- Arabic Name --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        {{ __('subcategories.name_ar') }}
                        <span style="color:#ff4d6d">*</span>
                    </label>
                    <input
                        type="text"
                        name="name_ar"
                        class="form-control"
                        value="{{ old('name_ar') }}"
                        required
                    >
                    <small class="text-muted">{{ __('subcategories.name_ar_hint') }}</small>
                </div>

                {{-- English Name --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        {{ __('subcategories.name_en') }}
                        <span style="color:#ff4d6d">*</span>
                    </label>
                    <input
                        type="text"
                        name="name_en"
                        class="form-control"
                        value="{{ old('name_en') }}"
                        required
                    >
                    <small class="text-muted">{{ __('subcategories.name_en_hint') }}</small>
                </div>

                {{-- Parent Category --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        {{ __('subcategories.parent_category') }}
                        <span style="color:#ff4d6d">*</span>
                    </label>
                    <select name="category_id" class="form-select" required>
                        @foreach ($categories as $category)
                            <option
                                value="{{ $category->id }}"
                                {{ old('category_id', request('category_id')) == $category->id ? 'selected' : '' }}
                            >
                                {{ $category->{'name_'.app()->getLocale()} }}
                            </option>
                        @endforeach
                    </select>
                    <small class="text-muted">{{ __('subcategories.parent_category_hint') }}</small>
                </div>

                {{-- Default Active --}}
                <input type="hidden" name="is_active" value="1">

                <button type="submit" class="btn btn-primary">
                    {{ __('subcategories.add_button') }}
                </button>

            </form>

        </div>
    </div>

</div>
@endsection
