@extends('layouts/contentNavbarLayout')

@section('title', 'Dashboard - Analytics')

@section('vendor-style')
@vite('resources/assets/vendor/libs/apex-charts/apex-charts.scss')
@endsection

@section('vendor-script')
@vite('resources/assets/vendor/libs/apex-charts/apexcharts.js')
@endsection

@section('page-script')
@vite('resources/assets/js/dashboards-analytics.js')
@endsection

@section('content')

{{-- ============================= --}}
{{-- عرض صور السلايدر فوق الكروت --}}
<!-- Slider Full Width -->
<div class="fade-slider" id="heroSlider">
    @foreach ($images as $index => $img)
        <div class="fade-slide {{ $img['expired'] ? 'expired-image' : '' }} {{ $index === 0 ? 'active' : '' }}">
            <img src="{{ asset('storage/sliders/' . $img['path']) }}" alt="slider image">

            {{-- Status Badge --}}
            @if ($img['expired'])
                <span class="expired-badge">{{ __('slider.expired') }}</span>
            @else
                <span class="active-badge">{{ __('slider.active') }}</span>
            @endif
        </div>
    @endforeach

    {{-- أسهم التنقل --}}
    @if(count($images) > 1)
        <button class="slider-arrow slider-prev" id="sliderPrev" type="button">
            <i class="bx bx-chevron-right"></i>
        </button>
        <button class="slider-arrow slider-next" id="sliderNext" type="button">
            <i class="bx bx-chevron-left"></i>
        </button>

        {{-- نقاط التنقل --}}
        <div class="slider-dots">
            @foreach ($images as $index => $img)
                <span class="slider-dot {{ $index === 0 ? 'active' : '' }}" data-index="{{ $index }}"></span>
            @endforeach
        </div>
    @endif
</div>

<style>
/* ===== Slider ===== */
.fade-slider {
    position: relative;
    width: 100%;
    height: 240px;
    max-height: 240px;
    overflow: hidden;
    border-radius: 18px;
    box-shadow: 0 14px 40px rgba(0,0,0,0.16);
    margin-bottom: 28px;
    background: #0e0e1a;
}
.fade-slide {
    position: absolute;
    inset: 0;
    opacity: 0;
    transition: opacity 1.2s ease-in-out;
    z-index: 0;
}
.fade-slide.active { opacity: 1; z-index: 1; }
.fade-slide img {
    width: 100%;
    height: 100%;
    object-fit: contain;           /* يحافظ على ملامح الصورة */
    object-position: center;
    border-radius: 18px;
    position: relative;
    z-index: 1;
}
.expired-image img { filter: grayscale(100%) brightness(60%); opacity: 0.6; }
.expired-badge, .active-badge {
    position: absolute;
    top: 14px;
    inset-inline-start: 14px;
    padding: 6px 16px;
    border-radius: 10px;
    font-size: 13px;
    font-weight: bold;
    box-shadow: 0 3px 12px rgba(0,0,0,0.3);
    color: #fff;
    z-index: 3;
    backdrop-filter: blur(4px);
}
.expired-badge { background: rgba(255,59,59,0.92); }
.active-badge  { background: rgba(40,199,111,0.92); }
.slider-arrow {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    width: 42px;
    height: 42px;
    border: none;
    border-radius: 50%;
    background: rgba(255,255,255,0.2);
    backdrop-filter: blur(8px);
    color: #fff;
    font-size: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    z-index: 4;
    opacity: 0;
    transition: .25s ease;
}
.fade-slider:hover .slider-arrow { opacity: 1; }
.slider-arrow:hover { background: rgba(106,90,249,0.9); transform: translateY(-50%) scale(1.1); }
.slider-prev { inset-inline-start: 14px; }
.slider-next { inset-inline-end: 14px; }
.slider-dots {
    position: absolute;
    bottom: 14px;
    left: 0; right: 0;
    display: flex;
    justify-content: center;
    gap: 8px;
    z-index: 4;
}
.slider-dot {
    width: 9px;
    height: 9px;
    border-radius: 50%;
    background: rgba(255,255,255,0.5);
    cursor: pointer;
    transition: .3s ease;
}
.slider-dot.active { background: #fff; width: 26px; border-radius: 6px; }
@media (max-width: 768px) {
    .fade-slider { height: 180px; max-height: 180px; }
    .slider-arrow { opacity: 1; }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const root = document.getElementById('heroSlider');
    if (!root) return;

    const slides = root.querySelectorAll('.fade-slide');
    const dots   = root.querySelectorAll('.slider-dot');
    const prev   = document.getElementById('sliderPrev');
    const next   = document.getElementById('sliderNext');
    let current = 0;
    let timer;

    // خلفية مموّهة لكل شريحة بصورتها (تملأ الفراغ حول الصورة)
    slides.forEach(slide => {
        const img = slide.querySelector('img');
        if (img) {
            const bg = document.createElement('div');
            bg.style.cssText = `position:absolute;inset:0;z-index:0;border-radius:18px;
                background:url('${img.src}') center/cover;filter:blur(22px) brightness(.5);transform:scale(1.1);`;
            slide.insertBefore(bg, img);
        }
    });

    function goToSlide(index) {
        slides[current].classList.remove('active');
        if (dots.length) dots[current].classList.remove('active');
        current = (index + slides.length) % slides.length;
        slides[current].classList.add('active');
        if (dots.length) dots[current].classList.add('active');
    }
    function startAuto() {
        clearInterval(timer);
        timer = setInterval(() => goToSlide(current + 1), 4000);
    }
    if (dots.length) {
        dots.forEach(dot =>
            dot.addEventListener('click', () => { goToSlide(parseInt(dot.dataset.index)); startAuto(); })
        );
    }
    if (prev) prev.addEventListener('click', () => { goToSlide(current - 1); startAuto(); });
    if (next) next.addEventListener('click', () => { goToSlide(current + 1); startAuto(); });
    root.addEventListener('mouseenter', () => clearInterval(timer));
    root.addEventListener('mouseleave', () => { if (slides.length > 1) startAuto(); });
    if (slides.length > 1) startAuto();
});
</script>


{{-- ========================================================= --}}
{{-- TOP KPI CARDS (YOUR CUSTOM DASHBOARD) --}}
{{-- ========================================================= --}}
<div class="row g-4 mb-4">

  <!-- Business Accounts -->
  <div class="col-sm-6 col-xl-4">
    <div class="kpi-card business">
      <div class="kpi-icon"><i class="bx bx-briefcase"></i></div>
      <h5>{{ __('admin.dashboard.business_accounts') }}</h5>
      <div class="kpi-number">{{ $businessAccountsTotal }}</div>
      <a href="{{ route('admin.business-accounts.index') }}" class="btn btn-sm">
        {{ __('admin.dashboard.manage_business_accounts') }}
      </a>
    </div>
  </div>

  <!-- Cities -->
  <div class="col-sm-6 col-xl-4">
    <div class="kpi-card cities">
      <div class="kpi-icon"><i class="bx bx-map"></i></div>
      <h5>{{ __('admin.cities.title') }}</h5>
      <div class="kpi-number">{{ \App\Models\City::count() }}</div>
      <a href="{{ route('admin.cities.index') }}" class="btn btn-sm">
        {{ __('admin.cities.manage') }}
      </a>
    </div>
  </div>

  <!-- Categories -->
  <div class="col-sm-6 col-xl-4">
    <div class="kpi-card categories">
      <div class="kpi-icon"><i class="bx bx-category"></i></div>
      <h5>{{ __('admin.categories.title') }}</h5>
      <div class="kpi-number">{{ \App\Models\Category::count() }}</div>
      <a href="{{ route('admin.categories.index') }}" class="btn btn-sm">
        {{ __('admin.categories.manage') }}
      </a>
    </div>
  </div>

  <!-- Dynamic Fields -->
  <div class="col-sm-6 col-xl-4">
    <div class="kpi-card fields">
      <div class="kpi-icon"><i class="bx bx-slider"></i></div>
      <h5>{{ __('admin.fields.title') }}</h5>
      <div class="kpi-number">{{ \App\Models\Field::count() }}</div>
      <a href="{{ route('admin.fields.index') }}" class="btn btn-sm">
        {{ __('admin.fields.manage') }}
      </a>
    </div>
  </div>

  <!-- Roles -->
  @can('view roles')
  <div class="col-sm-6 col-xl-4">
    <div class="kpi-card roles">
      <div class="kpi-icon"><i class="bx bx-shield"></i></div>
      <h5>{{ __('admin.dashboard.roles') }}</h5>
      <div class="kpi-number">{{ $rolesCount }}</div>
      <a href="{{ route('admin.roles.index') }}" class="btn btn-sm">
        {{ __('admin.dashboard.manage_roles') }}
      </a>
    </div>
  </div>
  @endcan

  <!-- Admins -->
  @can('view admins')
  <div class="col-sm-6 col-xl-4">
    <div class="kpi-card admins">
      <div class="kpi-icon"><i class="bx bx-user"></i></div>
      <h5>{{ __('admin.dashboard.admins') }}</h5>
      <div class="kpi-number">{{ $adminsCount }}</div>
      <a href="{{ route('admin.admins.index') }}" class="btn btn-sm">
        {{ __('admin.dashboard.manage_admins') }}
      </a>
    </div>
  </div>
  @endcan

  <!-- Services -->
  <div class="col-sm-6 col-xl-4">
    <div class="kpi-card services">
      <div class="kpi-icon"><i class="bx bx-list-ul"></i></div>
      <h5>{{ __('admin.services.title') }}</h5>
      <div class="kpi-number">{{ \App\Models\Service::count() }}</div>
      <a href="{{ route('admin.services.index') }}" class="btn btn-sm">
        {{ __('admin.services.manage') }}
      </a>
    </div>
  </div>

  <!-- Reports -->
  <div class="col-sm-6 col-xl-4">
    <div class="kpi-card reports">
      <div class="kpi-icon"><i class="bx bx-error"></i></div>
      <h5>{{ __('admin.reports.title') }}</h5>
      <div class="kpi-number">{{ \App\Models\Report::count() }}</div>
      <a href="{{ route('admin.reports.index') }}" class="btn btn-sm">
        {{ __('admin.reports.manage') }}
      </a>
    </div>
  </div>

  <!-- Conversations -->
  @can('view-conversations')
  <div class="col-sm-6 col-xl-4">
    <div class="kpi-card conversations">
      <div class="kpi-icon"><i class="bx bx-chat"></i></div>
      <h5>{{ __('admin.dashboard.conversations') }}</h5>
      <div class="kpi-number">{{ \App\Models\Conversation::count() }}</div>
      <a href="{{ route('admin.conversations.index') }}" class="btn btn-sm">
        {{ __('admin.dashboard.manage_conversations') }}
      </a>
    </div>
  </div>
  @endcan

</div>


{{-- ============================= --}}
{{-- Welcome Card (Customized for your project) --}}
{{-- ============================= --}}
<div class="row mb-4">
  <div class="col-12">
    <div class="card">
        <div class="d-flex align-items-center row">

            {{-- Text Section --}}
            <div class="col-sm-7">
                <div class="card-body">
                    <h5 class="card-title text-primary mb-3">
                        {{ __('admin.dashboard.welcome_back') }} 👋
                    </h5>
                    <p class="mb-0">
                        {{ __('admin.dashboard.summary_text') }}
                        <br>
                        {{ __('admin.dashboard.keep_up') }}
                    </p>
                </div>
            </div>

            {{-- Illustration --}}
            <div class="col-sm-5 text-center text-sm-left">
                <div class="card-body pb-0 px-0 px-md-6">
                    <img src="{{ asset('assets/img/illustrations/man-with-laptop.png') }}"
                         height="175"
                         alt="Dashboard Illustration" />
                </div>
            </div>

        </div>
    </div>
  </div>
</div>


<!-- Charts Row -->
<div class="row">
  <!-- Total Revenue Chart -->
  <div class="col-md-6 mb-4">
    <div class="card h-100">
      <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="mb-0">{{ __('admin.dashboard.total_revenue') }}</h5>
      </div>
      <div class="card-body">
        <div id="totalRevenueChart" style="min-height: 280px;"></div>
      </div>
    </div>
  </div>

  <!-- Top Cities Chart -->
  <div class="col-md-6 mb-4">
    <div class="card h-100">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">{{ __('admin.dashboard.top_cities') }}</h5>
      </div>
      <div class="card-body">
        <div id="citiesPieChart" style="min-height: 280px;"></div>
      </div>
    </div>
  </div>
</div>

<!-- تمرير البيانات من الكنترولر للـ JS -->
<script>
  window.businessAccountsData = @json($businessAccountsData);
  window.months = @json($months);
  window.cities = @json($cities);
  window.citiesCounts = @json($citiesCounts);
</script>
@endsection

<style>
/* ============================================= */
/* KPI CARDS - تصميم احترافي موحّد (ديزاين فقط) */
/* ============================================= */
.kpi-card {
  position: relative;
  border-radius: 20px;
  padding: 26px 20px;
  background: #ffffff;
  border: 1px solid #eef0f6;
  box-shadow: 0 8px 26px rgba(60,72,120,0.08);
  transition: all .35s cubic-bezier(.2,.8,.2,1);
  text-align: center;
  overflow: hidden;
  height: 100%;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: flex-start;
}
.kpi-card::after {
  content: "";
  position: absolute;
  top: 0;
  inset-inline-start: 0;
  width: 100%;
  height: 4px;
  background: linear-gradient(90deg, #6a5af9, #8f7bff);
  transform: scaleX(0);
  transform-origin: center;
  transition: transform .35s ease;
}
.kpi-card:hover {
  transform: translateY(-6px);
  box-shadow: 0 18px 44px rgba(60,72,120,0.16);
  border-color: transparent;
}
.kpi-card:hover::after { transform: scaleX(1); }

.kpi-icon {
  width: 58px;
  height: 58px;
  border-radius: 16px;
  background: linear-gradient(135deg, #6a5af9, #8f7bff);
  display: flex;
  align-items: center;
  justify-content: center;
  margin: 0 auto 16px;
  box-shadow: 0 8px 20px rgba(106,90,249,0.35);
  transition: .35s ease;
  flex: 0 0 auto;
}
.kpi-card:hover .kpi-icon { transform: rotate(-6deg) scale(1.08); }
.kpi-icon i { font-size: 26px; color: #fff; }

.kpi-card h5 {
  font-weight: 700;
  font-size: 15px;
  color: #5a6072;
  margin-bottom: 8px;
}
.kpi-number {
  font-size: 36px;
  font-weight: 900;
  color: #2b2f48;
  margin-bottom: 16px;
  line-height: 1;
  flex: 1 1 auto;
  display: flex;
  align-items: center;
}
.kpi-card .btn {
  border-radius: 12px;
  padding: 8px 22px;
  font-weight: 700;
  font-size: 13px;
  background: linear-gradient(135deg, #6a5af9, #8f7bff);
  color: #fff;
  border: none;
  transition: all .3s ease;
  box-shadow: 0 6px 16px rgba(106,90,249,0.28);
  margin-top: auto;
}
.kpi-card .btn:hover {
  transform: translateY(-2px) scale(1.04);
  box-shadow: 0 10px 24px rgba(106,90,249,0.4);
  color: #fff;
}

/* ألوان مميزة لكل نوع كرت */
.kpi-card.cities::after        { background: linear-gradient(90deg,#0ea5e9,#38bdf8); }
.kpi-card.categories::after    { background: linear-gradient(90deg,#f59e0b,#fbbf24); }
.kpi-card.fields::after        { background: linear-gradient(90deg,#10b981,#34d399); }
.kpi-card.roles::after         { background: linear-gradient(90deg,#ef4444,#f87171); }
.kpi-card.admins::after        { background: linear-gradient(90deg,#8b5cf6,#a78bfa); }
.kpi-card.services::after      { background: linear-gradient(90deg,#ec4899,#f472b6); }
.kpi-card.reports::after       { background: linear-gradient(90deg,#f43f5e,#fb7185); }
.kpi-card.conversations::after { background: linear-gradient(90deg,#14b8a6,#2dd4bf); }

.kpi-card.cities .kpi-icon     { background: linear-gradient(135deg,#0ea5e9,#38bdf8); box-shadow:0 8px 20px rgba(14,165,233,.35); }
.kpi-card.categories .kpi-icon { background: linear-gradient(135deg,#f59e0b,#fbbf24); box-shadow:0 8px 20px rgba(245,158,11,.35); }
.kpi-card.fields .kpi-icon     { background: linear-gradient(135deg,#10b981,#34d399); box-shadow:0 8px 20px rgba(16,185,129,.35); }
.kpi-card.roles .kpi-icon      { background: linear-gradient(135deg,#ef4444,#f87171); box-shadow:0 8px 20px rgba(239,68,68,.35); }
.kpi-card.admins .kpi-icon     { background: linear-gradient(135deg,#8b5cf6,#a78bfa); box-shadow:0 8px 20px rgba(139,92,246,.35); }
.kpi-card.services .kpi-icon   { background: linear-gradient(135deg,#ec4899,#f472b6); box-shadow:0 8px 20px rgba(236,72,153,.35); }
.kpi-card.reports .kpi-icon    { background: linear-gradient(135deg,#f43f5e,#fb7185); box-shadow:0 8px 20px rgba(244,63,94,.35); }
.kpi-card.conversations .kpi-icon { background: linear-gradient(135deg,#14b8a6,#2dd4bf); box-shadow:0 8px 20px rgba(20,184,166,.35); }
</style>
