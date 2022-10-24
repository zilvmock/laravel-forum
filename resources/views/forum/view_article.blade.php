<x-app-layout>
  <x-layout.card class="md:m-4 md:p-2 mt-2 rounded-none rounded-t md:rounded md:w-9/12">
    <x-layout.top-bar>
      <x-slot:title><h1 class="m-0 text-xl font-bold">{!!$article->title!!}</h1></x-slot:title>
    </x-layout.top-bar>
    @if($articleComments->onFirstPage())
      {{-- Article Author Profile --}}
      <div class="flex flex-col pb-8 justify-center">
        <x-layout.card class="bg-dimgray rounded-b-none flex justify-between border-none">
          <div class="flex">
            <div class="avatar">
              <div class="w-12 h-fit rounded-full">
                <img alt="user avatar" src="{{asset('storage/'.$article->user->avatar)}}"/>
              </div>
            </div>
            <div class="flex flex-col p-1 pl-4">
              <b class="text-xl break-all">{{$article->user->username}}</b>
              <span class="flex font-gemunu">
                <small class="{{$article->user->role == 1 ? 'text-red-400' : 'text-blue-300'}}">
                {{$article->user->getRoleName($article->user)}}
                </small>
              </span>
              <div>
                @if($article->content_updated_at != null)
                  @if($article->updated_at == $article->content_updated_at)
                    <p class="text-xs text-secondary">Edited: {{$article->updated_at}}</p>
                  @endif
                @endif
              </div>
            </div>
          </div>
          <div class="items-center pl-4 w-auto h-auto">
            <div class="flex justify-items-end items-center w-26">
              @if($article->user->id == auth()->user()->id)
                <form action="{{route('edit_article', $article->id)}}" method="post">
                  @csrf
                  @method('GET')
                  <button class="btn btn-xs btn-ghost h-8 p-1 m-0 mx-2" type="submit">
                    <x-icons.heroicons.pencil-square/>
                  </button>
                </form>
              @endif
              @if(auth()->user()->role == 1)
                <x-layout.modal-button :elIdName="$article->id.'A'">
                  <x-icons.heroicons.trash/>
                </x-layout.modal-button>
              @endif
              {{-- Delete Modal --}}
              <x-layout.modal :title="'Delete Article'" :elId="$article->id"
                              :elIdName="$article->id.'A'"
                              :route="'delete_article'">
                <x-slot:text>
                  Are you sure you want to delete this article?<br>
                  <b class="text-error">
                    All data associated with this article (like comments) will be deleted as well!</b><br>
                  Click <b>YES</b> to confirm, <b>NO</b> to cancel.
                </x-slot:text>
              </x-layout.modal>
            </div>
          </div>
        </x-layout.card>
        {{-- Article Content --}}
        <x-layout.card class="p-0 rounded-t-none">
          <div class="p-4 w-auto h-auto bg-darkslategray">
            {!!$article->content!!}
          </div>
        </x-layout.card>
        <div class="divider divider-vertical"></div>
      </div>
    @endif
    @foreach($articleComments as $comment)
      <div class="flex flex-col pb-4 sm:mx-12">
        {{-- Commentator Profile --}}
        <x-layout.card class="bg-dimgray rounded-b-none flex justify-between border-none">
          <div class="flex">
            <div class="avatar">
              <div class="xl:w-16 w-12 h-fit rounded-full">
                <img alt="user avatar" src="{{asset('storage/'.$comment->user->avatar)}}"/>
              </div>
            </div>
            <div class="flex flex-col p-1 pl-4">
              <b class="text-xl break-all">{{$comment->user->username}}</b>
              <span class="flex font-gemunu">
                <small class="{{$comment->user->role == 1 ? 'text-red-400' : 'text-blue-300'}}">
                {{$comment->user->getRoleName($comment->user)}}
                </small>
              </span>
              <div>
                @if($comment->content_updated_at != null)
                  @if($comment->updated_at == $comment->content_updated_at)
                    <p class="text-xs text-secondary pt-1">Edited: {{$comment->updated_at}}</p>
                  @endif
                @endif
              </div>
            </div>
          </div>
          <div class="items-center pl-4 w-auto h-auto">
            <div class="flex items-center justify-end w-26">
              @if($comment->user->id == auth()->user()->id)
                <button id="edit-comment-{{$comment->id}}-btn"
                        class="btn btn-xs btn-ghost h-8 p-1 m-0 mx-2
                    {{session()->has('checked') && session()->get('checked') == $comment->id ? 'bg-primary' : ''}}"
                        onclick="toggleEditComment('edit-comment-{{$comment->id}}',
                   'edit-comment-{{$comment->id}}-btn',
                   'comment-{{$comment->id}}-content')">
                  <x-icons.heroicons.pencil-square/>
                </button>
                <script>
                  function toggleEditComment($commentId, $editBtnId, $commentContentId) {
                    document.getElementById($commentId).classList.toggle('hidden');
                    let editbtn = document.getElementById($editBtnId);
                    if (editbtn.classList.contains('bg-primary')) {
                      editbtn.classList.remove('bg-primary');
                    } else {
                      editbtn.classList.add('bg-primary')
                    }
                    document.getElementById($commentContentId).classList.toggle('hidden');
                  }
                </script>
              @endif
              @if(auth()->user()->role == 1)
                <x-layout.modal-button :elIdName="$comment->id.'Co'">
                  <x-icons.heroicons.trash/>
                </x-layout.modal-button>
              @endif
              {{-- Delete Modal --}}
              <x-layout.modal :title="'Delete Comment'" :elId="$comment->id"
                              :elIdName="$comment->id.'Co'"
                              :route="'delete_comment'">
                <x-slot:text>
                  Are you sure you want to delete this comment?<br>
                  Click <b>YES</b> to confirm, <b>NO</b> to cancel.
                </x-slot:text>
              </x-layout.modal>
            </div>
          </div>
        </x-layout.card>
        {{-- Comment Content --}}
        <x-layout.card class="p-0 rounded-none border-none">
          <div id="comment-{{$comment->id}}-content" class="p-4 w-auto h-auto bg-darkslategray rounded-b
        {{session()->has('checked') && session()->get('checked') == $comment->id ? 'hidden' : ''}}">
            {!!$comment->content!!}
          </div>
          {{-- Edit Comment --}}
          <x-input.editor-with-timeout>
            <div id="edit-comment-{{$comment->id}}"
                 class="{{session()->has('checked') && session()->get('checked') == $comment->id ? '' : 'hidden'}} p-0 m-0">
              <form action="{{route('edit_comment', [$comment->id, $article->id])}}" method="post">
                @csrf
                @method('PUT')
                <x-tinymce.head.tinymce-config :image="'image'"/>
                <x-tinymce.forms.tinymce-editor :name="'edit_comment'">
                  {!!$comment->content!!}
                </x-tinymce.forms.tinymce-editor>
                <x-input.primary-button class="m-2">Update</x-input.primary-button>
                <button class="btn btn-sm btn-ghost m-2 bg-error"
                        type="reset"
                        onclick="toggleEditComment('edit-comment-{{$comment->id}}',
                       'edit-comment-{{$comment->id}}-btn',
                       'comment-{{$comment->id}}-content')">
                  Cancel
                </button>
              </form>
              @error('edit_comment')
              @if(session()->has('checked') && session()->get('checked') == $comment->id)
                <x-informative.error-message class="py-2 mt-2">{{$message}}</x-informative.error-message>
              @endif
              @enderror
            </div>
          </x-input.editor-with-timeout>
        </x-layout.card>
      </div>
    @endforeach
    {{-- Pagination --}}
    @if($articleComments->hasPages())
      <div class="my-4 bg-secondary/10 rounded p-1 mx-12">
        {{ $articleComments->links()}}
      </div>
    @endif
    {{-- Write Comment --}}
    <x-input.editor-with-timeout>
      <x-layout.card>
        <form action="{{route('store_comment', $articleId)}}" method="POST" enctype="multipart/form-data">
          @method('PUT')
          @csrf
          <x-tinymce.head.tinymce-config :image="'image'"/>
          <x-tinymce.forms.tinymce-editor :name="'comment'"/>
          <x-input.primary-button class="m-2">Post Comment</x-input.primary-button>
        </form>
        @error('comment')
        <x-informative.error-message class="py-2 mt-2">{{$message}}</x-informative.error-message>
        @enderror
      </x-layout.card>
    </x-input.editor-with-timeout>
  </x-layout.card>
</x-app-layout>
