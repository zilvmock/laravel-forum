<div>
  <button wire:click.prevent="updateLikes({{$comment->id}})"
          class="{{$comment->isLiked($comment->id) ? 'text-success' : ''}} h-8 btn btn-xs btn-ghost rounded">
    <x-icons.heroicons.hand-thumb-up/>
    <br>{{$likes}}
  </button>
</div>
