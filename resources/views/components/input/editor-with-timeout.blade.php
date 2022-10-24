<div {{ $attributes->merge(['class' => '']) }} style="display:none"
     x-data="{ show: false }"
     x-show="show"
     x-init="setTimeout(() => show = true, 1000)">
  {{$slot}}
</div>
