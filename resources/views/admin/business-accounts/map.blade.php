@extends('layouts/contentNavbarLayout')

@section('content')

<div class="card">
    <div class="card-header">
        <h4>موقع الحساب على الخريطة</h4>
    </div>

    <div class="card-body">
        <p><strong>اسم الحساب:</strong> {{ $business->name_ar }}</p>

        <div id="map" style="width: 100%; height: 500px; border-radius: 10px;"></div>
    </div>
</div>

<script>
    function initMap() {
        const position = { lat: {{ $lat }}, lng: {{ $lng }} };

        const map = new google.maps.Map(document.getElementById("map"), {
            center: position,
            zoom: 14,
        });

        new google.maps.Marker({
            position: position,
            map: map,
        });
    }
</script>

<script async
    src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_KEY') }}&callback=initMap">
</script>

@endsection
