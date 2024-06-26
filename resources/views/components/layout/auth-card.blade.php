<div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-base-300"
     style="background-image: url({{url('/background/simple-shiny.svg')}});
         background-repeat: no-repeat; background-size: 100% 100%;">
  <div>
    {{ $logo ?? ''}}
  </div>

  <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-base-100 shadow-md overflow-hidden sm:rounded-lg">
    {{ $slot }}
  </div>
</div>
