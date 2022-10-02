<div>
  <button wire:click.prevent="updateLikes({{$comment->id}})"
          class="{{$comment->isLiked($comment->id) ? 'bg-success/50' : ''}} h-12 btn btn-sm btn-ghost hover:btn-success rounded-full">
    <x-icons.heroicons.hand-thumb-up/><br>{{$likes}}
  </button>
</div>
