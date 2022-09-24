<x-guest-layout>
  <x-layout.auth-card>
    <x-slot name="logo">
      <a href="/">
        <x-icons.application-logo class="block h-10 w-auto fill-current text-white"/>
      </a>
    </x-slot>

    <!-- Session Status -->
    <x-authentication.auth-session-status class="mb-4" :status="session('status')"/>

    <!-- Validation Errors -->
    <x-authentication.auth-validation-errors class="mb-4" :errors="$errors"/>

    <form method="POST" action="{{ route('login') }}">
      @csrf
      <!-- Email Address -->
      <div>
        <x-input.input-label for="email">Email</x-input.input-label>
        <x-input.text-input id="email"
                            type="text"
                            name="email"
                            placeholder="something@somewhere.domain"
                            value="{{old('email')}}"
                            required autofocus
        />
      </div>
      <!-- Password -->
      <div class="mt-4">
        <x-input.input-label for="password">Password</x-input.input-label>
        <x-input.text-input id="password"
                            type="password"
                            name="password"
                            placeholder="Password"
                            required autocomplete="current-password"
        />
      </div>
      {{--            <!-- Remember Me -->--}}
      {{--            <div class="block mt-4">--}}
      {{--                <label for="remember_me" class="inline-flex items-center">--}}
      {{--                    <input id="remember_me"--}}
      {{--                           type="checkbox"--}}
      {{--                           class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="remember">--}}
      {{--                    <span class="ml-2 text-sm text-gray-600"></span>--}}
      {{--                </label>--}}
      {{--            </div>--}}

      <div class="form-control flex flex-row justify-between mt-4">
        <label class="label cursor-pointer">
          <input type="checkbox"
                 checked="checked"
                 class="checkbox checkbox-xs"
                 name="remember"/>
          <span class="label-text pl-2">{{ __('Remember me') }}</span>
        </label>
        <div class="pt-1">
          @if (Route::has('password.request'))
            <x-navigation.text-link href="{{ route('password.request') }}">
              {{ __('Forgot your password?') }}
            </x-navigation.text-link>
          @endif
        </div>
      </div>
      <div class="flex justify-start mt-4">
        <x-input.primary-button class="w-full">
          {{ __('Log in') }}
        </x-input.primary-button>
      </div>
    </form>
    <x-informative.info-label class="mt-5">
      <p>To access the forum you must have an account.</p>
      <x-navigation.text-link class="underline italic text-primary" href="{{ route('register') }}">
        Don't have an account?
      </x-navigation.text-link>
    </x-informative.info-label>
  </x-layout.auth-card>
</x-guest-layout>
