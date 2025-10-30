<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0 shrin-to-fit=no">


    <!--SEO /Meta (can override per page)-->
    <meta name="description" content="@yield('meta_description', '')">
    <meta name="keywords" content="bootstrap, bootstrap5, furniture, interior">

    <title>@yield('title', 'BuyBLiss-Furniture & Interior')</title>
   


    <!-- ==== CSS ==== -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('css/tiny-slider.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    {{-- Page-specific CSS (optional) --}}
    @stack('styles')
</head>

<body>

    {{-- ====================== NAVBAR ====================== --}}
    @include('public.partials.navbar')

    {{-- ====================== MAIN CONTENT ====================== --}}
    @yield('content')

    {{-- ====================== FOOTER ====================== --}}
    @include('public.partials.footer')

    {{-- ==== JS ==== --}}
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/tiny-slider.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
    
    {{-- Page-specific JS (optional) --}}
    @stack('scripts')
</body>

</html>
