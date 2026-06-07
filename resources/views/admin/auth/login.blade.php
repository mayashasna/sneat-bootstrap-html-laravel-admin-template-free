@extends('layouts/blankLayout')

@section('title', __('auth.admin_login'))

@section('page-style')
  @vite(['resources/assets/vendor/scss/pages/page-auth.scss'])
@endsection

@section('content')
<div class="container-xxl">
  <div class="authentication-wrapper authentication-basic container-p-y">
    <div class="authentication-inner">

      <div class="card px-sm-6 px-0">
        <div class="card-body">

          <!-- Logo -->
          <div class="app-brand justify-content-center mb-4">
            <a href="#" class="app-brand-link gap-2">
              <span class="app-brand-logo demo">@include('_partials.macros')</span>
              <span class="app-brand-text demo text-heading fw-bold">
                {{ __('auth.admin_panel') }}
              </span>
            </a>
          </div>
          <!-- /Logo -->

          <h4 class="mb-1 text-center">{{ __('auth.welcome_back') }}</h4>
          <p class="mb-6 text-center">{{ __('auth.sign_in_continue') }}</p>

          <form method="POST" action="{{ route('admin.login.submit') }}">
            @csrf

            <!-- Email -->
            <div class="mb-6">
              <label for="email" class="form-label">{{ __('auth.email') }}</label>
              <input type="email" class="form-control" id="email" name="email"
                     placeholder="{{ __('auth.email_placeholder') }}"
                     value="{{ old('email') }}" autofocus />
              @error('email')
                <small class="text-danger">{{ $message }}</small>
              @enderror
            </div>

            <!-- Password -->
            <div class="mb-6 form-password-toggle">
              <label class="form-label" for="password">{{ __('auth.password') }}</label>
              <div class="input-group input-group-merge">
                <input type="password" id="password" class="form-control" name="password"
                       placeholder="{{ __('auth.password_placeholder') }}" />
                <span class="input-group-text cursor-pointer"><i class="icon-base bx bx-hide"></i></span>
              </div>
              @error('password')
                <small class="text-danger">{{ $message }}</small>
              @enderror
            </div>

            <!-- Submit -->
            <div class="mb-6">
              <button class="btn btn-primary d-grid w-100" type="submit">
                {{ __('auth.login') }}
              </button>
            </div>

          </form>

        </div>
      </div>

    </div>
  </div>
</div>
@endsection
