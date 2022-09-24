<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn btn-sm btn-primary']) }}>
  {{ $slot }}
</button>
