<div {{$attributes}}>
  <div class="hero-overlay bg-opacity-60"></div>
  <div class="hero-content text-center text-neutral-content">
    <div class="max-w-md">
      <h1 class="mb-5 text-5xl font-bold">
        {{$title ?? ''}}
      </h1>
      <p class="mb-5">
        {{$content ?? ''}}
      </p>
      {{$extra ?? ''}}
    </div>
  </div>
</div>
