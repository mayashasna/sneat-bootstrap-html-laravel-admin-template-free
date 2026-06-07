@php
use Illuminate\Support\Facades\Route;
@endphp

<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">

    <div class="app-brand demo">
        <a href="{{ url('/') }}" class="app-brand-link">
            <span class="app-brand-logo demo">@include('_partials.macros')</span>
            <span class="app-brand-text demo menu-text fw-bold ms-2">
                {{ config('variables.templateName') }}
            </span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="icon-base bx bx-chevron-left icon-sm d-flex align-items-center justify-content-center"></i>
        </a>
    </div>

    <div class="menu-divider mt-0"></div>
    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">

        {{-- Header --}}
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">{{ __('sidebar.main') }}</span>
        </li>

        {{-- Slider Control --}}
        @php
            $activeSlider = str_starts_with(Route::currentRouteName(), 'admin.slider');
        @endphp

        <li class="menu-item {{ $activeSlider ? 'active' : '' }}">
            <a href="{{ route('admin.slider.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-image"></i>
                <div>{{ __('sidebar.slider') }}</div>
            </a>
        </li>

        {{-- Notifications --}}
        @php
            $activeNotifications = str_starts_with(Route::currentRouteName(), 'admin.notifications');
        @endphp

        <li class="menu-item {{ $activeNotifications ? 'active' : '' }}">
            <a href="{{ route('admin.notifications.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-bell"></i>
                <div>{{ __('sidebar.notifications') }}</div>
            </a>
        </li>

        {{-- Contact Us --}}
        @php
            $activeContact = str_starts_with(Route::currentRouteName(), 'admin.contact');
        @endphp

        <li class="menu-item {{ $activeContact ? 'active' : '' }}">
            <a href="{{ route('admin.contact.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-envelope"></i>
                <div>{{ __('sidebar.contact') }}</div>
            </a>
        </li>

        {{-- Deleted Business Accounts --}}
        @php
            $activeDeleted = str_starts_with(Route::currentRouteName(), 'admin.business-accounts.deleted');
        @endphp

        <li class="menu-item {{ $activeDeleted ? 'active' : '' }}">
            <a href="{{ route('admin.business-accounts.deleted') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-trash"></i>
                <div>{{ __('sidebar.deleted_business_accounts') }}</div>
            </a>
        </li>

    </ul>

</aside>
