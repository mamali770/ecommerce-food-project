@php
    $features = App\Models\Feature::all();
    $categories = App\Models\Categories::all();
@endphp
@extends('layout.master')

@section('title', 'Home Page')

@section('link')
    <link rel="stylesheet" href="{{ asset('/css/leaflet.css') }}" />
    <script src="{{ asset('/js/leaflet.js') }}"></script>
@endsection

@section('content')

    <section class="card-area layout_padding">
        <div class="container">
            <div class="row gy-5">
                @foreach ($features as $feature)
                    <div class="col-md-4 col-sm-6 col-xs-6">
                        <div class="card text-center">
                            <div class="card-body">
                                <div class="card-icon-wrapper">
                                    <i class="bi {{ $feature->icon }} fs-2 text-white card-icon"></i>
                                </div>
                                <p class="card-text fw-bold">{{ $feature->title }}</p>
                                <p class="card-text">{{ $feature->body }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- food section -->
    <section class="food_section layout_padding-bottom">
        <div class="container" x-data="{ tab: 1 }">
            <div class="heading_container heading_center">
                <h2>
                    منو محصولات
                </h2>
            </div>

            <ul class="filters_menu">
                @foreach ($categories as $category)
                    <li :class="tab === {{ $category->id }} ? 'active' : ''" @click="tab = {{ $category->id }}">
                        {{ $category->name }}
                    </li>
                @endforeach
            </ul>

            <div class="filters-content">
                @foreach ($categories as $category)
                    @php
                        $products = App\Models\Products::where('category_id', $category->id)->where('quantity', '>', 0)->where('status', 1)->take(3)->get();
                    @endphp
                    <div x-show="tab === {{ $category->id }}">
                        <div class="row grid">
                            @foreach ($products as $product)
                                <div class="col-sm-6 col-lg-4">
                                    <x-product-box :product="$product" />
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="btn-box">
                <a href="">
                    مشاهده بیشتر
                </a>
            </div>
        </div>
    </section>
    <!-- end food section -->

    <!-- about section -->
    @include('home.about')
    <!-- end about section -->

    <!-- contact section -->
    @include('home.contact')
    <!-- end contact section -->

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
