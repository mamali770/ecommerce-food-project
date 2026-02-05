@extends('layout.master')

@section('title', 'Contact Us Page')

@section('link')
    <link rel="stylesheet" href="{{ asset('/css/leaflet.css') }}" />
    <script src="{{ asset('/js/leaflet.js') }}"></script>
@endsection

@section('content')

    @include('home.contact')

@endsection

@section('script')
    <script>
        var map = L.map('map').setView([35.700105, 51.400394], 14);
        var tiles = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 18,
        }).addTo(map);
        var marker = L.marker([35.700105, 51.400394]).addTo(map)
            .bindPopup('<b>sitsaz</b>').openPopup();
    </script>
@endsection