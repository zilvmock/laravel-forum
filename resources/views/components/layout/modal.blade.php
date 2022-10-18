<input type="checkbox" id="my-modal-6-{{$elIdName}}" class="modal-toggle"/>
<div class="modal modal-bottom sm:modal-middle preventScroll">
  <div class="modal-box text-left">
    <h3 class="font-bold text-lg">{{$title}}</h3>
    <p class="py-4">
      {{$text}}
    </p>
    <div class="modal-action">
      <form action="{{route("$route", $elId)}}" method="post">
        @csrf
        @method('DELETE')
        <x-input.primary-button class="">YES</x-input.primary-button>
      </form>
      <label for="my-modal-6-{{$elIdName}}" class="btn btn-sm btn-ghost bg-secondary/10">NO</label>
    </div>
  </div>
</div>
