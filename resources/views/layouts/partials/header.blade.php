<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="google_api_client_id" content="{{ config('services.google.client_id') }}">
    <meta name="facebook_api_client_id" content="{{ config('services.facebook.client_id') }}">

    <title>{{ config('app.name') }}</title>

    <link rel="shortcut icon" href="{{ asset('assets/img/logo_with-background.jpg') }}" type="image/x-icon">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/img/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/img/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/img/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('assets/img/site.webmanifest') }}">
    <link rel="mask-icon" href="{{ asset('assets/img/safari-pinned-tab.svg') }}" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#000000">
    <meta name="msapplication-TileImage" content="{{ asset('assets/img/mstile-144x144.png') }}">
    <meta name="theme-color" content="#000000">

    {{--todo change backend --}}
    <link rel="alternate" type="application/rss+xml" title="Fashion Articles on sites" href="http://backend.com/rss.xml" />
    <link rel="alternate" type="application/rss+xml" title="Haute Couture Articles" href="http://backend.com/rss/haute.xml" />
    <link rel="alternate" type="application/rss+xml" title="Spotline On Articles" href="http://backend.com/rss/spotlight.xml" />
    <link href="{{ asset('css/site.css') }}" rel="stylesheet">
    <link href="{{ asset('css/flexslider.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    @yield('css')

</head>
