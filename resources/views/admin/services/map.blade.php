@extends('layouts/contentNavbarLayout')

@section('content')
<div class="container">

    <h3 class="mb-4 d-flex align-items-center gap-2">
        <i class="bx bx-map fs-3 text-primary"></i>
        <span>{{ __('services.service_location') }}</span>
    </h3>

    <div class="card shadow-sm border-0">
        <div class="card-body">

            <p class="fw-semibold mb-2">{{ __('services.service_name') }}: {{ $service->title_ar }}</p>

            <div id="map" style="height: 500px; width: 100%; border-radius: 10px;"></div>

        </div>
    </div>

</div>

{{-- Leaflet CSS --}}
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />

{{-- Leaflet JS --}}
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {

        const lat = Number({{ $service->latitude }});
        const lng = Number({{ $service->longitude }});

        // إنشاء الخريطة
        const map = L.map('map').setView([lat, lng], 14);

        // طبقة الخريطة (OpenStreetMap مجانية)
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
        }).addTo(map);

        // إضافة Marker
        L.marker([lat, lng]).addTo(map)
            .bindPopup("{{ $service->title_ar }}")
            .openPopup();
    });
</script>

@endsection
