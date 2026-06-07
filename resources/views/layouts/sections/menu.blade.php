@php
    $menuData = getMenuData();
@endphp

<ul class="menu-inner py-1">

    {{-- Dashboard --}}
    <li class="menu-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <a href="{{ route('admin.dashboard') }}" class="menu-link">
            <i class="menu-icon tf-icons bx bx-home-circle"></i>
            <div>{{ __('admin.dashboard') }}</div>
        </a>
    </li>

    {{-- Slider --}}
    <li class="menu-item {{ request()->routeIs('admin.slider.*') ? 'active' : '' }}">
        <a href="{{ route('admin.slider.index') }}" class="menu-link">
            <i class="menu-icon tf-icons bx bx-image"></i>
            <div>{{ __('slider.title') }}</div>
        </a>
    </li>

    {{-- Example: Users --}}
    <li class="menu-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
        <a href="{{ route('admin.users.index') }}" class="menu-link">
            <i class="menu-icon tf-icons bx bx-user"></i>
            <div>{{ __('admin.users') }}</div>
        </a>
    </li>

    {{-- Example: Settings --}}
    <li class="menu-item {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
        <a href="{{ route('admin.settings.index') }}" class="menu-link">
            <i class="menu-icon tf-icons bx bx-cog"></i>
            <div>{{ __('admin.settings') }}</div>
        </a>
    </li>

    {{-- Logout --}}
    <li class="menu-item">
        <a href="{{ route('admin.logout') }}" class="menu-link">
            <i class="menu-icon tf-icons bx bx-log-out"></i>
            <div>{{ __('admin.logout') }}</div>
        </a>
    </li>
<li class="menu-item {{ request()->routeIs('admin.slider.*') ? 'active' : '' }}">
    <a href="{{ route('admin.slider.index') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-image"></i>
        <div>{{ __('slider.title') }}</div>
    </a>
</li>

</ul>
