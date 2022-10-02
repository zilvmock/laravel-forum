<x-app-layout>
  {{-- All Articles For Selected Topic --}}
  <div class="lg:flex mb-16 w-full justify-center">
    <x-navigation.recent-articles/>
    <x-layout.card class="sm:m-4 p-4 mt-2">
      <x-layout.card class="flex overflow-hidden bg-secondary/10 mb-2">
        <button class="mr-6 btn btn-sm btn-ghost w-max">
          <a href="{{url()->previous()}}">
            <x-icons.heroicons.arrow-uturn-left/>
          </a>
        </button>
        <h1 class="col-start-2 text-lg font-bold">{{$category->title}}</h1>
      </x-layout.card>
      @if(count($articles) == 0)
        <div class="badge badge-info gap-2 sm:m-4 p-4 mt-2">
          <x-icons.daisy.info-circle/>
          No Articles
        </div>
      @else
        @foreach($articles as $article)
          {{-- Category Info --}}
          <div class="flex rounded py-2">
            <div>
              <x-icons.heroicons.chat-bubbles class="w-12"/>
            </div>
            <div class="divider divider-horizontal m-0 mr-2"></div>
            <div class="flex-col w-11/12 pb-2 pr-4">
              <a class="link link-hover font-bold text-secondary text-xl"
                 href="{{route('view-article',['category' => $category, 'article' => $article, 'id' => $article->id])}}">
                {{$article->title}}
              </a>
              <p>{{substr($article->content, 0, 100)}} ...</p>
            </div>
            {{-- Latest comment (or author) in that article --}}
            <a
              class="lg:flex place-items-center w-3/6 p-2 transition hover:bg-gray-300/10 duration-300 rounded lg:text-left text-center"
              href="{{route('view-article',['category' => $category, 'article' => $article, 'id' => $article->id])}}">
              @php($latestComment = $comments->where('article_id', '==', $article->id)->sortByDesc('created_at')->first())
              <div class="avatar lg:pr-2 pr-0">
                <div class="w-12 h-12 rounded-full">
                  <img alt="user avatar"
                       src="{{$latestComment == null ? asset('storage/'.$article->user->avatar)
                                  : asset('storage/'.$latestComment->user->avatar)}}"/>
                </div>
              </div>
              <div class="flex-col pl-2">
                @if($latestComment == null)
                  <b>{{$article->user->username}}</b>
                  <p>{{$article->created_at->format('Y M d, h:i')}}</p>
                @else
                  <b>{{$latestComment->user->username}}</b>
                  <p>{{$latestComment->created_at->format('Y M d, h:i')}}</p>
                @endif
              </div>
            </a>
          </div>
          <div class="divider m-0"></div>
        @endforeach
      @endif
    </x-layout.card>
  </div>
</x-app-layout>
