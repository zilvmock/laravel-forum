<div {{$attributes->merge(['class' => 'alert alert-error shadow-lg'])}}>
  <div>
    <x-icons.daisy.error/>
    <span>{{$slot}}</span>
  </div>
</div>
