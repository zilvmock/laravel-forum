<x-app-layout>
  {{-- Hero 1--}}
  <x-informative.hero
    class="hero h-96 w-auto rounded m-20 drop-shadow-md w-5/6"
    style="background-image: url({{url('/images/hero-1.jpg')}});
           background-position: bottom;">
    <x-slot:content>
      Provident cupiditate voluptatem et in. Quaerat fugiat ut assumenda excepturi exercitationem quasi. In deleniti
      eaque aut repudiandae et a id nisi.
    </x-slot:content>
  </x-informative.hero>

  {{-- Hero 2--}}
  <x-informative.hero
    class="hero h-96 w-auto rounded m-20 drop-shadow-md w-5/6"
    style="background-image: url({{url('/images/hero-2.jpg')}});">
    <x-slot:title>Join Our Forum</x-slot:title>
    <x-slot:content>
      Provident cupiditate voluptatem et in. Quaerat fugiat ut assumenda excepturi exercitationem quasi. In deleniti
      eaque aut repudiandae et a id nisi.
    </x-slot:content>
    <x-slot:extra>
      <button class="btn btn-primary" onClick="location.href='{{route('login')}}'">Get Started</button>
    </x-slot:extra>
  </x-informative.hero>
</x-app-layout>
