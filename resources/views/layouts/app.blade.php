@php
    $pageKey = !empty($currentPageKey) ? $currentPageKey : "";
@endphp

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="@yield('meta_description')">
        <meta name="author" content="StreamLabs Assignment">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        @yield('meta_data')
        <title>{{ config('app.name') }} - @yield('title')</title>
        <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        @section('styles')
            <link href="{{ mix('css/vendor.css') }}" rel="stylesheet">
            <link href="{{ mix('css/app.css') }}" rel="stylesheet">
            <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
        @show
    </head>
    <body>
        <div class="container">
            @include('components.overlays.full_page_loader')
            <header id="header">
                @yield('top_navigation')
            </header>

            <section class="main">
                @yield('content')
            </section>
        </div>

        <script type="text/javascript" src="{{ mix('js/page_keys.js') }}"></script>

        <script type="text/javascript">
            window.pageKeys.setCurrentKey("{{ $pageKey }}");
        </script>

        @section('scripts')
            <script type="text/javascript" src="{{ mix('js/vendor.js') }}"></script>
            <script type="text/javascript" src="{{ mix('js/app.js') }}"></script>
        @show
    </body>
</html>