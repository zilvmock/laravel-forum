<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ $BladeTitle ?? config('app.name', 'Interstartas') }}</title>

  <!-- Fonts -->
  <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">

  <!-- Livewire -->
  @livewireStyles

  <!-- Scripts -->
  @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/prevent-scroll-on-modal.js'])
</head>
<body class="font-ubuntu antialiased">
<div class="flex flex-col bg-base-300"
     {{-- BACKGROUND --}}
     @if ((request()->is('/')))
       style="background-image: url({{url('/background/simple-shiny.svg')}});
       background-position: center center;
       background-repeat: no-repeat;
       background-size: cover;
       height: 100%;"
  @endif>
  <main class="min-h-screen bg-base-content">
    <x-informative.flash-message-success/>
    {{-- NAVBAR --}}
    @if (request()->is('/') || request()->is('about-us'))
      @include('components.navigation.navbar-home')
    @else
      @include('components.navigation.navbar-main')
    @endif
    <div class="grid place-items-center">
      {{-- CONTENT --}}
      {{ $slot }}
    </div>
  </main>
  {{-- FOOTER --}}
  <footer class="footer footer-center p-4 bg-base-300 text-base-content">
    <div>
      <p>Copyright © 2022 - All right reserved by Interstartas</p>
    </div>
  </footer>
</div>
@livewireScripts
</body>
</html>

