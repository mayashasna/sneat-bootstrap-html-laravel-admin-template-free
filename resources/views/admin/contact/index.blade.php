@extends('layouts/contentNavbarLayout')

@section('title', __('contact.title'))

@section('content')

<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">{{ __('contact.title') }}</h5>
    </div>

    <div class="card-body">

        {{-- نص تعريفي --}}
        <p class="text-muted mb-4">
            {{ __('contact.intro') }}
        </p>

        {{-- البريد الإلكتروني --}}
        <div class="d-flex align-items-center mb-3">
            <i class="bx bx-envelope fs-3 text-danger me-2"></i>
            <div>
                <strong>{{ __('contact.email_us') }}</strong><br>
                <a href="mailto:mayashasna58@gmail.com" class="text-dark">
                    mayashasna58@gmail.com
                </a>
            </div>
        </div>

        {{-- واتساب --}}
        <div class="d-flex align-items-center mb-4">
            <i class="bx bxl-whatsapp fs-3 text-success me-2"></i>
            <div>
                <strong>{{ __('contact.whatsapp_text') }}</strong><br>
                <span class="text-dark">963933393778</span>
            </div>
        </div>

        {{-- زر واتساب --}}
        <a href="https://wa.me/963933393778?text={{ urlencode(__('contact.whatsapp_default_message')) }}"
           target="_blank"
           class="btn btn-success w-100">
            <i class="bx bxl-whatsapp"></i>
            {{ __('contact.whatsapp_button') }}
        </a>

    </div>
</div>

@endsection
