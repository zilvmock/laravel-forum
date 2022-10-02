<x-app-layout>
  <x-layout.card class="m-4 p-4 w-full sm:w-4/5">
    {{-- Author Profile --}}
    <div class="lg:flex lg:space-x-1 space-y-0">
      <x-layout.card
        class="flex flex-col place-items-center align-cen lg:w-1/6 bg-secondary/20 rounded-b-none lg:rounded">
        <div class="lg:flex-col flex place-items-center">
          <div class="avatar pb-4">
            <div class="xl:w-32 lg:w-16 w-12 h-fit rounded-full">
              <img alt="user avatar"
                   src="{{asset('storage/'.$authorData['avatar'])}}"/>
            </div>
          </div>
          <div class="flex flex-col text-center place-items-center lg:pl-0 pl-6">
            <b class="xl:text-md mb-2"><i>{{$authorData['username']}}</i></b>
            <div class="badge badge-success xl:text-lg mb-2">{{$authorData['rep']}}</div>
            <div class="badge badge-accent xl:text-lg mb-2">{{$authorData['role']}}</div>
            <small class="text-md">Posts: {{$authorData['posts']}}</small>
          </div>
        </div>
      </x-layout.card>
      {{-- Article Content --}}
      <x-layout.card class="relative grid grid-rows-2 w-full min-h-72 bg-secondary/10 rounded-t-none lg:rounded">
        <div>
          <h1 class="text-2xl font-bold text-center shadow-md p-1">{{$article->title}}</h1>
          <p class="p-2 text-lg">{{$article->content}}</p>
        </div>
        <div class="h-auto row-start-2 absolute bottom-0 w-full text-end p-1 pr-6">
          @livewire('like-article', ['article' => $article, 'likes' => $authorData['likes']])
        </div>
      </x-layout.card>
    </div>

    {{-- Commentator Profile --}}
    @foreach($commentsData as $comments)
      @foreach($comments as $comment)
        <div class="lg:flex lg:space-x-1 space-y-0 pt-2">
          <x-layout.card
            class="flex flex-col place-items-center lg:w-1/6 bg-secondary/20 rounded-b-none lg:rounded">
            <div class="lg:flex-col flex place-items-center">
              <div class="avatar pb-4">
                <div class="xl:w-32 lg:w-16 w-12 h-fit rounded-full">
                  <img alt="user avatar" src="{{asset('storage/'.$comment['avatar'])}}"/>
                </div>
              </div>
              <div class="flex flex-col text-center place-items-center lg:pl-0 pl-6">
                <b class="xl:text-md mb-2"><i>{{$comment['username']}}</i></b>
                <div class="badge badge-success xl:text-lg mb-2">{{$comment['rep']}}</div>
                <div class="badge badge-accent xl:text-lg mb-2">{{$comment['role']}}</div>
                <small class="text-md">Posts: {{$comment['posts']}}</small>
              </div>
            </div>
          </x-layout.card>
          {{-- Comment Content --}}
          <x-layout.card class="relative grid grid-rows-2 w-full min-h-72 bg-secondary/10 rounded-t-none lg:rounded">
            <div>
              <p class="p-2 text-lg">{{$comment['content']}}</p>
            </div>
            <div class="h-auto row-start-2 absolute bottom-0 w-full text-end p-1 pr-6">
              @livewire('like-comment', ['comment' => $comment['comment'], 'likes' => $comment['likes']])
            </div>
          </x-layout.card>
        </div>
      @endforeach
    @endforeach
  </x-layout.card>
  <div class="pb-16 w-full sm:w-4/5">
    <x-layout.card>
      <form action="">
        {{--         TODO image upload--}}
        <x-tinymce.head.tinymce-config :image="'image'"/>
        <x-tinymce.forms.tinymce-editor :name="'comment'"/>
        <x-input.primary-button class="m-2">Post Comment</x-input.primary-button>
      </form>


      {{--          <div class="p-1">--}}
      {{--            <input id="x" type="hidden" name="bio" value="{{auth()->user()->bio}}"/>--}}
      {{--            <trix-editor input="x" class="trix-content max-h-40 max-w-2xl overflow-auto">--}}
      {{--              <script src="{{ asset('js/trix.js') }}"></script>--}}
      {{--            </trix-editor>--}}
      {{--          </div>--}}
    </x-layout.card>
  </div>
</x-app-layout>
