<x-guest-layout>
  <x-layout.auth-card>
    <x-slot name="logo">
      <a href="/">
        <x-icons.application-logo class="block h-10 w-auto fill-current text-white"/>
      </a>
    </x-slot>

    <!-- Validation Errors -->
    <x-authentication.auth-validation-errors class="mb-4" :errors="$errors"/>

    <form method="POST" action="{{ route('register') }}">
      @csrf
      <!-- First name -->
      <div class="mt-4">
        <x-input.input-label for="first-name">First Name</x-input.input-label>
        <x-input.text-input id="first-name"
                            type="text"
                            name="firstname"
                            placeholder="Your first name"
                            value="{{old('firstname')}}"
                            required autofocus
        />
      </div>
      <!-- Second name -->
      <div class="mt-4">
        <x-input.input-label for="second-name">Second Name</x-input.input-label>
        <x-input.text-input id="second-name"
                            type="text"
                            name="lastname"
                            placeholder="Your last name"
                            value="{{old('lastname')}}"
                            required
        />
      </div>
      <!-- Username -->
      <div class="mt-4">
        <x-input.input-label for="username">Username</x-input.input-label>
        <x-input.text-input id="username"
                            type="text"
                            name="username"
                            placeholder="Your username or nickname"
                            value="{{old('username')}}" required
        />
      </div>
      <!-- Email Address -->
      <div class="mt-4">
        <x-input.input-label for="email">Email</x-input.input-label>
        <x-input.text-input id="email"
                            type="email"
                            name="email"
                            placeholder="something@somewhere.domain"
                            value="{{old('email')}}"
                            required
        />
      </div>
      <!-- Password -->
      <div class="mt-4">
        <x-input.input-label for="password">Password</x-input.input-label>
        <x-input.text-input id="password"
                            type="password"
                            name="password"
                            placeholder="Password for your account"
                            required
        />
      </div>
      <!-- Confirm Password -->
      <div class="mt-4">
        <x-input.input-label for="password_confirmation">Repeat Password</x-input.input-label>
        <x-input.text-input id="password_confirmation"
                            type="password"
                            name="password_confirmation"
                            placeholder="Repeat password from the previous field"
                            required
        />
      </div>
      <x-navigation.text-link class="flex py-4 underline italic" href="{{ route('login') }}">
        {{ __('Already registered?') }}
      </x-navigation.text-link>
      <x-input.primary-button class="w-full">
        {{ __('Register') }}
      </x-input.primary-button>
    </form>
  </x-layout.auth-card>
</x-guest-layout>
