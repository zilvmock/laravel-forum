<x-guest-layout>
  <x-layout.auth-card>
    <x-slot name="logo">
      <a href="/">
        <x-icons.application-logo class="w-20 h-20 fill-current text-gray-500"/>
      </a>
    </x-slot>

    <!-- Validation Errors -->
    <x-authentication.auth-validation-errors class="mb-4" :errors="$errors"/>

    <form method="POST" action="{{ route('password.update') }}">
      @csrf

      <!-- Password Reset Token -->
      <input type="hidden" name="token" value="{{ $request->route('token') }}">

      <!-- Email Address -->
      <div>
        <x-input.input-label for="email" :value="__('Email')"/>

        <x-input.text-input id="email" class="block mt-1 w-full" type="email" name="email"
                            :value="old('email', $request->email)" required autofocus/>
      </div>

      <!-- Password -->
      <div class="mt-4">
        <x-input.input-label for="password" :value="__('Password')"/>

        <x-input.text-input id="password" class="block mt-1 w-full" type="password" name="password" required/>
      </div>

      <!-- Confirm Password -->
      <div class="mt-4">
        <x-input.input-label for="password_confirmation" :value="__('Confirm Password')"/>

        <x-input.text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required/>
      </div>

      <div class="flex items-center justify-end mt-4">
        <x-input.primary-button>
          {{ __('Reset Password') }}
        </x-input.primary-button>
      </div>
    </form>
  </x-layout.auth-card>
</x-guest-layout>
