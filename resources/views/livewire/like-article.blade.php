<div>
  <button wire:click.prevent="updateLikes({{$article->id}})"
          class="{{$article->isLiked($article->id) ? 'text-success' : ''}} h-8 btn btn-xs btn-ghost rounded">
    <x-icons.heroicons.hand-thumb-up/>
    <br>{{$likes}}
  </button>
</div>
