@props(['disabled' => false])
<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge([
    'class' => 'input input-secondary w-full text-white input-sm mt-1 bg-base-300']) !!}>
