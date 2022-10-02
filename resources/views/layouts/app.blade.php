<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'Laravel') }}</title>

  <!-- Fonts -->
  <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">

{{--  TODO might be removed --}}
{{--  <!-- Trix Stylesheets -->--}}
{{--  <link rel="stylesheet" href="{{ asset('/css/trix.css') }}">--}}
{{--  <link rel="stylesheet"--}}
{{--        href="{{ (request()->is('dashboard/edit-profile')) ? asset('/css/trix-no-file-input.css') : '' }}">--}}
{{--  <link rel="stylesheet" href="{{ asset('/css/trix-custom-theme.css') }}">--}}

  <!-- Livewire -->
  @livewireStyles

  <!-- Scripts -->
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
  <div class="min-h-screen bg-base-300"
       {{-- BACKGROUND --}}
       @if ((request()->is('/')))
         style="background-image: url({{url('/background/simple-shiny.svg')}});
           background-repeat: no-repeat; background-size: 100% 100%;"
       @else
         style="background-image: url({{url('/background/polygon-luminary.svg')}});
           background-repeat: no-repeat; background-size: 100% 100%;"
       @endif>
    <!-- Page Content -->
    <main>
      <div>
        <x-informative.flash-message-success/>
        {{-- NAVBAR --}}
        @if (!(request()->is('/')))
          @include('components.navigation.navbar-main')
        @else
          @include('components.navigation.navbar-home')
        @endif
      </div>
      <div class="grid place-items-center">
        {{-- CONTENT --}}
        {{ $slot }}
      </div>
      {{-- FOOTER --}}
      <footer class="footer footer-center p-4 bg-base-300 text-base-content fixed bottom-0">
        <div>
          <p>Copyright © 2022 - All right reserved by Interstartas</p>
        </div>
      </footer>
    </main>
  </div>
  @livewireScripts
</body>
</html>

