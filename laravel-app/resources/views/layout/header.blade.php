<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('/css/bootstrap.rtl.min.css') }}">

    <link rel="stylesheet" href="{{ asset('/css/bootstrap-icons.css') }}">

    <link rel="stylesheet" href="{{ asset('/css/style.css') }}">

    <link rel="stylesheet" href="{{ asset('/css/sweet.css') }}">

    <script src="{{ asset('js/alpine.js') }}" defer></script>

    @yield('link')

</head>

<body>

    <div class="{{ request()->is('/') ? '' : 'sub_page' }}">
        <div class="hero_area">
            <div class="bg-box">
                <img src="{{ asset('/images/hero-bg.jpg') }}" alt="">
            </div>
            <!-- header section strats -->
            <header class="header_section">
                <div class="container">
                    <nav class="navbar navbar-expand-lg custom_nav-container">
                        <a class="navbar-brand" href="{{ route('home.index') }}">
                            <span>
                                sitsaz.com
                            </span>
                        </a>

                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                            aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>

                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav mx-auto">
                                <li
                                    class="nav-item 
                                {{ request()->is('/') ? 'active' : '' }}
                                ">
                                    <a class="nav-link" href="{{ route('home.index') }}">صفحه اصلی</a>
                                </li>
                                <li
                                    class="nav-item
                                {{ request()->is('menu') ? 'active' : '' }}">
                                    <a class="nav-link" href="{{ route('product.index') }}">منو</a>
                                </li>
                                <li
                                    class="nav-item
                                {{ request()->is('about') ? 'active' : '' }}
                                ">
                                    <a class="nav-link" href="{{ route('about.index') }}">درباره ما</a>
                                </li>
                                <li
                                    class="nav-item
                                {{ request()->is('contact-us') ? 'active' : '' }}
                                ">
                                    <a class="nav-link" href="{{ route('contact.index') }}">تماس باما</a>
                                </li>
                            </ul>
                            <div class="user_option">
                                <a class="cart_link position-relative" href="{{ route('card.index') }}">
                                    <i class="bi bi-cart-fill text-white fs-5"></i>
                                    <span class="position-absolute top-0 translate-middle badge rounded-pill">
                                        {{ session()->has('card') ? count(session()->get('card')) : 0 }}
                                    </span>
                                </a>
                                @auth
                                    <a href="{{ route('profile.index') }}" class="btn-auth">
                                        پروفایل
                                    </a>
                                @endauth

                                @guest
                                    <a href="{{ route('auth.loginForm') }}" class="btn-auth">
                                        ورود
                                    </a>
                                @endguest
                            </div>
                        </div>
                    </nav>
                </div>
            </header>
            <!-- end header section -->
            <!-- slider section -->
            @if (request()->is('/'))
                @include('home.slider')
            @endif
            <!-- end slider section -->
        </div>
    </div>
