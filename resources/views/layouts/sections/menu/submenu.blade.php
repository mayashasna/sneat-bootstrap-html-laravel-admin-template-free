@php
    use Illuminate\Support\Facades\Route;
@endphp

<ul class="menu-sub">
    @if (isset($menu))
        @foreach ($menu as $submenu)

            {{-- Active menu logic --}}
            @php
                $activeClass = null;
                $active = 'active open';
                $currentRouteName = Route::currentRouteName();

                if ($currentRouteName === $submenu->slug) {
                    $activeClass = 'active';
                }
                elseif (isset($submenu->submenu)) {
                    if (is_array($submenu->slug)) {
                        foreach ($submenu->slug as $slug) {
                            if (str_starts_with($currentRouteName, $slug)) {
                                $activeClass = $active;
                            }
                        }
                    } else {
                        if (str_starts_with($currentRouteName, $submenu->slug)) {
                            $activeClass = $active;
                        }
                    }
                }
            @endphp

            <li class="menu-item {{ $activeClass }}">
                <a href="{{ isset($submenu->url) ? url($submenu->url) : 'javascript:void(0)' }}"
                   class="{{ isset($submenu->submenu) ? 'menu-link menu-toggle' : 'menu-link' }}"
                   @if (isset($submenu->target) && !empty($submenu->target)) target="_blank" @endif>

                    {{-- Icon --}}
                    @isset($submenu->icon)
                        <i class="{{ $submenu->icon }}"></i>
                    @endisset

                    {{-- Submenu Name (Translated) --}}
                    <div>
                        {{ isset($submenu->name) ? __('sidebar.' . $submenu->name) : '' }}
                    </div>

                    {{-- Badge --}}
                    @isset($submenu->badge)
                        <div class="badge rounded-pill bg-{{ $submenu->badge[0] }} text-uppercase ms-auto">
                            {{ $submenu->badge[1] }}
                        </div>
                    @endisset
                </a>

                {{-- Nested submenu --}}
                @if (isset($submenu->submenu))
                    @include('layouts.sections.menu.submenu', ['menu' => $submenu->submenu])
                @endif
            </li>

        @endforeach
    @endif
</ul>
