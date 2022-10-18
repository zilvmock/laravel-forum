<x-app-layout>
  <div class="w-1/2">
    <div>
      @if($articleComments != null)
        {{ $articleComments->links()}}
      @endif
    </div>
    <x-layout.card class="sm:m-4 p-4 mt-2">
      <x-layout.card class="flex justify-between overflow-hidden bg-secondary/10 mb-2">
        <div class="flex">
          <button class="mr-6 btn btn-sm btn-ghost w-max">
            <a href="{{url()->previous()}}">
              <x-icons.heroicons.arrow-uturn-left/>
            </a>
          </button>
        </div>
      </x-layout.card>
      @if($articleComments->onFirstPage())
        {{-- Author Profile --}}
        <div class="lg:flex lg:space-x-1 space-y-0 pb-12">
          <x-layout.card
            class="flex flex-col place-items-center align-cen lg:w-1/5 bg-secondary/40 rounded-b-none lg:rounded">
            <div class="lg:flex-col flex place-items-center">
              <div class="avatar pb-4">
                <div class="xl:w-32 w-16 h-fit rounded-full">
                  <img alt="user avatar"
                       src="{{asset('storage/'.$article->user->avatar)}}"/>
                </div>
              </div>
              <div class="flex flex-col text-center place-items-center lg:pl-0 pl-6">
                <b class="xl:text-md text-lg mb-2">{{$article->user->username}}</b>
                <div class="badge font-gemunu bg-gradient-to-t
              {{$article->user->role == 1 ? 'from-red-900 to-error' : 'from-primary to-blue-500'}}
               xl:text-lg mb-2 p-3 rounded">
                  {{$article->user->getRole($article->user)}}
                </div>
                <div class="flex">
                  <div class="flex mb-2 pr-2">
                    <x-icons.heroicons.hand-thumb-up class="w-6 mx-1"/>{{$article->user->getReputation($article->user)}}
                  </div>
                  <div class="flex mb-2">
                    <x-icons.heroicons.chat-bubbles class="w-6 mx-1"/>{{$article->user->getNumOfPosts($article->user)}}
                  </div>
                </div>
              </div>
            </div>
          </x-layout.card>
          {{-- Article Content --}}
          <x-layout.card
            class="relative grid grid-rows-2 w-full min-h-72 pl-0 bg-secondary/20 rounded-t-none lg:rounded">
            <div>
              <h1
                class="text-2xl font-bold text-center shadow-md p-1 bg-secondary/30 ml-2 rounded">{{$article->title}}</h1>
              <div class="p-2 text-lg">
                {!!$article->content!!}
              </div>
            </div>
            {{-- Article Content Bottom Bar --}}
            <div class="flex justify-between">
              <div class="flex justify-start h-auto row-start-2 absolute bottom-0 w-full text-end p-1 pr-6">
                @if($article->content_updated_at != null)
                  @if($article->updated_at == $article->content_updated_at)
                    <p class="h-6 text-xs text-secondary pl-2">Edited: {{$article->updated_at}}</p>
                  @endif
                @endif
              </div>
              <div
                class="bg-secondary/30 flex justify-end h-auto row-start-2 absolute bottom-0 w-full text-end p-1 pr-6">
                @if($article->user->id == auth()->user()->id)
                  <form action="{{route('edit-article', $article->id)}}" method="post">
                    @csrf
                    @method('GET')
                    <button class="btn btn-xs btn-ghost h-8" type="submit">
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
                    <b class="text-error">All data associated with this article (like comments) will be deleted as
                      well!</b><br>
                    Click <b>YES</b> to confirm, <b>NO</b> to cancel.
                  </x-slot:text>
                </x-layout.modal>
                @livewire('like-article', ['article' => $article, 'likes' => $article->getLikes($article->id)])
              </div>
            </div>
          </x-layout.card>
        </div>
      @endif
      {{-- Commentator Profile --}}
      @foreach($articleComments as $comment)
        <div class="lg:flex lg:space-x-1 space-y-0 pt-2">
          <x-layout.card
            class="flex flex-col place-items-center lg:w-1/5 bg-secondary/20 rounded-b-none lg:rounded">
            <div class="lg:flex-col flex place-items-center">
              <div class="avatar pb-4">
                <div class="xl:w-32 w-16 h-fit rounded-full">
                  <img alt="user avatar" src="{{asset('storage/'.$comment->user->avatar)}}"/>
                </div>
              </div>
              <div class="flex flex-col text-center place-items-center lg:pl-0 pl-6">
                <b class="xl:text-md text-lg mb-2">{{$comment->user->username}}</b>
                <div class="badge font-gemunu bg-gradient-to-t
              {{$comment->user->role == 1 ? 'from-red-900 to-error' : 'from-primary to-blue-500'}}
               xl:text-lg mb-2 p-3 rounded">
                  {{$comment->user->getRole($comment->user)}}</div>
                <div class="flex">
                  <div class="flex mb-2 pr-2">
                    <x-icons.heroicons.hand-thumb-up class="w-6 mx-1"/>{{$comment->user->getReputation($comment->user)}}
                  </div>
                  <div class="flex mb-2">
                    <x-icons.heroicons.chat-bubbles class="w-6 mx-1"/>{{$comment->user->getNumOfPosts($comment->user)}}
                  </div>
                </div>
              </div>
            </div>
          </x-layout.card>
          {{-- Comment Content --}}
          <x-layout.card
            class="relative pl-0 grid grid-rows-2 w-full min-h-48 bg-secondary/10 rounded-t-none lg:rounded">
            <div class="p-2 text-lg">
              <div id="comment-{{$comment->id}}-content"
                   class="{{session()->has('checked') && session()->get('checked') == $comment->id ? 'hidden' : ''}}">
                {!!$comment->content!!}
              </div>
              <div id="edit-comment-{{$comment->id}}"
                   class="{{session()->has('checked') && session()->get('checked') == $comment->id ? '' : 'hidden'}} p-0 m-0">
                <form action="{{route('edit-comment', [$comment->id, $article->id])}}" method="post">
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
            </div>
            {{-- Comment Content Bottom Bar --}}
            <div class="flex justify-between">
              <div class="flex justify-start h-auto row-start-2 absolute bottom-0 w-full text-end p-1 pr-6">
                @if($comment->content_updated_at != null)
                  @if($comment->updated_at == $comment->content_updated_at)
                    <p class="h-6 text-xs text-secondary pl-2">Edited: {{$comment->updated_at}}</p>
                  @endif
                @endif
              </div>
              <div
                class="bg-secondary/10 flex justify-end h-auto row-start-2 absolute bottom-0 w-full text-end p-1 pr-6">
                @if($comment->user->id == auth()->user()->id)
                  <button id="edit-comment-{{$comment->id}}-btn"
                          class="btn btn-xs btn-ghost h-8
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
                    Are you sure you want to delete this article?<br>
                    <b class="text-error">All data associated with this article (like comments) will be deleted as
                      well!</b><br>
                    Click <b>YES</b> to confirm, <b>NO</b> to cancel.
                  </x-slot:text>
                </x-layout.modal>
                @livewire('like-comment', ['comment' => $comment, 'likes' => $comment->getLikes($comment->id)])
              </div>
            </div>
          </x-layout.card>
        </div>
      @endforeach
    </x-layout.card>
    <div class="pb-16 sm:m-4 p-4 mt-2" style="display:none"
         x-data="{ show: false }"
         x-show="show"
         x-init="setTimeout(() => show = true, 1000)">
      <x-layout.card>
        <form action="{{route('store-comment', $articleId)}}" method="POST" enctype="multipart/form-data">
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
    </div>
  </div>
</x-app-layout>
