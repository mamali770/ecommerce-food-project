<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="{{ asset('/css/bootstrap.rtl.min.css') }}">

    <link rel="stylesheet" href="{{ asset('/css/bootstrap-icons.css') }}">

    <link rel="stylesheet" href="{{ asset('/css/sweet.css') }}">

    <link rel="stylesheet" href="{{ asset('/css/main.css') }}">

    @yield('link')

    <title>sitsaz.com || @yield('title')</title>
</head>

<body>

    <header class="navbar text-center navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
        <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="{{ route('dashboard') }}">sitsaz.com</a>
        <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse"
            data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="w-100"></div>
        <div class="navbar-nav">
            <div class="nav-item text-nowrap d-flex align-items-center">
                <span class="nav-link text-white">{{ auth()->user()->name }}</span>
                <a class="nav-link text-white px-3" href="{{ route('auth.logout') }}">خروج</a>
            </div>
        </div>
    </header>
