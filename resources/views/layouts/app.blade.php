<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'Laravel') }}</title>

  <!-- Fonts -->
  <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">

  <!-- Stylesheets -->
  <link rel="stylesheet" href="{{ asset('/css/trix.css') }}">
  <link rel="stylesheet"
        href="{{ (request()->is('dashboard/edit-profile')) ? asset('/css/trix-no-file-input.css') : '' }}">

  <!-- Scripts -->
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
<div class="min-h-screen bg-base-300"
     @if ((request()->is('/')))
       style="background-image: url({{url('/background/simple-shiny.svg')}});
         background-repeat: no-repeat; background-size: 100% 100%;"
     @else
       style="background-image: url({{url('/background/polygon-luminary.svg')}});
         background-repeat: no-repeat; background-size: 100% 100%;"
  @endif>
  @if (!(request()->is('/')))
    @include('components.navigation.navbar-main')
  @endif

  {{--    @include('components.navigation.navbar-main')--}}

  {{--    <!-- Page Heading -->--}}
  {{--    <header class="shadow bg-base-200">--}}
  {{--        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">--}}
  {{--            {{ $header }}--}}
  {{--        </div>--}}
  {{--    </header>--}}

  <!-- Page Content -->
  <main>
    <x-informative.flash-message-success/>
    {{ $slot }}
    {{-- FOOTER --}}
    <footer class="footer footer-center p-4 bg-base-300 text-base-content">
      <div>
        <p>Copyright © 2022 - All right reserved by Interstartas</p>
      </div>
    </footer>
  </main>
</div>
</body>
</html>
